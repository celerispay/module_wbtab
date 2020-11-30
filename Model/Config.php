<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Model;

use Magento\Store\Model\Store;
use Magento\Store\Model\ScopeInterface;

/**
 * Config model
 */
class Config
{
    // Product page settings
    const XML_PRODUCT_PAGE_ENABLE = 'aw_wbtab/product_page/enable';

    const XML_PRODUCT_PAGE_BLOCK_NAME = 'aw_wbtab/product_page/block_name';

    const XML_PRODUCT_PAGE_BLOCK_POSITION = 'aw_wbtab/product_page/block_position';

    const XML_PRODUCT_PAGE_BLOCK_LAYOUT = 'aw_wbtab/product_page/block_layout';

    const XML_PRODUCT_PAGE_PRODUCTS_LIMIT = 'aw_wbtab/product_page/products_limit';

    const XML_PRODUCT_PAGE_DISPLAY_ADD_TO_CART = 'aw_wbtab/product_page/display_add_to_cart';

    // Catalog page settings
    const XML_CATALOG_PAGE_ENABLE = 'aw_wbtab/catalog_page/enable';

    const XML_CATALOG_PAGE_BLOCK_NAME = 'aw_wbtab/catalog_page/block_name';

    const XML_CATALOG_PAGE_BLOCK_POSITION = 'aw_wbtab/catalog_page/block_position';

    const XML_CATALOG_PAGE_BLOCK_LAYOUT = 'aw_wbtab/catalog_page/block_layout';

    const XML_CATALOG_PAGE_PRODUCTS_LIMIT = 'aw_wbtab/catalog_page/products_limit';

    const XML_CATALOG_PAGE_DISPLAY_ADD_TO_CART = 'aw_wbtab/catalog_page/display_add_to_cart';

    // Cart page settings
    const XML_CART_PAGE_ENABLE = 'aw_wbtab/cart_page/enable';

    const XML_CART_PAGE_BLOCK_NAME = 'aw_wbtab/cart_page/block_name';

    const XML_CART_PAGE_BLOCK_POSITION = 'aw_wbtab/cart_page/block_position';

    const XML_CART_PAGE_BLOCK_LAYOUT = 'aw_wbtab/cart_page/block_layout';

    const XML_CART_PAGE_PRODUCTS_LIMIT = 'aw_wbtab/cart_page/products_limit';

    const XML_CART_PAGE_DISPLAY_ADD_TO_CART = 'aw_wbtab/cart_page/display_add_to_cart';

    /**
     * Core store config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Check if WBTAB is enabled on product page
     *
     * @param   null|string|bool|int|Store $store
     * @return  bool
     */
    public function isEnabledOnProductPage($store = null)
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PRODUCT_PAGE_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Get WBTAB block name on product page
     *
     * @param   null|string|bool|int|Store $store
     * @return  string
     */
    public function getNameOnProductPage($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PRODUCT_PAGE_BLOCK_NAME,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Get WBTAB block position on product page
     *
     * @param   null|string|bool|int|Store $store
     * @return  string
     */
    public function getPositionOnProductPage($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PRODUCT_PAGE_BLOCK_POSITION,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Get WBTAB block layout on product page
     *
     * @param   null|string|bool|int|Store $store
     * @return  string
     */
    public function getLayoutOnProductPage($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PRODUCT_PAGE_BLOCK_LAYOUT,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Get WBTAB block products limit on product page
     *
     * @param   null|string|bool|int|Store $store
     * @return  int
     */
    public function getLimitOnProductPage($store = null)
    {
        return (int)$this->scopeConfig->getValue(
            self::XML_PRODUCT_PAGE_PRODUCTS_LIMIT,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Check if "Add to cart" button should be displayed
     * for WBTAB block items on product page
     *
     * @param   null|string|bool|int|Store $store
     * @return  bool
     */
    public function isAddToCartEnabledOnProductPage($store = null)
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PRODUCT_PAGE_DISPLAY_ADD_TO_CART,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Check if WBTAB is enabled on catalog page
     *
     * @param   null|string|bool|int|Store $store
     * @return  bool
     */
    public function isEnabledOnCatalogPage($store = null)
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_CATALOG_PAGE_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Get WBTAB block name on catalog page
     *
     * @param   null|string|bool|int|Store $store
     * @return  string
     */
    public function getNameOnCatalogPage($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_CATALOG_PAGE_BLOCK_NAME,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Get WBTAB block position on catalog page
     *
     * @param   null|string|bool|int|Store $store
     * @return  string
     */
    public function getPositionOnCatalogPage($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_CATALOG_PAGE_BLOCK_POSITION,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Get WBTAB block layout on catalog page
     *
     * @param   null|string|bool|int|Store $store
     * @return  string
     */
    public function getLayoutOnCatalogPage($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_CATALOG_PAGE_BLOCK_LAYOUT,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Get WBTAB block products limit on catalog page
     *
     * @param   null|string|bool|int|Store $store
     * @return  int
     */
    public function getLimitOnCatalogPage($store = null)
    {
        return (int)$this->scopeConfig->getValue(
            self::XML_CATALOG_PAGE_PRODUCTS_LIMIT,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Check if "Add to cart" button should be displayed
     * for WBTAB block items on catalog page
     *
     * @param   null|string|bool|int|Store $store
     * @return  bool
     */
    public function isAddToCartEnabledOnCatalogPage($store = null)
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_CATALOG_PAGE_DISPLAY_ADD_TO_CART,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Check if WBTAB is enabled on cart page
     *
     * @param   null|string|bool|int|Store $store
     * @return  bool
     */
    public function isEnabledOnCartPage($store = null)
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_CART_PAGE_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Get WBTAB block name on cart page
     *
     * @param   null|string|bool|int|Store $store
     * @return  string
     */
    public function getNameOnCartPage($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_CART_PAGE_BLOCK_NAME,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Get WBTAB block position on cart page
     *
     * @param   null|string|bool|int|Store $store
     * @return  string
     */
    public function getPositionOnCartPage($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_CART_PAGE_BLOCK_POSITION,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Get WBTAB block layout on cart page
     *
     * @param   null|string|bool|int|Store $store
     * @return  string
     */
    public function getLayoutOnCartPage($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_CART_PAGE_BLOCK_LAYOUT,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Get WBTAB block products limit on cart page
     *
     * @param   null|string|bool|int|Store $store
     * @return  int
     */
    public function getLimitOnCartPage($store = null)
    {
        return (int)$this->scopeConfig->getValue(
            self::XML_CART_PAGE_PRODUCTS_LIMIT,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Check if "Add to cart" button should be displayed
     * for WBTAB block items on cart page
     *
     * @param   null|string|bool|int|Store $store
     * @return  bool
     */
    public function isAddToCartEnabledOnCartPage($store = null)
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_CART_PAGE_DISPLAY_ADD_TO_CART,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
}
