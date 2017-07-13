<?php
/**
 * Stripe admin grid tabs block
 *
 * @category Neopay
 * @package Neopay_Stripe
 * @author Neo Team
 **/

namespace Neopay\Stripe\Block\Adminhtml\Stripelog\View;

/**
 * Tabs Class
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('stripelog_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Stripelog'));
    }
}
