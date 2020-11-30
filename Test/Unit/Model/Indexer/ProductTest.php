<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Test\Unit\Model\Indexer;

use Aheadworks\Wbtab\Model\Indexer\Product as ProductIndexer;
use Aheadworks\Wbtab\Model\Indexer\Product\Action\Row as  RowAction;
use Aheadworks\Wbtab\Model\Indexer\Product\Action\Rows as RowsAction;
use Aheadworks\Wbtab\Model\Indexer\Product\Action\Full as FullAction;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Test for \Aheadworks\Wbtab\Model\Indexer\Product
 */
class ProductTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ProductIndexer
     */
    private $model;

    /**
     * @var RowAction|\PHPUnit_Framework_MockObject_MockObject
     */
    private $rowAction;

    /**
     * @var RowsAction|\PHPUnit_Framework_MockObject_MockObject
     */
    private $rowsAction;

    /**
     * @var FullAction|\PHPUnit_Framework_MockObject_MockObject
     */
    private $fullAction;

    /**
     * Init mocks for tests
     *
     * @return void
     */
    public function setUp()
    {
        $objectManager = new ObjectManager($this);

        $this->rowAction = $this->getMockBuilder(RowAction::class)
            ->setMethods(['execute'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->rowsAction = $this->getMockBuilder(RowsAction::class)
            ->setMethods(['execute'])
            ->disableOriginalConstructor()
            ->getMock();
        $this->fullAction = $this->getMockBuilder(FullAction::class)
            ->setMethods(['execute'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->model = $objectManager->getObject(
            ProductIndexer::class,
            [
                'productIndexerRow' => $this->rowAction,
                'productIndexerRows' => $this->rowsAction,
                'productIndexerFull' => $this->fullAction,
            ]
        );
    }

    /**
     * Testing of execute method
     */
    public function testExecute()
    {
        $ids = [1, 5, 10];

        $this->rowsAction->expects($this->once())
            ->method('execute')
            ->with($ids)
            ->willReturnSelf();
        $this->assertSame(null, $this->model->execute($ids));
    }

    /**
     * Testing of executeFull method
     */
    public function testExecuteFull()
    {
        $this->fullAction->expects($this->once())
            ->method('execute')
            ->willReturnSelf();
        $this->assertSame(null, $this->model->executeFull());
    }

    /**
     * Testing of executeList method
     */
    public function testExecuteList()
    {
        $ids = [1, 5, 10];

        $this->rowsAction->expects($this->once())
            ->method('execute')
            ->with($ids)
            ->willReturnSelf();
        $this->assertSame(null, $this->model->executeList($ids));
    }

    /**
     * Testing of executeRow method
     */
    public function testExecuteRow()
    {
        $id = 5;

        $this->rowAction->expects($this->once())
            ->method('execute')
            ->with($id)
            ->willReturnSelf();
        $this->assertSame(null, $this->model->executeRow($id));
    }
}
