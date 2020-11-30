<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Test\Unit\Model\SourceCartPageBlock;

use Aheadworks\Wbtab\Model\Source\CartPageBlock\Position;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Test for \Aheadworks\Wbtab\Model\Source\CartPageBlock\Position
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
