<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Test\Unit\Block\Catalog;

use Aheadworks\Wbtab\Block\Catalog\Wbtab;
use Aheadworks\Wbtab\Model\Config;
use Magento\Checkout\Model\Session;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Quote\Model\Quote;

/**
 * Test for Aheadworks\Wbtab\Block\Catalog\Wbtab
 */
class WbtabTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Wbtab
     */
    private $wbtab;

    /**
     * @var Config|\PHPUnit_Framework_MockObject_MockObject
     */
    private $wbtabConfigMock;

    /**
     * @var Session|\PHPUnit_Framework_MockObject_MockObject
     */
    private $checkoutSessionMock;

    /**
     * Init mocks for tests
     *
     * @return void
     */
    protected function setUp()
    {
        $objectManager = new ObjectManager($this);

        $this->wbtabConfigMock = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->setMethods([])
            ->getMock();
        $this->checkoutSessionMock = $this->getMockBuilder(Session::class)
            ->disableOriginalConstructor()
            ->setMethods([])
            ->getMock();

        $this->wbtab = $objectManager->getObject(
            Wbtab::class,
            [
                'wbtabConfig' => $this->wbtabConfigMock,
                'checkoutSession' => $this->checkoutSessionMock
            ]
        );
    }

    /**
     * Testing of isBlockEnabled method
     */
    public function testIsBlockEnabled()
    {
        $layoutPosition = 'wbtab_content_top';
        $this->wbtab->setNameInLayout($layoutPosition);

        $this->wbtabConfigMock->expects($this->once())
            ->method('isEnabledOnCatalogPage')
            ->willReturn(true);
        $this->wbtabConfigMock->expects($this->once())
            ->method('getPositionOnCatalogPage')
            ->willReturn($layoutPosition);

        $class = new \ReflectionClass($this->wbtab);
        $method = $class->getMethod('isBlockEnabled');
        $method->setAccessible(true);

        $this->assertTrue($method->invoke($this->wbtab));
    }

    /**
     * Testing of getProductId method
     */
    public function testGetProductId()
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

        $class = new \ReflectionClass($this->wbtab);
        $method = $class->getMethod('getProductId');
        $method->setAccessible(true);
        $this->assertEquals($productId, $method->invoke($this->wbtab));
    }

    /**
     * Testing of getBlockTitle method
     */
    public function testGetBlockTitle()
    {
        $title = "Wbtab Test";
        $this->wbtabConfigMock->expects($this->once())
            ->method('getNameOnCatalogPage')
            ->willReturn($title);

        $class = new \ReflectionClass($this->wbtab);
        $method = $class->getMethod('getBlockTitle');
        $method->setAccessible(true);
        $this->assertEquals($title, $method->invoke($this->wbtab));
    }
}
