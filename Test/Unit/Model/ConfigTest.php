<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Test\Unit\Model;

use Aheadworks\Wbtab\Model\Config;
use Aheadworks\Wbtab\Model\Source\BlockLayout;
use Aheadworks\Wbtab\Model\Source\CartPageBlock\Position;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Test class for \Aheadworks\Wbtab\Model\Config
 */
class ConfigTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests the methods that rely on the ScopeConfigInterface object to provide their return values
     *
     * @param string $method
     * @param string $path
     * @param bool $configValue
     * @param bool $expectedValue
     * @dataProvider dataProviderScopeConfigMethods
     */
    public function testScopeConfigMethods($method, $path, $configValue, $expectedValue)
    {
        $scopeConfigMock = $this->getMockForAbstractClass(ScopeConfigInterface::class);
        $scopeConfigMock->expects($this->any())
            ->method('getValue')
            ->with($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->will($this->returnValue($configValue));
        $scopeConfigMock->expects($this->any())
            ->method('isSetFlag')
            ->with($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, null)
            ->will($this->returnValue($configValue));

        /** @var \Aheadworks\Wbtab\Model\Config $model */
        $model = new Config($scopeConfigMock);
        $this->assertEquals($expectedValue, $model->{$method}());
    }

    /**
     * @return array
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function dataProviderScopeConfigMethods()
    {
        return [
            [
                'getLayoutOnCartPage',
                Config::XML_CART_PAGE_BLOCK_LAYOUT,
                BlockLayout::SINGLE_ROW_VALUE,
                BlockLayout::SINGLE_ROW_VALUE
            ],
            [
                'getLayoutOnCatalogPage',
                Config::XML_CATALOG_PAGE_BLOCK_LAYOUT,
                BlockLayout::SINGLE_ROW_VALUE,
                BlockLayout::SINGLE_ROW_VALUE
            ],
            [
                'getLayoutOnProductPage',
                Config::XML_PRODUCT_PAGE_BLOCK_LAYOUT,
                BlockLayout::SINGLE_ROW_VALUE,
                BlockLayout::SINGLE_ROW_VALUE
            ],
            [
                'getLimitOnCartPage',
                Config::XML_CART_PAGE_PRODUCTS_LIMIT,
                10,
                10
            ],
            [
                'getLimitOnCatalogPage',
                Config::XML_CATALOG_PAGE_PRODUCTS_LIMIT,
                10,
                10
            ],
            [
                'getLimitOnProductPage',
                Config::XML_PRODUCT_PAGE_PRODUCTS_LIMIT,
                10,
                10
            ],
            [
                'getNameOnCartPage',
                Config::XML_CART_PAGE_BLOCK_NAME,
                'Wbtab On Cart Page',
                'Wbtab On Cart Page'
            ],
            [
                'getNameOnCatalogPage',
                Config::XML_CATALOG_PAGE_BLOCK_NAME,
                'Wbtab On Catalog Page',
                'Wbtab On Catalog Page'
            ],
            [
                'getNameOnProductPage',
                Config::XML_PRODUCT_PAGE_BLOCK_NAME,
                'Wbtab On Product Page',
                'Wbtab On Product Page'
            ],
            [
                'getPositionOnCartPage',
                Config::XML_CART_PAGE_BLOCK_POSITION,
                Position::CONTENT_TOP_VALUE,
                Position::CONTENT_TOP_VALUE
            ],
            [
                'getPositionOnCatalogPage',
                Config::XML_CATALOG_PAGE_BLOCK_POSITION,
                Position::CONTENT_TOP_VALUE,
                Position::CONTENT_TOP_VALUE
            ],
            [
                'getPositionOnProductPage',
                Config::XML_PRODUCT_PAGE_BLOCK_POSITION,
                Position::CONTENT_TOP_VALUE,
                Position::CONTENT_TOP_VALUE
            ],
            [
                'isAddToCartEnabledOnCartPage',
                Config::XML_CART_PAGE_DISPLAY_ADD_TO_CART,
                true,
                true
            ],
            [
                'isAddToCartEnabledOnCatalogPage',
                Config::XML_CATALOG_PAGE_DISPLAY_ADD_TO_CART,
                true,
                true
            ],
            [
                'isAddToCartEnabledOnProductPage',
                Config::XML_PRODUCT_PAGE_DISPLAY_ADD_TO_CART,
                true,
                true
            ],
            [
                'isEnabledOnCartPage',
                Config::XML_CART_PAGE_ENABLE,
                true,
                true
            ],
            [
                'isEnabledOnCatalogPage',
                Config::XML_CATALOG_PAGE_ENABLE,
                true,
                true
            ],
            [
                'isEnabledOnProductPage',
                Config::XML_PRODUCT_PAGE_ENABLE,
                true,
                true
            ]
        ];
    }
}
