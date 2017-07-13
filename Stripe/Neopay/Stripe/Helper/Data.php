<?php
/**
 * Stripe helper
 *
 * @category Neopay
 * @package Neopay_Stripe
 * @author Neo Team
 **/

namespace Neopay\Stripe\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\App\Helper\Context::getScopeConfig
     */
    protected $_scopeConfig;
    
    /**
     * @var \Magento\Framework\App\Helper\Context::getLogger
     */
    protected $_log;
    
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $_orderCollection;
    
    /**
     * @param \Magento\Framework\App\Helper\Context
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    public function __construct(\Magento\Framework\App\Helper\Context $context, \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollection) {
        $this->_scopeConfig     = $context->getScopeConfig();
        $this->_log             = $context->getLogger();
        $this->_orderCollection = $orderCollection;
        parent::__construct($context);
    }
} 