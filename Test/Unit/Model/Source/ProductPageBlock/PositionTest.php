<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Test\Unit\Model\SourceProductPageBlock;

use Aheadworks\Wbtab\Model\Source\ProductPageBlock\Position;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Test for \Aheadworks\Wbtab\Model\Source\ProductPageBlock\Position
 */
class PositionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Position
     */
    private $position;

    /**
     * Init mocks for tests
     *
     * @return void
     */
    public function setUp()
    {
        $objectManager = new ObjectManager($this);

        $this->position = $objectManager->getObject(
            Position::class,
            []
        );
    }

    /**
     * Testing of toOptionArray method
     */
    public function testToOptionArray()
    {
        $this->assertTrue(is_array($this->position->toOptionArray()));
    }
}
