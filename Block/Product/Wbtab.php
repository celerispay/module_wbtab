<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Block\Product;

use Aheadworks\Wbtab\Block\WbtabAbstract;
use Aheadworks\Wbtab\Model\Config;
use Aheadworks\Wbtab\Model\Source\ProductPageBlock\Position;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Wbtab
 *
 * @package Aheadworks\Wbtab\Block\Product
 */
class Wbtab extends WbtabAbstract
{
    /**
     * Block type
     */
    const BLOCK_TYPE = 'product';

    /**
     * @var Config
     */
    private $wbtabConfig;

    /**
     * @var Registry
     */
    private $coreRegistry;

    /**
     * @var int
     */
    private $productId;

    /**
     * @param Config $wbtabConfig
     * @param Registry $coreRegistry
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Config $wbtabConfig,
        Registry $coreRegistry,
        Context $context,
        array $data = []
    ) {
        $this->wbtabConfig = $wbtabConfig;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function isBlockEnabled()
    {
        return $this->wbtabConfig->isEnabledOnProductPage() &&
        $this->getNameInLayout() == $this->wbtabConfig->getPositionOnProductPage() &&
        $this->getProductId();
    }

    /**
     * {@inheritdoc}
     */
    protected function getProductId()
    {
        if (!$this->productId) {
            /* @var $product \Magento\Catalog\Model\Product */
            $product = $this->coreRegistry->registry('product');
            $this->productId = $product ? $product->getId() : null;
        }
        return $this->productId;
    }

    /**
     * {@inheritdoc}
     */
    protected function getBlockTitle()
    {
        return $this->wbtabConfig->getNameOnProductPage();
    }

    /**
     * {@inheritdoc}
     */
    protected function getBlockLayout()
    {
        return $this->wbtabConfig->getLayoutOnProductPage();
    }

    /**
     * {@inheritdoc}
     */
    protected function getProductsLimit()
    {
        return $this->wbtabConfig->getLimitOnProductPage();
    }

    /**
     * {@inheritdoc}
     */
    protected function isDisplayAddToCart()
    {
        return $this->wbtabConfig->isAddToCartEnabledOnProductPage();
    }

    /**
     * Replace native related block if necessary
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        if ($this->isBlockEnabled() && $this->getNameInLayout() == Position::INSTEAD_NATIVE_VALUE) {
            $this->getLayout()->unsetElement('catalog.product.related');
        }
        return parent::_prepareLayout();
    }

    /**
     * Set product id
     *
     * @param int $productId
     * @return $this
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }
}
