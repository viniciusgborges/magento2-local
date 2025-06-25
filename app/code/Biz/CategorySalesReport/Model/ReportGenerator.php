<?php
namespace Biz\CategorySalesReport\Model;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Sales\Model\ResourceModel\Order\Item\CollectionFactory as OrderItemCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;

class ReportGenerator
{
    protected $categoryRepository;
    protected $orderItemCollectionFactory;
    protected $categoryCollectionFactory;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        OrderItemCollectionFactory $orderItemCollectionFactory,
        CategoryCollectionFactory $categoryCollectionFactory
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->orderItemCollectionFactory = $orderItemCollectionFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * Generate report data.
     *
     * @param array $categoryIds
     * @param string $from
     * @param string $to
     * @return array
     */
    public function generate(array $categoryIds, $from, $to)
    {
        // This is a simplified placeholder implementation. In a real environment
        // you would join category and order tables to fetch aggregated results.
        $collection = $this->orderItemCollectionFactory->create();
        $collection->addFieldToFilter('created_at', ['from' => $from, 'to' => $to]);
        $collection->addFieldToFilter('product_type', ['neq' => 'configurable']);

        $data = [];
        foreach ($collection as $item) {
            $sku = $item->getSku();
            $data[$sku]['sku'] = $sku;
            $data[$sku]['name'] = $item->getName();
            $data[$sku]['qty'] = ($data[$sku]['qty'] ?? 0) + $item->getQtyOrdered();
            $data[$sku]['total'] = ($data[$sku]['total'] ?? 0) + $item->getRowTotal();
        }

        return $data;
    }
}
