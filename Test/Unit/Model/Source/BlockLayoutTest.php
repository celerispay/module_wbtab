<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Test\Unit\Model;

use Aheadworks\Wbtab\Model\Source\BlockLayout;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Test for \Aheadworks\Wbtab\Model\Source\BlockLayout
 */
class PositionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var BlockLayout
     */
    private $blockLayout;

    /**
     * Init mocks for tests
     *
     * @return void
     */
    public function setUp()
    {
        $objectManager = new ObjectManager($this);

        $this->blockLayout = $objectManager->getObject(
            BlockLayout::class,
            []
        );
    }

    /**
     * Testing of toOptionArray method
     */
    public function testToOptionArray()
    {
        $this->assertTrue(is_array($this->blockLayout->toOptionArray()));
    }
}
