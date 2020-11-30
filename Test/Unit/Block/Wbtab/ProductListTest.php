<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Test\Unit\Block\Wbtab;

use Aheadworks\Wbtab\Block\Wbtab\ProductList;
use Aheadworks\Wbtab\Model\ResourceModel\Product\Collection as WbtabCollection;
use Aheadworks\Wbtab\Model\Source\BlockLayout;
use Aheadworks\Wbtab\Model\ResourceModel\Product\CollectionFactory;
use Magento\Checkout\Model\Session;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Quote\Model\Quote;

/**
 * Test for Aheadworks\Wbtab\Block\Wbtab\ProductList
 */
class ProductListTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var CollectionFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $productCollectionFactoryMock;

    /**
     * @var ProductList
     */
    private $productList;

    /**
     * @var Session|\PHPUnit_Framework_MockObject_MockObject
     */
    private $checkoutSessionMock;

    /**
     * @var \Magento\Framework\Module\Manager|\PHPUnit_Framework_MockObject_MockObject
     */
    private $moduleManagerMock;

    /**
     * Init mocks for tests
     *
     * @return void
     */
    protected function setUp()
    {
        $objectManager = new ObjectManager($this);

        $this->checkoutSessionMock = $this->getMockBuilder(Session::class)
            ->disableOriginalConstructor()
            ->setMethods([])
            ->getMock();
        $this->productCollectionFactoryMock = $this->getMockBuilder(CollectionFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $this->moduleManagerMock = $this->getMockBuilder(\Magento\Framework\Module\Manager::class)
            ->disableOriginalConstructor()
            ->setMethods([])
            ->getMock();

        $this->productList = $objectManager->getObject(
            ProductList::class,
            [
                'checkoutSession' => $this->checkoutSessionMock,
                'moduleManager' => $this->moduleManagerMock,
                'productCollectionFactory' => $this->productCollectionFactoryMock,
            ]
        );
    }

    /**
     * Testing of _prepareData method
     */
    public function testPrepareData()
    {
        $productId = 10;
        $this->productList->setProductId($productId);

        $collectionMock = $this->getMockBuilder(WbtabCollection::class)
            ->disableOriginalConstructor()
            ->setMethods(['addAttributeToSelect', 'addWbtabFilter', 'load'])
            ->getMock();
        $this->productCollectionFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($collectionMock);
        $collectionMock->expects($this->once())
            ->method('addAttributeToSelect')
            ->with('required_options')
            ->willReturnSelf();
        $collectionMock->expects($this->once())
            ->method('addAttributeToFilter')
            ->with(
                'visibility',
                ['in' =>
                    [
                        \Magento\Catalog\Model\Product\Visibility::VISIBILITY_IN_CATALOG,
                        \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH
                    ]
                ]
            )
            ->willReturnSelf();
        $collectionMock->expects($this->once())
            ->method('addWbtabFilter')
            ->with($productId, [], null)
            ->willReturnSelf();
        $this->moduleManagerMock->expects($this->once())
            ->method('isEnabled')
            ->with('Magento_Checkout')
            ->willReturn(false);
        $collectionMock->method('load')
            ->willReturnSelf();
        $class = new \ReflectionClass($this->productList);
        $method = $class->getMethod('_prepareData');
        $method->setAccessible(true);
        $this->assertEquals($this->productList, $method->invoke($this->productList));
    }

    /**
     * Testing of getDataMageInit method
     */
    public function testGetDataMageInit()
    {
        $this->productList->setBlockLayout(BlockLayout::SLIDER_VALUE);
        $class = new \ReflectionClass($this->productList);
        $method = $class->getMethod('getDataMageInit');
        $method->setAccessible(true);
        $this->assertEquals('{"awWbtabSlider": {}}', $method->invoke($this->productList));
    }

    /**
     * Testing of getQuoteProductIds method
     */
    public function testGetQuoteProductIds()
    {
        $productId = 10;

        $quoteMock = $this->getMockBuilder(Quote::class)
            ->disableOriginalConstructor()
            ->setMethods([])
            ->getMock();
        $this->checkoutSessionMock->expects($this->once())
            ->method('getQuote')
            ->willReturn($quoteMock);
        $itemMock = $this->getMockBuilder(\Magento\Quote\Model\Quote\Item::class)
            ->disableOriginalConstructor()
            ->setMethods(['getProductId'])
            ->getMock();
        $quoteMock->expects($this->once())
            ->method('getAllVisibleItems')
            ->willReturn([$itemMock]);
        $itemMock->expects($this->once())
            ->method('getProductId')
            ->willReturn($productId);

        $class = new \ReflectionClass($this->productList);
        $method = $class->getMethod('getQuoteProductIds');
        $method->setAccessible(true);
        $this->assertEquals([$productId], $method->invoke($this->productList));
    }
}
