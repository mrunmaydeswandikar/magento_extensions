<?php
/**
 * Stripe collection
 *
 * @category Neopay
 * @package Neopay_Stripe
 * @author Neo Team
 **/

namespace Neopay\Stripe\Model\ResourceModel\Stripe;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Neopay\Stripe\Model\Stripe', 'Neopay\Stripe\Model\ResourceModel\Stripe');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>