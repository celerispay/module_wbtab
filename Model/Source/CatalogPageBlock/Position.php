<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Model\Source\CatalogPageBlock;

/**
 * Class Position
 *
 * @package Aheadworks\Wbtab\Model\Source
 */
class Position implements \Magento\Framework\Option\ArrayInterface
{
    const CONTENT_TOP_VALUE = 'wbtab_content_top';

    const CONTENT_BOTTOM_VALUE = 'wbtab_content_bottom';

    /**
     * Retrieve catalog page block positions as option array.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::CONTENT_TOP_VALUE, 'label' => __('Content top')],
            ['value' => self::CONTENT_BOTTOM_VALUE, 'label' => __('Content bottom')]
        ];
    }
}
