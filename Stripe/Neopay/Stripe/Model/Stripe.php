<?php
/**
 * Stripe model
 *
 * @category Neopay
 * @package Neopay_Stripe
 * @author Neo Team
 **/
namespace Neopay\Stripe\Model;

use Neopay\Stripe\Api\Data\StripeInterface;

class Stripe extends \Magento\Framework\Model\AbstractModel implements StripeInterface
{
	/**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'stripe_data';
 
    /**
     * @var string
     */
    protected $_cacheTag = 'stripe_data';
 
    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'stripe_data';
    
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Neopay\Stripe\Model\ResourceModel\Stripe');
    }

    /**
     * Set index id
     * @param int
     */
    function setIndexId($indexId)
    {
    	return $this->setData(self::INDEX_ID,$indexId);
    }

    /**
     * Get index id
     * @return int
     */
    function getIndexId()
    {
    	return $this->getData(self::INDEX_ID);
    }

    /**
     * Set order increment id
     * @param int
     */
    function setOrderIncrementId($orderIncrementId)
    {
    	return $this->setData(self::ORDER_INCREMENT_ID,$orderIncrementId);
    }

    /**
     * Get order increment id
     * @return int
     */
    function getOrderIncrementId()
    {
    	return $this->getData(self::ORDER_INCREMENT_ID);
    }

    /**
     * Set cc type
     * @param int
     */
    function setCcType($ccType)
    {
    	return $this->setData(self::CC_TYPE,$ccType);
    }

    /**
     * Get cc type
     * @return int
     */
    function getCcType()
    {
    	return $this->getData(self::CC_TYPE);
    }

    /**
     * Set cc last 4
     * @param int
     */
    function setCcLast4($ccLast4)
    {
    	return $this->setData(self::CC_LAST_4,$ccLast4);
    }

    /**
     * Get cc last 4
     * @return int
     */
    function getCcLast4()
    {
    	return $this->getData(self::CC_LAST_4);
    }

    /**
     * Set cc cid
     * @param int
     */
    function setCcCid($ccCid)
    {
    	return $this->setData(self::CC_CID,$ccCid);
    }

    /**
     * Get cc cid
     * @return int
     */
    function getCcCid()
    {
    	return $this->getData(self::CC_CID);
    }

    /**
     * Set cc exp month
     * @param int
     */
    function setCcExpMonth($ccExpMonth)
    {
    	return $this->setData(self::CC_EXP_MONTH,$ccExpMonth);
    }

    /**
     * Get Cc exp month
     * @return int
     */
    function getCcExpMonth()
    {
    	return $this->getData(self::CC_EXP_MONTH);
    }

    /**
     * Set cc exp year
     * @param int
     */
    function setCcExpYear($ccExpYear)
    {
    	return $this->setData(self::CC_EXP_YEAR,$CcExpYear);
    }

    /**
     * Get cc exp year
     * @return int
     */
    function getCcExpYear()
    {
    	return $this->getData(self::CC_EXP_YEAR);
    }

    /**
     * Set cc customer email
     * @param string
     */
    function setCcCustomerEmail($ccCustomerEmail)
    {
    	return $this->setData(self::CC_CUSTOMER_EMAIL,$ccCustomerEmail);
    }

    /**
     * Get customer email
     * @return string
     */
    function getCcCustomerEmail()
    {
    	return $this->getData(self::CC_CUSTOMER_EMAIL);
    }

    /**
     * Set stripe secret key
     * @param string
     */
    function setStripeSecretkey($stripeSecretkey)
    {
    	return $this->setData(self::STRIPE_SECRETKEY,$stripeSecretkey);
    }

    /**
     * Get stripe secret key
     * @return string
     */
    function getStripeSecretkey()
    {
    	return $this->getData(self::STRIPE_SECRETKEY);
    }

    /**
     * Set fingerprint
     * @param string
     */
    function setFingerprint($fingerprint)
    {
    	return $this->setData(self::FINGERPRINT,$fingerprint);
    }

    /**
     * Get fingerprint
     * @return string
     */
    function getFingerprint()
    {
    	return $this->getData(self::FINGERPRINT);
    }

    /**
     * Set created
     * @param int
     */
    function setCreated($created)
    {
    	return $this->setData(self::CREATED,$created);
    }

    /**
     * Get created
     * @return int
     */
    function getCreated()
    {
    	return $this->getData(self::CREATED);
    }

    /**
     * Set network status
     * @param string
     */
    function setNetworkStatus($networkStatus)
    {
    	return $this->setData(self::NETWORK_STATUS,$networkStatus);
    }

    /**
     * Get network status
     * @return string
     */
    function getNetworkStatus()
    {
    	return $this->getData(self::NETWORK_STATUS);
    }

    /**
     * Set seller message
     * @param string
     */
    function setSellerMessage($sellerMessage)
    {
    	return $this->setData(self::SELLER_MESSAGE,$sellerMessage);
    }

    /**
     * Get seller message
     * @return string
     */
    function getSellerMessage()
    {
    	return $this->getData(self::SELLER_MESSAGE);
    }

    /**
     * Set stripe account number
     * @param int
     */
    function setStripeAccountNumber($stripeAccountNumber)
    {
    	return $this->setData(self::STRIPE_ACCOUNT_NUMBER,$stripeAccountNumber);
    }

    /**
     * Get stripe account number
     * @return int
     */
    function getStripeAccountNumber()
    {
    	return $this->getData(self::STRIPE_ACCOUNT_NUMBER);
    }

    /**
     * Set stripe account email
     * @param string
     */
    function setStripeAccountEmail($stripeAccountEmail)
    {
    	return $this->setData(self::STRIPE_ACCOUNT_EMAIL,$stripeAccountEmail);
    }

    /**
     * Get stripe account email
     * @return string
     */
    function getStripeAccountEmail()
    {
    	return $this->getData(self::STRIPE_ACCOUNT_EMAIL);
    }
}
?>