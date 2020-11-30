<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Block\Wbtab;

use Aheadworks\Wbtab\Model\Source\BlockLayout;
use Aheadworks\Wbtab\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Checkout\Model\ResourceModel\Cart;
use Magento\Checkout\Model\Session;
use Magento\Framework\Module\Manager;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Catalog\Pricing\Price\FinalPrice;
use Magento\Framework\Pricing\Render as PricingRender;

/**
 * Class ProductList
 *
 * @method int|null getProductId()
 * @method string getBlockTitle()
 * @method string getBlockLayout()
 * @method int getProductsLimit()
 * @method bool getDisplayAddToCart()
 *
 * @package Aheadworks\Wbtab\Block\Wbtab
 */
class ProductList extends \Magento\Catalog\Block\Product\ProductList\Related
{
    /**
     * Path to template.
     *
     * @var string
     */
    protected $_template = 'wbtab/product_list.phtml';

    /**
     * Product collection factory
     *
     * @var ProductCollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @var PostHelper
     */
    private $postHelper;

    /**
     * @param Context $context
     * @param Cart $checkoutCart
     * @param Visibility $catalogProductVisibility
     * @param Session $checkoutSession
     * @param Manager $moduleManager
     * @param ProductCollectionFactory $productCollectionFactory
     * @param PostHelper $postHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        Cart $checkoutCart,
        Visibility $catalogProductVisibility,
        Session $checkoutSession,
        Manager $moduleManager,
        ProductCollectionFactory $productCollectionFactory,
        PostHelper $postHelper,
        array $data = []
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->postHelper = $postHelper;
        parent::__construct(
            $context,
            $checkoutCart,
            $catalogProductVisibility,
            $checkoutSession,
            $moduleManager,
            $data
        );
    }

    /**
     * Prepare wbtab product collection
     *
     * @return $this
     */
    protected function _prepareData()
    {
        if (!$productId = $this->getProductId()) {
            return $this;
        }
        /** @var \Aheadworks\Wbtab\Model\ResourceModel\Product\Collection $wbtabCollection */
        $wbtabCollection = $this->productCollectionFactory->create();

        $quoteProductIds = $this->getQuoteProductIds();
        // Limit items only if layout is slider or multiple row grid
        $limit = $this->getBlockLayout() == BlockLayout::SINGLE_ROW_VALUE ?
            null :
            $this->getProductsLimit();
        $wbtabCollection
            ->addAttributeToSelect('required_options')
            ->addAttributeToFilter(
                'visibility',
                ['in' =>
                    [
                        \Magento\Catalog\Model\Product\Visibility::VISIBILITY_IN_CATALOG,
                        \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH
                    ]
                ]
            )
            ->addWbtabFilter($productId, $quoteProductIds, $limit);

        if ($this->moduleManager->isEnabled('Magento_Checkout')) {
            $this->_addProductAttributesAndPrices($wbtabCollection);
        }
        $wbtabCollection->load();

        foreach ($wbtabCollection as $product) {
            $product->setDoNotUseCategoryId(true);
        }
        $this->_itemCollection = $wbtabCollection;
        return $this;
    }

    /**
     * Get mage init script
     *
     * @return string
     */
    public function getDataMageInit()
    {
        switch ($this->getBlockLayout()) {
            case BlockLayout::SLIDER_VALUE:
                $dataMageInit = '{"awWbtabSlider": {}}';
                break;
            case BlockLayout::SINGLE_ROW_VALUE:
                $dataMageInit = '{"awWbtabGrid": {}}';
                break;
            case BlockLayout::MULTIPLE_ROWS_VALUE:
                $dataMageInit = '{}';
                break;
            default:
                $dataMageInit = '{}';
        }
        return $dataMageInit;
    }

    /**
     * Get quote product IDs
     *
     * @return int
     */
    private function getQuoteProductIds()
    {
        $quoteProductIds = [];
        if ($quote = $this->_checkoutSession->getQuote()) {
            foreach ($quote->getAllVisibleItems() as $quoteItem) {
                $quoteProductIds[] = $quoteItem->getProductId();
            }
        }
        return $quoteProductIds;
    }

    /**
     * Get wbtab products
     *
     * @return \Aheadworks\Wbtab\Model\ResourceModel\Product\Collection|[]
     */
    public function getItems()
    {
        if ($this->_itemCollection && $this->_itemCollection->getSize()) {
            return $this->_itemCollection;
        }
        return [];
    }

    /**
     * Return PostHelper object
     *
     * @return PostHelper
     */
    public function getPostDataHelper()
    {
        return $this->postHelper;
    }

    /**
     * Return product price value
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function getProductPrice(\Magento\Catalog\Model\Product $product)
    {
        $priceRender = $this->getLayout()->getBlock('product.price.render.default');
        if (!$priceRender) {
            $priceRender = $this->getLayout()->createBlock(
                PricingRender::class,
                'product.price.render.default',
                ['data' => ['price_render_handle' => 'catalog_product_prices', 'use_link_for_as_low_as' => true]]
            );
        }

        $price = '';
        if ($priceRender) {
            $price = $priceRender->render(
                FinalPrice::PRICE_CODE,
                $product,
                [
                    'include_container' => true,
                    'display_minimal_price' => true,
                    'zone' => PricingRender::ZONE_ITEM_LIST
                ]
            );
        }

        return $price;
    }
}
