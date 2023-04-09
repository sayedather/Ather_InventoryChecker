<?php
namespace InventoryChecker\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\App\Config\ScopeConfigInterface;

class InventoryChecker extends \Magento\Framework\View\Element\Template
{
    protected $stockRegistry;
    protected $productRepository;
    protected $scopeConfig;

    public function __construct(
        Context $context,
        StockRegistryInterface $stockRegistry,
        ProductRepository $productRepository,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->stockRegistry = $stockRegistry;
        $this->productRepository = $productRepository;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function getStockQty($productId)
    {
        $stockItem = $this->stockRegistry->getStockItem($productId);
        return $stockItem->getQty();
    }

    public function getProductBySku($sku)
    {
        return $this->productRepository->get($sku);
    }

    public function getProductByGtin($gtin)
    {
        $product = $this->productRepository->getByAttribute('gtin', $gtin);
        if (!$product) {
            $product = $this->productRepository->getByAttribute('ean', $gtin);
        }
        return $product;
    }

    public function getImageSize()
    {
        return $this->scopeConfig->getValue('inventorychecker_settings/general/image_size');
    }

    public function isShowSku()
    {
        return $this->scopeConfig->getValue('inventorychecker_settings/general/show_sku');
    }

    public function isShowGtin()
    {
        return $this->scopeConfig->getValue('inventorychecker_settings/general/show_gtin');
    }

    public function isShowImage()
    {
        return $this->scopeConfig->getValue('inventorychecker_settings/general/show_image');
    }
}
