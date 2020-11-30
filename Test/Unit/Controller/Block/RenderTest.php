<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Test\Unit\Controller;

use Aheadworks\Wbtab\Controller\Block\Render;
use Aheadworks\Wbtab\Block\Catalog\Wbtab as WbtabCatalog;
use Aheadworks\Wbtab\Block\Cart\Wbtab as WbtabCart;
use Aheadworks\Wbtab\Block\Product\Wbtab as WbtabProduct;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\Translate\InlineInterface as TranslateInlineInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ViewInterface;
use Magento\Framework\View\Layout;
use Magento\Framework\DataObject;
use Magento\Framework\DataObjectFactory;

/**
 * Test for Aheadworks\Wbtab\Controller\Render
 */
class RenderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Render
     */
    private $controller;

    /**
     * @var Context|\PHPUnit_Framework_MockObject_MockObject
     */
    private $contextMock;

    /**
     * @var RequestInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $requestMock;

    /**
     * @var ResponseInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $responseMock;

    /**
     * @var RedirectFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $resultRedirectFactoryMock;

    /**
     * @var ViewInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $viewMock;

    /**
     * @var TranslateInlineInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $translateInlineMock;

    /**
     * @var DataObjectFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $dataObjectFactoryMock;

    /**
     * Init mocks for tests
     *
     * @return void
     */
    protected function setUp()
    {
        $objectManager = new ObjectManager($this);

        $this->requestMock = $this->getMockBuilder(RequestInterface::class)
            ->setMethods(
                [
                    'isAjax',
                    'getParam',
                    'getRouteName',
                    'getControllerName',
                    'getActionName',
                    'getRequestUri',
                    'setRouteName',
                    'setControllerName',
                    'setActionName',
                    'setRequestUri'
                ]
            )
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $this->responseMock = $this->getMockBuilder(ResponseInterface::class)
            ->setMethods(['appendBody'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $this->resultRedirectFactoryMock = $this->getMockBuilder(RedirectFactory::class)
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->viewMock = $this->getMockBuilder(ViewInterface::class)
            ->setMethods(['getLayout'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->contextMock = $objectManager->getObject(
            Context::class,
            [
                'request' => $this->requestMock,
                'response' => $this->responseMock,
                'resultRedirectFactory' => $this->resultRedirectFactoryMock,
                'view' => $this->viewMock
            ]
        );

        $this->translateInlineMock = $this->getMockBuilder(TranslateInlineInterface::class)
            ->setMethods(['processResponseBody'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $this->dataObjectFactoryMock = $this->getMockBuilder(DataObjectFactory::class)
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->controller = $objectManager->getObject(
            Render::class,
            [
                'context' => $this->contextMock,
                'translateInline' => $this->translateInlineMock,
                'dataObjectFactory' => $this->dataObjectFactoryMock,
            ]
        );
    }

    /**
     * Testing of execute method if it is not ajax request
     */
    public function testExecuteNoAjax()
    {
        $this->requestMock->expects($this->once())
            ->method('isAjax')
            ->willReturn(false);

        $resultRedirectMock = $this->getMockBuilder(Redirect::class)
            ->setMethods(['setRefererOrBaseUrl'])
            ->disableOriginalConstructor()
            ->getMock();
        $resultRedirectMock->expects($this->once())
            ->method('setRefererOrBaseUrl')
            ->willReturnSelf();
        $this->resultRedirectFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($resultRedirectMock);

        $this->assertSame($resultRedirectMock, $this->controller->execute());
    }

    /**
     * Testing of execute method
     */
    public function testExecute()
    {
        $productId = 10;
        $blocksParam = '[{"name":"position1","type":"catalog"},{"name":"position2","type":"cart"},'.
            '{"name":"position3","type":"product"}]';
        $catalogContent = 'catalog content';
        $cartContent = 'cart content';
        $productContent = 'product content';
        $resultBlocks = '{"position1":"'.$catalogContent.'","position2":"'.$cartContent.'","position3":"'.
            $productContent.'"}';

        $this->requestMock->expects($this->once())
            ->method('isAjax')
            ->willReturn(true);

        $this->requestMock->expects($this->any())
            ->method('getParam')
            ->willReturnMap(
                [
                    ['blocks', null, $blocksParam],
                    ['originalRequest', null, ''],
                    ['id', null, $productId]
                ]
            );

        $dataObject = $this->getMockBuilder(DataObject::class)
            ->setMethods([])
            ->disableOriginalConstructor()
            ->getMock();
        $this->dataObjectFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($dataObject);

        $catalogBlockMock = $this->getMockBuilder(WbtabCatalog::class)
            ->setMethods(['setNameInLayout', 'toHtml'])
            ->disableOriginalConstructor()
            ->getMock();
        $catalogBlockMock->expects($this->once())
            ->method('toHtml')
            ->willReturn($catalogContent);
        $cartBlockMock = $this->getMockBuilder(WbtabCart::class)
            ->setMethods(['setNameInLayout', 'toHtml'])
            ->disableOriginalConstructor()
            ->getMock();
        $cartBlockMock->expects($this->once())
            ->method('toHtml')
            ->willReturn($cartContent);
        $productBlockMock = $this->getMockBuilder(WbtabProduct::class)
            ->setMethods(['setNameInLayout', 'toHtml', 'setProductId'])
            ->disableOriginalConstructor()
            ->getMock();
        $productBlockMock->expects($this->once())
            ->method('toHtml')
            ->willReturn($productContent);
        $productBlockMock->expects($this->once())
            ->method('setProductId')
            ->with($productId)
            ->willReturnSelf();

        $layoutMock = $this->getMockBuilder(Layout::class)
            ->setMethods(['createBlock'])
            ->disableOriginalConstructor()
            ->getMock();
        $layoutMock->expects($this->at(0))
            ->method('createBlock')
            ->willReturn($catalogBlockMock);
        $layoutMock->expects($this->at(1))
            ->method('createBlock')
            ->willReturn($cartBlockMock);
        $layoutMock->expects($this->at(2))
            ->method('createBlock')
            ->willReturn($productBlockMock);
        $this->viewMock->expects($this->once())
            ->method('getLayout')
            ->willReturn($layoutMock);

        $this->responseMock->expects($this->once())
            ->method('appendBody')
            ->with($resultBlocks)
            ->willReturnSelf();

        $this->assertSame(null, $this->controller->execute());
    }
}
