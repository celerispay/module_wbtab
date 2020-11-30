<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Test\Unit\Block\Wbtab;

use Aheadworks\Wbtab\Block\Wbtab\Ajax as WbtabAjax;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\App\RequestInterface;

/**
 * Test for Aheadworks\Wbtab\Block\Wbtab\Ajax
 */
class AjaxTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var WbtabAjax
     */
    private $block;

    /**
     * @var Context|\PHPUnit_Framework_MockObject_MockObject
     */
    private $contextMock;

    /**
     * @var RequestInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $requestMock;

    /**
     * @var UrlInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $urlBuilderMock;

    /**
     * Init mocks for tests
     *
     * @return void
     */
    protected function setUp()
    {
        $objectManager = new ObjectManager($this);

        $this->requestMock = $this->getMockBuilder(RequestInterface::class)
            ->setMethods(['getRouteName', 'getControllerName', 'getActionName', 'getRequestUri'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $this->urlBuilderMock = $this->getMockBuilder(UrlInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->contextMock = $objectManager->getObject(
            Context::class,
            [
                'urlBuilder' => $this->urlBuilderMock,
                'request' => $this->requestMock
            ]
        );

        $this->block = $objectManager->getObject(
            WbtabAjax::class,
            [
                'context' => $this->contextMock
            ]
        );
    }

    /**
     * Testing of getScriptOptions method
     */
    public function testGetScriptOptions()
    {
        $isSecure = false;
        $routeName = 'catalog';
        $controllerName = 'category';
        $actionName = 'view';
        $requestUri = '/index.php/gear/bags.html';
        $route = 'aw_wbtab/block/render/';
        $params = [
            '_current' => true,
            '_secure' => $isSecure
        ];
        $url = 'http://ecommerce.aheadworks.com/aw_wbtab/block/render/id/1369/';
        $expected = '{"url":"http:\/\/ecommerce.aheadworks.com\/aw_wbtab\/block\/render\/id\/1369\/",'
            . '"originalRequest":{"route":"catalog","controller":"category",'
            . '"action":"view","uri":"\/index.php\/gear\/bags.html"}}';

        $this->requestMock->expects($this->once())
            ->method('isSecure')
            ->willReturn($isSecure);
        $this->requestMock->expects($this->once())
            ->method('getRouteName')
            ->willReturn($routeName);
        $this->requestMock->expects($this->once())
            ->method('getControllerName')
            ->willReturn($controllerName);
        $this->requestMock->expects($this->once())
            ->method('getActionName')
            ->willReturn($actionName);
        $this->requestMock->expects($this->once())
            ->method('getRequestUri')
            ->willReturn($requestUri);

        $this->urlBuilderMock->expects($this->once())
            ->method('getUrl')
            ->with($route, $params)
            ->willReturn($url);

        $this->assertEquals(
            $expected,
            $this->block->getScriptOptions()
        );
    }
}
