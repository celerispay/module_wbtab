<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Model\Source\ProductPageBlock;

/**
 * Class Position
 *
 * @package Aheadworks\Wbtab\Model\Source
 */
class Position implements \Magento\Framework\Option\ArrayInterface
{
    const INSTEAD_NATIVE_VALUE = 'wbtab_instead_native';

    const BEFORE_NATIVE_VALUE = 'wbtab_before_native';

    const AFTER_NATIVE_VALUE = 'wbtab_after_native';

    const CONTENT_TOP_VALUE = 'wbtab_content_top';

    const CONTENT_BOTTOM_VALUE = 'wbtab_content_bottom';

    /**
     * Retrieve product page block positions as option array.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::INSTEAD_NATIVE_VALUE, 'label' => __('Instead of native Related Products block')],
            ['value' => self::BEFORE_NATIVE_VALUE, 'label' => __('Before native Related Products block')],
            ['value' => self::AFTER_NATIVE_VALUE, 'label' => __('After native Related Products block')],
            ['value' => self::CONTENT_TOP_VALUE, 'label' => __('Content top')],
            ['value' => self::CONTENT_BOTTOM_VALUE, 'label' => __('Content bottom')]
        ];
    }
}
