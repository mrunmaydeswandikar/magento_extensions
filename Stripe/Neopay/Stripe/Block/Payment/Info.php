<?php
/**
 * Adds additional information in Sales/Order Payment block in Admin end
 *
 * @category Neopay
 * @package Neopay_Stripe
 * @author Neo Team
 **/

namespace Neopay\Stripe\Block\Payment;

/**
 * Credit card info block
 */
class Info extends \Magento\Payment\Block\Info\Cc
{

    /**
     * Prepare credit card related payment info
     *
     * @param \Magento\Framework\Object|array $transport
     * @return \Magento\Framework\Object
     */
    protected function _prepareSpecificInformation($transport = null)
    {
        $transport  = parent::_prepareSpecificInformation($transport);
        $data       = [];

        if ($this->getIsSecureMode() === false) {
            /** @var \Magento\Sales\Model\Order\Payment\Info $info */
            $info = $this->getInfo();

            $chargeId = $info->getData('charge_id');

            $fingerprint = $info->getData('fingerprint');

            $transactionStatus = $info->getData('transaction_status');

            $networkStatus = $info->getData("network_status");

            $sellerMessage = $info->getData("seller_message");

            /**
             * Prepare data array to set payment data
             */
            $data["Charge ID"] = $chargeId;

            $data["Fingerprint"] = $fingerprint;

            $data["Transaction Status"] = $transactionStatus;

            $data["Network Status"] = $networkStatus;

            $data["Seller Message"] = $sellerMessage;
        }

        $transport->setData(array_merge($transport->getData(), $data));

        return $transport;
    }
}
