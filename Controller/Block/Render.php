<?php
/**
 * Copyright 2019 aheadWorks. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Aheadworks\Wbtab\Controller\Block;

use Aheadworks\Wbtab\Block\Catalog\Wbtab as WbtabCatalog;
use Aheadworks\Wbtab\Block\Cart\Wbtab as WbtabCart;
use Aheadworks\Wbtab\Block\Product\Wbtab as WbtabProduct;
use Magento\Framework\Translate\InlineInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\DataObject;
use Magento\Framework\DataObjectFactory;

/**
 * Class Render
 * @package Aheadworks\Wbtab\Controller\Block
 */
class Render extends \Magento\Framework\App\Action\Action
{
    /**
     * @var InlineInterface
     */
    private $translateInline;

    /**
     * @var DataObjectFactory
     */
    private $dataObjectFactory;

    /**
     * @var DataObject
     */
    private $currentRequestData;

    /**
     * @param Context $context
     * @param InlineInterface $translateInline
     * @param DataObjectFactory $dataObjectFactory
     */
    public function __construct(
        Context $context,
        InlineInterface $translateInline,
        DataObjectFactory $dataObjectFactory
    ) {
        parent::__construct($context);
        $this->translateInline = $translateInline;
        $this->dataObjectFactory = $dataObjectFactory;
    }

    /**
     * Returns block content depends on ajax request
     *
     * @return \Magento\Framework\Controller\Result\Redirect|void
     */
    public function execute()
    {
        if (!$this->getRequest()->isAjax()) {
            /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setRefererOrBaseUrl();
        }

        $this->saveCurrentRequestData();

        $origRequest = $this->getRequest()->getParam('originalRequest');
        if ($origRequest && is_string($origRequest)) {
            $origRequest = json_decode($origRequest, true);

            $this->getRequest()->setRouteName($origRequest['route']);
            $this->getRequest()->setControllerName($origRequest['controller']);
            $this->getRequest()->setActionName($origRequest['action']);
            $this->getRequest()->setRequestUri($origRequest['uri']);
        }

        $blocks = $this->getRequest()->getParam('blocks');
        $data = $this->getBlocks($blocks);

        $this->restoreCurrentRequestData();

        $this->translateInline->processResponseBody($data);
        $this->getResponse()->appendBody(json_encode($data));
    }

    /**
     * Get blocks from layout
     *
     * @param string $blocks
     * @return string[]
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    private function getBlocks($blocks)
    {
        if (!$blocks) {
            return [];
        }
        $blocks = json_decode($blocks);

        $data = [];
        $layout = $this->_view->getLayout();
        foreach ($blocks as $block) {
            $blockType = $block->type;
            $blockName = $block->name;
            switch ($blockType) {
                case 'catalog':
                    /** @var WbtabCatalog $blockInstance */
                    $blockInstance = $layout->createBlock(WbtabCatalog::class);
                    if (is_object($blockInstance)) {
                        $blockInstance->setNameInLayout($blockName);
                        $data[$blockName] = $blockInstance->toHtml();
                    }
                    break;
                case 'cart':
                    /** @var WbtabCart $blockInstance */
                    $blockInstance = $layout->createBlock(WbtabCart::class);
                    if (is_object($blockInstance)) {
                        $blockInstance->setNameInLayout($blockName);
                        $data[$blockName] = $blockInstance->toHtml();
                    }
                    break;
                case 'product':
                    /** @var WbtabProduct $blockInstance */
                    $blockInstance = $layout->createBlock(WbtabProduct::class);
                    if (is_object($blockInstance)) {
                        $blockInstance->setNameInLayout($blockName);
                        $productId = $this->getRequest()->getParam('id');
                        if ($productId) {
                            $blockInstance->setProductId($productId);
                        }
                        $data[$blockName] = $blockInstance->toHtml();
                    }
                    break;
            }
        }

        return $data;
    }

    /**
     * Save current request data
     *
     * @return void
     */
    private function saveCurrentRequestData()
    {
        $this->currentRequestData = $this->dataObjectFactory->create();
        $this->currentRequestData->setData('route_name', $this->getRequest()->getRouteName());
        $this->currentRequestData->setData('controller_name', $this->getRequest()->getControllerName());
        $this->currentRequestData->setData('action_name', $this->getRequest()->getActionName());
        $this->currentRequestData->setData('request_uri', $this->getRequest()->getRequestUri());
    }

    /**
     * Restore current request data
     *
     * @return void
     */
    private function restoreCurrentRequestData()
    {
        if ($this->currentRequestData) {
            $this->getRequest()->setRouteName($this->currentRequestData->getData('route_name'));
            $this->getRequest()->setControllerName($this->currentRequestData->getData('controller_name'));
            $this->getRequest()->setActionName($this->currentRequestData->getData('action_name'));
            $this->getRequest()->setRequestUri($this->currentRequestData->getData('request_uri'));
        }
    }
}
