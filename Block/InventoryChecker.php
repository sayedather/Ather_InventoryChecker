<?php
namespace InventoryChecker\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Catalog\Model\ProductRepository;

class InventoryChecker extends \Magento\Framework\View\Element\Template
{
    protected $stockRegistry;
    protected $productRepository;

    public function __construct(
        Context $context,
        StockRegistryInterface $stockRegistry,
        ProductRepository $productRepository,
        array $data = []
    ) {
        $this->stockRegistry = $stockRegistry;
        $this->productRepository = $productRepository;
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
}
