<?php
/**
 * Stripe admin grid tab - Main
 *
 * @category Neopay
 * @package Neopay_Stripe
 * @author Neo Team
 **/

namespace Neopay\Stripe\Block\Adminhtml\Stripelog\View\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

/**
 * Main tab
 */
class Main extends Generic implements TabInterface
{
    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * Main constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        array $data
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
        $this->customerRepository = $customerRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Details');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Details');
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Neopay\Stripe\Model\Stripe $stripe */
        $stripe = $this->_coreRegistry->registry('current_stripelog');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('stripe_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Stripe Response Details')]);

        if ($stripe->getId()) {
            $fieldset->addField('index_id', 'hidden', ['name' => 'index_id']);
        }

        
        $fieldset->addField(
            'order_increment_id',
            'note',
            [
                'name'  => 'order_increment_id',
                'label' => __('Order ID'),
                'title' => __('Order ID'),
                'text' => $stripe->getOrderIncrementId()
            ]
        );

        $fieldset->addField(
            'charge_id',
            'note',
            [
                'name'  => 'charge_id',
                'label' => __('Charge ID'),
                'title' => __('Charge ID'),
                'text' => $stripe->getChargeId(),
                'note' => "Unique transaction id"
            ]
        );
 
        $fieldset->addField(
            'fingerprint',
            'note',
            [
                'name'  => 'fingerprint',
                'label' => __("Fingerprint Key"),
                'title' => __("Fingerprint Key"),
                'text' => $stripe->getFingerprint(),
                'note' => "Unique key defined for each transaction"
            ]
        );

        $fieldset->addField(
            'created',
            'note',
            [
                'name'  => 'created',
                'label' => __("Created ID"),
                'title' => __("Created ID"),
                'text' => $stripe->getCreated()
            ]
        );

        $fieldset->addField(
            'seller_message',
            'note',
            [
                'name'  => 'seller_message',
                'label' => __("Seller Message"),
                'title' => __("Seller Message"),
                'text' => $stripe->getSellerMessage(),
                'note' => "Stripe response message"
            ]
        );

        $fieldset->addField(
            'customer_email',
            'note',
            [
                'name'  => 'customer_email',
                'label' => __("Customer email"),
                'title' => __("Customer email"),
                'text' => $stripe->getCustomerEmail()
            ]
        );
        $form->setValues($stripe->getData());
        $this->setForm($form);

        parent::_prepareForm();

        return $this;
    }
}
