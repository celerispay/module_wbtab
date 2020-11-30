<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Model\ResourceModel\Product;

use \Magento\Sales\Model\Order;

/**
 * Class Collection
 *
 * @package Aheadworks\Wbtab\Model\ResourceModel\Product
 */
class Collection extends \Magento\Catalog\Model\ResourceModel\Product\Collection
{
    /**
     * Default products limit
     */
    const DEFAULT_LIMIT = 10;

    /**
     * Add wbtab filter
     *
     * @param int $productId
     * @param array $inCartProductIds
     * @param int $limit
     * @return $this
     */
    public function addWbtabFilter($productId, $inCartProductIds, $limit = self::DEFAULT_LIMIT)
    {
        $select = $this->getConnection()->select();
        $select->from(['wpi' => $this->getTable('aw_wbtab_product')], '')
            ->columns(
                [
                    'wbtab_product_id' => 'wpi.related_product_id',
                    'rating' => 'wpi.orders_count'
                ]
            )
            ->where('wpi.product_id = ?', $productId)
              /** Bugfix 
               *  Duplicate products issue in multiple store 
               */
            ->where('wpi.store_id = ?',$this->getStoreId())
           ;
           
        if ($inCartProductIds) {
            $excludeProductsInCartCondition = $this->getConnection()
                ->prepareSqlCondition('wpi.related_product_id', ['nin' => $inCartProductIds]);
            $select->where($excludeProductsInCartCondition);
        }

        $this->getSelect()
            ->join(
                ['wbtab' => $select],
                'wbtab.wbtab_product_id = e.entity_id',
                ['rating' => 'wbtab.rating']
            )
            ->order('wbtab.rating DESC')
            ->limit($limit);
        return $this;
    }
}
