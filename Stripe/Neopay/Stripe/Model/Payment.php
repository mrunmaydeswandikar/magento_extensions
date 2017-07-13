<?php
/**
 * Stripe payment model
 *
 * @category Neopay
 * @package Neopay_Stripe
 * @author Neo team
 **/

namespace Neopay\Stripe\Model;

class Payment extends \Magento\Payment\Model\Method\Cc
{
    const CODE = 'stripepay';

    protected $_code = self::CODE;

    protected $_isGateway                   = true;
    protected $_canCapture                  = true;
    protected $_canCapturePartial           = true;
    protected $_canRefund                   = true;
    protected $_canRefundInvoicePartial     = true;

    protected $_infoBlockType = 'Neopay\Stripe\Block\Payment\Info';
    protected $_stripeApi = false;
    protected $_countryFactory;

    protected $_minAmount = null;
    protected $_maxAmount = null;
    protected $_supportedCurrencyCodes = array('USD');
    protected $_log;
    protected $_stripepayHelper;
    protected $_resourceConfig;
    protected $_stripeFactory;
    protected $_scopeConfig;

    protected $_debugReplacePrivateDataKeys = ['number', 'exp_month', 'exp_year', 'cvc'];

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Payment\Model\Method\Logger $logger,
        \Magento\Framework\Module\ModuleListInterface $moduleList,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Directory\Model\CountryFactory $countryFactory,
        \Stripe\Stripe $stripe,
        \Neopay\Stripe\Helper\Data $stripepayHelper,
        \Magento\Config\Model\ResourceModel\Config $resourceConfig,
        \Neopay\Stripe\Model\StripeFactory $stripeFactory,
        array $data = array()
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $paymentData,
            $scopeConfig,
            $logger,
            $moduleList,
            $localeDate,
            null,
            null,
            $data
        );

        $this->_countryFactory = $countryFactory;

        $this->_stripeApi = $stripe;

        $this->_minAmount = $this->getConfigData('min_order_total');
        $this->_maxAmount = $this->getConfigData('max_order_total');
        $this->_log = $context->getLogger();
        $this->_stripepayHelper = $stripepayHelper;
        $this->_resourceConfig = $resourceConfig;
        $this->_stripeFactory = $stripeFactory;
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * Payment capturing
     *
     * @param \Magento\Payment\Model\InfoInterface $payment
     * @param float $amount
     * @return $this
     * @throws \Magento\Framework\Validator\Exception
     */
    public function capture(\Magento\Payment\Model\InfoInterface $payment, $amount)
    {
        /** @var \Magento\Sales\Model\Order $order **/
        $order = $payment->getOrder();

        /** @var \Magento\Sales\Model\Order\Address $billing **/
        $billing = $order->getBillingAddress();

        /** API key for the stripe account **/
        $apiKey = $this->_scopeConfig->getValue("payment/stripepay/api_key");

        /** Stripe account holder's email **/
        $accountEmail = $this->_scopeConfig->getValue("payment/stripepay/email");

        $this->_stripeApi->setApiKey($apiKey);
        //\Stripe\Stripe::setApiKey($apiKey);
        try {
            $requestData = [
                'amount'        => $amount * 100,
                'currency'      => strtolower($order->getBaseCurrencyCode()),
                'description'   => sprintf('#%s, %s', $order->getIncrementId(), $order->getCustomerEmail()),
                'card'          => [
                    'number'            => $payment->getCcNumber(),
                    'exp_month'         => sprintf('%02d',$payment->getCcExpMonth()),
                    'exp_year'          => $payment->getCcExpYear(),
                    'cvc'               => $payment->getCcCid(),
                    'name'              => $billing->getName(),
                    'address_line1'     => $billing->getStreetLine(1),
                    'address_line2'     => $billing->getStreetLine(2),
                    'address_city'      => $billing->getCity(),
                    'address_zip'       => $billing->getPostcode(),
                    'address_state'     => $billing->getRegion(),
                    'address_country'   => $billing->getCountryId(),
                    // To get full localized country name, use this instead:
                    // 'address_country'   => $this->_countryFactory->create()->loadByCode($billing->getCountryId())->getName(),
                ]
            ];
            $charge = \Stripe\Charge::create($requestData);
            $payment
                ->setTransactionId($charge->id)
                ->setIsTransactionClosed(0);

            $this->saveStripeData($charge,$order->getCustomerEmail(),$order->getIncrementId(),$accountEmail);

            $this->saveAdditionalPaymentData($charge,$payment,$accountEmail);

        } catch (\Exception $e) {
            $this->_log->addDebug('exception'. $e->getMessage());
            $this->_logger->error(__('Payment capturing error.'));
            throw new \Magento\Framework\Validator\Exception(__('Payment capturing error.'));
        }

        return $this;
    }

    /**
     * Payment refund
     *
     * @param \Magento\Payment\Model\InfoInterface $payment
     * @param float $amount
     * @return $this
     * @throws \Magento\Framework\Validator\Exception
     */
    public function refund(\Magento\Payment\Model\InfoInterface $payment, $amount)
    {
        $transactionId = $payment->getParentTransactionId();

        try {
            \Stripe\Charge::retrieve($transactionId)->refund(['amount' => $amount * 100]);
        } catch (\Exception $e) {
            $this->debugData(['transaction_id' => $transactionId, 'exception' => $e->getMessage()]);
            $this->_logger->error(__('Payment refunding error.'));
            throw new \Magento\Framework\Validator\Exception(__('Payment refunding error.'));
        }

        $payment
            ->setTransactionId($transactionId . '-' . \Magento\Sales\Model\Order\Payment\Transaction::TYPE_REFUND)
            ->setParentTransactionId($transactionId)
            ->setIsTransactionClosed(1)
            ->setShouldCloseParentTransaction(1);

        return $this;
    }

    /**
     * Determine method availability based on quote amount and config data
     *
     * @param \Magento\Quote\Api\Data\CartInterface|null $quote
     * @return bool
     */
    public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote = null)
    {
        if ($quote && (
            $quote->getBaseGrandTotal() < $this->_minAmount
            || ($this->_maxAmount && $quote->getBaseGrandTotal() > $this->_maxAmount))
        ) {
            return false;
        }

        if (!$this->getConfigData('api_key')) {
            return false;
        }

        return parent::isAvailable($quote);
    }

    /**
     * Availability for currency
     *
     * @param string $currencyCode
     * @return bool
     */
    public function canUseForCurrency($currencyCode)
    {
        if (!in_array($currencyCode, $this->_supportedCurrencyCodes)) {
            return false;
        }
        return true;
    }

    /**
     * Update the config data of last account used
     *
     * @param Account number
     * @return NULL
     */
    public function updateConfig($accountNumber)
    {
        /**
         * Save used account number, in authorize account stack
         */
        $this->_resourceConfig->saveConfig('stripepay_section/roundrobin_group/previous_account_used',$accountNumber,'default','0');
    }

    /**
     * Save the stripe-response 
     *
     * @param \Stripe\Chage object
     * @param Customer name
     * @return NULL
     */
    public function saveStripeData($charge,$customerEmail,$orderIncrementId,$email)
    {
        /**
         * Save used account number, in authorize account stack
         */
        try{
            $model = $this->_stripeFactory->create();
            $model->setData("order_increment_id",$orderIncrementId);
            $model->setData("cc_type",$charge->source->brand);
            $model->setData("cc_last_4","XXXX-".$charge->source->last4);
            $model->setData("cc_cid","");
            $model->setData("cc_exp_year",$charge->source->exp_year);
            $model->setData("cc_exp_month",$charge->source->exp_month);
            $model->setData("charge_id",$charge->id);
            $model->setData("fingerprint",$charge->source->fingerprint);
            $model->setData("created",$charge->created);
            $model->setData("transaction_status",$charge->status);
            $model->setData("network_status",$charge->outcome->network_status);
            $model->setData("seller_message",$charge->outcome->seller_message);
            $model->setData("customer_email",$customerEmail);
            $model->setData("stripe_account_email",$email);
            $model->save();
        }
        catch(Exception $e){
            $this->_log->addDebug("Exception at \Neopay\Stripe\Model\Payment::saveStripeData :".$e->getMessage());
        }
        
    } 

    /**
     * Save the stripe-payment response in order-payment
     *
     * @param \Stripe\Chage
     * @param \Magento\Payment\Model\InfoInterface
     * @param String
     * @return NULL
     */
    public function saveAdditionalPaymentData($charge,$payment,$email)
    {
        /**
         * Save used account number, in authorize account stack
         */
        try{
            $payment->setData("charge_id",$charge->id);
            $payment->setData("fingerprint",$charge->source->fingerprint);
            $payment->setData("transaction_status",$charge->status);
            $payment->setData("network_status",$charge->outcome->network_status);
            $payment->setData("seller_message",$charge->outcome->seller_message);
            $payment->setData("account_holder_email",$email);
        }
        catch(Exception $e){
            $this->_log->addDebug("Exception at \Neopay\Stripe\Model\Payment::saveAdditionalPaymentData :".$e->getMessage());
        }
    } 
}