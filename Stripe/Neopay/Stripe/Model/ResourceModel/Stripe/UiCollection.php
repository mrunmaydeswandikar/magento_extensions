<?php
/**
 * Stripe collection for Admin grid
 *
 * @category Neopay
 * @package Neopay_Stripe
 * @author Neo Team
 **/

namespace Neopay\Stripe\Model\ResourceModel\Stripe;

/**
 * UiCollection Class
 */
class UiCollection extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{
    /**
     * Init collection select
     *
     * @return $this
     */
    protected function _initSelect()
    {
        parent::_initSelect();

        return $this;
    }
}
