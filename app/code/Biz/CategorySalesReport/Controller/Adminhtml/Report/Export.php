<?php
namespace Biz\CategorySalesReport\Controller\Adminhtml\Report;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Response\Http\FileFactory;
use Biz\CategorySalesReport\Model\ReportGenerator;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Serialize\SerializerInterface;

class Export extends Action
{
    const ADMIN_RESOURCE = 'Biz_CategorySalesReport::report';

    protected $fileFactory;
    protected $reportGenerator;
    protected $directoryList;
    protected $serializer;

    public function __construct(
        Context $context,
        FileFactory $fileFactory,
        ReportGenerator $reportGenerator,
        DirectoryList $directoryList,
        SerializerInterface $serializer
    ) {
        parent::__construct($context);
        $this->fileFactory = $fileFactory;
        $this->reportGenerator = $reportGenerator;
        $this->directoryList = $directoryList;
        $this->serializer = $serializer;
    }

    public function execute()
    {
        $categoryIds = $this->getRequest()->getParam('categories', []);
        $from = $this->getRequest()->getParam('from');
        $to = $this->getRequest()->getParam('to');

        $data = $this->reportGenerator->generate($categoryIds, $from, $to);

        $csv = "sku,name,qty,total\n";
        foreach ($data as $row) {
            $csv .= sprintf("%s,%s,%s,%s\n", $row['sku'], $row['name'], $row['qty'], $row['total']);
        }

        return $this->fileFactory->create(
            'category_sales_report.csv',
            $csv,
            DirectoryList::VAR_DIR,
            'text/csv'
        );
    }
}
