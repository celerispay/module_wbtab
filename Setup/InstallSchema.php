<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 *
 * @package Aheadworks\Wbtab\Setup
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        /**
         * Create table 'aw_wbtab_product'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('aw_wbtab_product'))
            ->addColumn(
                'product_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'primary' => true],
                'Product Id'
            )->addColumn(
                'related_product_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'primary' => true],
                'Related Product Id'
            )->addColumn(
                'store_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'primary' => true],
                'Store Id'
            )->addColumn(
                'orders_count',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Orders Count'
            )->addIndex(
                $installer->getIdxName('aw_wbtab_product', ['product_id']),
                ['product_id']
            )->addIndex(
                $installer->getIdxName('aw_wbtab_product', ['related_product_id']),
                ['related_product_id']
            )->addIndex(
                $installer->getIdxName('aw_wbtab_product', ['store_id']),
                ['store_id']
            )->addIndex(
                $installer->getIdxName('aw_wbtab_product', ['orders_count']),
                ['orders_count']
            )->addForeignKey(
                $installer->getFkName('aw_wbtab_product', 'product_id', 'catalog_product_entity', 'entity_id'),
                'product_id',
                $installer->getTable('catalog_product_entity'),
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName('aw_wbtab_product', 'related_product_id', 'catalog_product_entity', 'entity_id'),
                'related_product_id',
                $installer->getTable('catalog_product_entity'),
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName('aw_wbtab_product', 'store_id', 'store', 'store_id'),
                'store_id',
                $installer->getTable('store'),
                'store_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->setComment('Wbtab Product Index');
        $installer->getConnection()->createTable($table);

        /**
         * Create table 'aw_wbtab_product_idx'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('aw_wbtab_product_idx'))
            ->addColumn(
                'product_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'primary' => true],
                'Product Id'
            )->addColumn(
                'related_product_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false, 'primary' => true],
                'Related Product Id'
            )->addColumn(
                'store_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'primary' => true],
                'Store Id'
            )->addColumn(
                'orders_count',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Orders Count'
            )->addIndex(
                $installer->getIdxName('aw_wbtab_product_idx', ['product_id']),
                ['product_id']
            )->addIndex(
                $installer->getIdxName('aw_wbtab_product_idx', ['related_product_id']),
                ['related_product_id']
            )->addIndex(
                $installer->getIdxName('aw_wbtab_product_idx', ['store_id']),
                ['store_id']
            )->addIndex(
                $installer->getIdxName('aw_wbtab_product_idx', ['orders_count']),
                ['orders_count']
            )->setComment('Wbtab Product Index Idx');
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
