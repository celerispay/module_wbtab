<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Model\Source;

/**
 * Class BlockLayout
 *
 * @package Aheadworks\Wbtab\Model\Source
 */
class BlockLayout implements \Magento\Framework\Option\ArrayInterface
{
    const SINGLE_ROW_VALUE = 'single_row';

    const MULTIPLE_ROWS_VALUE = 'multiple_rows';

    const SLIDER_VALUE = 'slider';

    /**
     * Retrieve block layout types as option array.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::SINGLE_ROW_VALUE, 'label' => __('Products aligned in single row')],
            ['value' => self::MULTIPLE_ROWS_VALUE, 'label' => __('Products aligned in multiple rows')],
            ['value' => self::SLIDER_VALUE, 'label' => __('Slider')]
        ];
    }
}
