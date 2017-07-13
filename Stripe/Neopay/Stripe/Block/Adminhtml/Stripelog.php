<?php
/**
 * Stripe admin block
 *
 * @category Neopay
 * @package Neopay_Stripe
 * @author Neo Team
 **/

namespace Neopay\Stripe\Block\Adminhtml;

class Stripelog extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_stripelog';
        $this->_blockGroup = 'Neopay_Stripe';
        $this->_headerText = __('Stripe log');
        //$this->_addButtonLabel = __('Create New Post');
        parent::_construct();
        $this->removeButton('add');
    }
}

