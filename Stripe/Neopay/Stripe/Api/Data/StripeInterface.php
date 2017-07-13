<?php
/**
 * Stripe Interface for Admin grid
 *
 * @category Neopay
 * @package Neopay_Stripe
 * @author Neo Team
 **/
namespace Neopay\Stripe\Api\Data;
 
interface StripeInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const INDEX_ID = 'index_id';
    const ORDER_INCREMENT_ID = "order_increment_id";
    const CC_TYPE = "cc_type";
    const CC_LAST_4 = "cc_last_4";
    const CC_CID = "cc_cid";
    const CC_EXP_MONTH = "cc_exp_month";
    const CC_EXP_YEAR = "cc_exp_year";
    const CUSTOMER_EMAIL = "cc_customer_email";
    const STRIPE_SECRETKEY = "stripe_secretkey";
    const FINGERPRINT = "fingerprint";
    const CREATED = "created";
    const NETWORK_STATUS = "network_status";
    const SELLER_MESSAGE = "seller_message";
    const STRIPE_ACCOUNT_NUMBER = "stripe_account_number";
    const STRIPE_ACCOUNT_EMAIL = "stripe_account_email";
 
    /**
     * Set index id
     * @param int
     */
    function setIndexId($indexId);

    /**
     * Get index id
     * @return int
     */
    function getIndexId();

    /**
     * Set order increment id
     * @param int
     */
    function setOrderIncrementId($order_increment_id);

    /**
     * Get order increment id
     * @return int
     */
    function getOrderIncrementId();

    /**
     * Set cc type
     * @param int
     */
    function setCcType($cc_type);

    /**
     * Get cc type
     * @return int
     */
    function getCcType();

    /**
     * Set cc last 4
     * @param int
     */
    function setCcLast4($cc_last_4);

    /**
     * Get cc last 4
     * @return int
     */
    function getCcLast4();

    /**
     * Set cc cid
     * @param int
     */
    function setCcCid($cc_cid);

    /**
     * Get cc cid
     * @return int
     */
    function getCcCid();

    /**
     * Set cc exp month
     * @param int
     */
    function setCcExpMonth($cc_exp_month);

    /**
     * Get Cc exp month
     * @return int
     */
    function getCcExpMonth();

    /**
     * Set cc exp year
     * @param int
     */
    function setCcExpYear($cc_exp_year);

    /**
     * Get cc exp year
     * @return int
     */
    function getCcExpYear();

    /**
     * Set cc customer email
     * @param string
     */
    function setCcCustomerEmail($cc_customer_email);

    /**
     * Get customer email
     * @return string
     */
    function getCcCustomerEmail();

    /**
     * Set stripe secret key
     * @param string
     */
    function setStripeSecretkey($stripe_secretkey);

    /**
     * Get stripe secret key
     * @return string
     */
    function getStripeSecretkey();

    /**
     * Set fingerprint
     * @param string
     */
    function setFingerprint($fingerprint);

    /**
     * Get fingerprint
     * @return string
     */
    function getFingerprint();

    /**
     * Set created
     * @param int
     */
    function setCreated($created);

    /**
     * Get created
     * @return int
     */
    function getCreated();

    /**
     * Set network status
     * @param string
     */
    function setNetworkStatus($network_status);

    /**
     * Get network status
     * @return string
     */
    function getNetworkStatus();

    /**
     * Set seller message
     * @param string
     */
    function setSellerMessage($seller_message);

    /**
     * Get seller message
     * @return string
     */
    function getSellerMessage();

    /**
     * Set stripe account number
     * @param int
     */
    function setStripeAccountNumber($stripe_account_number);

    /**
     * Get stripe account number
     * @return int
     */
    function getStripeAccountNumber();

    /**
     * Set stripe account email
     * @param string
     */
    function setStripeAccountEmail($stripe_account_email);

    /**
     * Get stripe account email
     * @return string
     */
    //function getStripeAccountEmail();

}