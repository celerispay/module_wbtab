<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Block\Catalog;

use Aheadworks\Wbtab\Block\WbtabAbstract;
use Aheadworks\Wbtab\Model\Config;
use Magento\Checkout\Model\Session;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Wbtab
 *
 * @package Aheadworks\Wbtab\Block\Catalog
 */
class Wbtab extends WbtabAbstract
{
    /**
     * Block type
     */
    const BLOCK_TYPE = 'catalog';

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
        return $this->wbtabConfig->isEnabledOnCatalogPage() &&
        $this->getNameInLayout() == $this->wbtabConfig->getPositionOnCatalogPage();
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
        return $this->wbtabConfig->getNameOnCatalogPage();
    }

    /**
     * {@inheritdoc}
     */
    protected function getBlockLayout()
    {
        return $this->wbtabConfig->getLayoutOnCatalogPage();
    }

    /**
     * {@inheritdoc}
     */
    protected function getProductsLimit()
    {
        return $this->wbtabConfig->getLimitOnCatalogPage();
    }

    /**
     * {@inheritdoc}
     */
    protected function isDisplayAddToCart()
    {
        return $this->wbtabConfig->isAddToCartEnabledOnCatalogPage();
    }
}
