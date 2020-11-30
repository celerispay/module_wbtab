<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Test\Integration\Model\ResourceModel\Product;

use Aheadworks\Wbtab\Model\ResourceModel\Product\Collection;

/**
 * Class CollectionTest
 * @package Aheadworks\Wbtab\Test\Integration\Model\ResourceModel\Product
 */
class CollectionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Aheadworks\Wbtab\Model\ResourceModel\Product\Collection
     */
    protected $productCollection;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * Init mocks for tests
     *
     * @return void
     */
    protected function setUp()
    {
        $this->objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
        $this->productCollection = $this->objectManager->create(Collection::class);
    }

    /**
     * @magentoDataFixture ../../../../app/code/Aheadworks/Wbtab/Test/Integration/_files/order_with_two_products.php
     * @return void
     */
    public function testWbtabFilter()
    {
        $testProductId = 10;
        $wbtabProductId = 11;
        $wbtabProductIds = $this->productCollection->addWbtabFilter($testProductId, null)->getAllIds();
        \PHPUnit_Framework_Assert::assertCount(1, $wbtabProductIds);
        \PHPUnit_Framework_Assert::assertContains($wbtabProductId, $wbtabProductIds);
    }
}
