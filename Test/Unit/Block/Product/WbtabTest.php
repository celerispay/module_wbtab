<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Test\Unit\Block\Product;

use Aheadworks\Wbtab\Block\Product\Wbtab;
use Aheadworks\Wbtab\Model\Config;
use Magento\Catalog\Model\Product;
use Magento\Framework\Registry;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Test for Aheadworks\Wbtab\Block\Product\Wbtab
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
     * @var Registry|\PHPUnit_Framework_MockObject_MockObject
     */
    private $coreRegistryMock;

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
        $this->coreRegistryMock = $this->getMockBuilder(Registry::class)
            ->disableOriginalConstructor()
            ->setMethods([])
            ->getMock();

        $this->wbtab = $objectManager->getObject(
            Wbtab::class,
            [
                'wbtabConfig' => $this->wbtabConfigMock,
                'coreRegistry' => $this->coreRegistryMock
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
            ->method('isEnabledOnProductPage')
            ->willReturn(true);
        $this->wbtabConfigMock->expects($this->once())
            ->method('getPositionOnProductPage')
            ->willReturn($layoutPosition);
        $productMock = $this->getMockBuilder(Product::class)
            ->disableOriginalConstructor()
            ->setMethods([])
            ->getMock();
        $this->coreRegistryMock->expects($this->once())
            ->method('registry')
            ->with('product')
            ->willReturn($productMock);
        $productMock->expects($this->once())
            ->method('getId')
            ->willReturn('10');

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
        $productMock = $this->getMockBuilder(Product::class)
            ->disableOriginalConstructor()
            ->setMethods([])
            ->getMock();
        $this->coreRegistryMock->expects($this->once())
            ->method('registry')
            ->with('product')
            ->willReturn($productMock);
        $productMock->expects($this->once())
            ->method('getId')
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
            ->method('getNameOnProductPage')
            ->willReturn($title);

        $class = new \ReflectionClass($this->wbtab);
        $method = $class->getMethod('getBlockTitle');
        $method->setAccessible(true);
        $this->assertEquals($title, $method->invoke($this->wbtab));
    }
}
