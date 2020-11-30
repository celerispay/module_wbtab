<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Block\Cart;

use Aheadworks\Wbtab\Block\WbtabAbstract;
use Aheadworks\Wbtab\Model\Config;
use Aheadworks\Wbtab\Model\Source\CartPageBlock\Position;
use Magento\Checkout\Model\Session;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Wbtab
 *
 * @package Aheadworks\Wbtab\Block\Cart
 */
class Wbtab extends WbtabAbstract
{
    /**
     * Block type
     */
    const BLOCK_TYPE = 'cart';

    /**
     * @var Config
     */
    private $wbtabConfig;

    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * @param Config $wbtabConfig
     * @param Session $checkoutSession
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Config $wbtabConfig,
        Session $checkoutSession,
        Context $context,
        array $data = []
    ) {
        $this->wbtabConfig = $wbtabConfig;
        $this->checkoutSession = $checkoutSession;
        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function isBlockEnabled()
    {
        return $this->wbtabConfig->isEnabledOnCartPage() &&
        $this->getNameInLayout() == $this->wbtabConfig->getPositionOnCartPage();
    }

    /**
     * {@inheritdoc}
     */
    protected function getProductId()
    {
        $productId = null;
        if ($quote = $this->checkoutSession->getQuote()) {
            $items = $quote->getAllVisibleItems();
            if ($quoteItem = array_shift($items)) {
                $productId = $quoteItem->getProductId();
            }
        }
        return $productId;
    }

    /**
     * {@inheritdoc}
     */
    protected function getBlockTitle()
    {
        return $this->wbtabConfig->getNameOnCartPage();
    }

    /**
     * {@inheritdoc}
     */
    protected function getBlockLayout()
    {
        return $this->wbtabConfig->getLayoutOnCartPage();
    }

    /**
     * {@inheritdoc}
     */
    protected function getProductsLimit()
    {
        return $this->wbtabConfig->getLimitOnCartPage();
    }

    /**
     * {@inheritdoc}
     */
    protected function isDisplayAddToCart()
    {
        return $this->wbtabConfig->isAddToCartEnabledOnCartPage();
    }

    /**
     * Replace native cross-sells block if necessary
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        if ($this->isBlockEnabled() && $this->getNameInLayout() == Position::INSTEAD_NATIVE_VALUE) {
            $this->getLayout()->unsetElement('checkout.cart.crosssell');
        }
        return parent::_prepareLayout();
    }
}
