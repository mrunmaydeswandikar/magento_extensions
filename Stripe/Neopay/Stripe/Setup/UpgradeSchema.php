<?php
/**
 * Setup the table for module
 *
 * @category Neopay
 * @package Neopay_Stripe
 * @author Neo Team
 **/
namespace Neopay\Stripe\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.0.1') < 0 && $setup->getConnection()->isTableExists("stripe_data") != true){

            $installer->run('create table stripe_data(index_id int not null auto_increment, order_increment_id varchar(100), cc_type varchar(100), cc_last_4 varchar(100), cc_cid varchar(100), cc_exp_month varchar(100), cc_exp_year varchar(100),customer_name varchar(100), stripe_secretkey varchar(100), charge_id varchar(100), fingerprint varchar(100), created varchar(100), network_status varchar(100), seller_message varchar(100), stripe_account_number varchar(100),stripe_account_email varchar(100), primary key(index_id))');
        }

        if (version_compare($context->getVersion(), '1.0.2') < 0){
            $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_payment'),
            'charge_id',
            [
                'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'unsigned'  => true,
                'comment'   => 'ParadoxLabs_TokenBase Card ID',
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_payment'),
            'fingerprint',
            [
                'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'unsigned'  => true,
                'comment'   => 'Stripe Transaction Fingerprint',
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_payment'),
            'transaction_status',
            [
                'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'unsigned'  => true,
                'comment'   => 'Stripe Transaction Status',
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_payment'),
            'network_status',
            [
                'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'unsigned'  => true,
                'comment'   => 'Network Status',
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_payment'),
            'seller_message',
            [
                'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'unsigned'  => true,
                'comment'   => 'Stripe seller message',
            ]
        );
        }

        if (version_compare($context->getVersion(), '1.0.3') < 0){
            $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_payment'),
            'account_holder_email',
            [
                'type'      => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'unsigned'  => true,
                'comment'   => 'Stripe account holder email',
            ]
        );

        }

        if (version_compare($context->getVersion(), '1.0.6') < 0){
            $installer->getConnection()->addColumn(
                $installer->getTable('stripe_data'),
                'customer_email',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 100,
                    'comment' => 'Customer_email'
                ]
            );
        }

        $installer->endSetup();

    }
}