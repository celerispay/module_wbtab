<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */


$testSuiteDir = __DIR__ . '/../../../../../../../dev/tests/integration/testsuite';
require  $testSuiteDir . '/Magento/Sales/_files/default_rollback.php';
require $testSuiteDir . '/Magento/Catalog/_files/multiple_products.php'; //create products with ids 10,11,12

$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();

/** @var \Magento\Catalog\Model\Product $product */
$product = $objectManager->create('Magento\Catalog\Model\Product');

$addressData = include $testSuiteDir . '/Magento/Sales/_files/address_data.php';

$billingAddress = $objectManager->create('Magento\Sales\Model\Order\Address', ['data' => $addressData]);
$billingAddress->setAddressType('billing');

$shippingAddress = clone $billingAddress;
$shippingAddress->setId(null)->setAddressType('shipping');

$payment = $objectManager->create('Magento\Sales\Model\Order\Payment');
$payment->setMethod('checkmo');

/** @var \Magento\Sales\Model\Order $order */
$order = $objectManager->create('Magento\Sales\Model\Order');
$order->setIncrementId(
    '100000001'
)->setState(
    \Magento\Sales\Model\Order::STATE_COMPLETE
)->setStatus(
    $order->getConfig()->getStateDefaultStatus(\Magento\Sales\Model\Order::STATE_COMPLETE)
)->setSubtotal(
    100
)->setBaseSubtotal(
    100
)->setBaseGrandTotal(
    100
)->setCustomerIsGuest(
    true
)->setCustomerEmail(
    'customer@null.com'
)->setBillingAddress(
    $billingAddress
)->setShippingAddress(
    $shippingAddress
)->setStoreId(
    $objectManager->get('Magento\Store\Model\StoreManagerInterface')->getStore()->getId()
)->setPayment(
    $payment
);

for ($productId = 10; $productId <= 11; $productId++) {
    $product->load($productId);
    /** @var \Magento\Sales\Model\Order\Item $orderItem */
    $orderItem = $objectManager->create('Magento\Sales\Model\Order\Item');
    $orderItem->setProductId($product->getId())->setQtyOrdered(2);
    $orderItem->setBasePrice($product->getPrice());
    $orderItem->setPrice($product->getPrice());
    $orderItem->setRowTotal($product->getPrice());
    $orderItem->setProductType('simple');

    $order->addItem($orderItem);
}

$order->save();
