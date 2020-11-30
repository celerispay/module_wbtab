<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Block;

use Aheadworks\Wbtab\Block\Wbtab\ProductList;

/**
 * Class WbtabAbstract
 *
 * @package Aheadworks\Wbtab\Block
 */
abstract class WbtabAbstract extends \Magento\Framework\View\Element\Template
{
    /**
     * Block type
     */
    const BLOCK_TYPE = '';

    /**
     * Path to template.
     *
     * @var string
     */
    protected $_template = 'wbtab/placeholder.phtml';

    /**
     * {@inheritdoc}
     */
    protected function _toHtml()
    {
        if ($this->isBlockEnabled()) {
            if ($this->isAjax()) {
                $wbtabData = [
                    'product_id' => $this->getProductId(),
                    'block_title' => $this->getBlockTitle(),
                    'block_layout' => $this->getBlockLayout(),
                    'products_limit' => $this->getProductsLimit(),
                    'display_add_to_cart' => $this->isDisplayAddToCart()
                ];
                return $this->getLayout()
                    ->createBlock(ProductList::class)
                    ->setData($wbtabData)
                    ->toHtml();
            } else {
                return parent::_toHtml();
            }
        }
        return '';
    }

    /**
     * Is block enabled
     *
     * @return boolean
     */
    abstract protected function isBlockEnabled();

    /**
     * Return product ID
     *
     * @return int|null
     */
    abstract protected function getProductId();

    /**
     * Get block title
     *
     * @return string
     */
    abstract protected function getBlockTitle();

    /**
     * Get block layout
     *
     * @return string
     */
    abstract protected function getBlockLayout();

    /**
     * Get products limit
     *
     * @return int
     */
    abstract protected function getProductsLimit();

    /**
     * Check whether Add to cart button should be displayed
     *
     * @return bool
     */
    abstract protected function isDisplayAddToCart();

    /**
     * Is ajax request or not
     *
     * @return bool
     */
    public function isAjax()
    {
        return $this->_request->isAjax();
    }

    /**
     * Get block type
     *
     * @return string
     */
    public function getBlockType()
    {
        return $this::BLOCK_TYPE;
    }
}
