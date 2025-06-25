<?php
namespace Biz\CategorySalesReport\Controller\Adminhtml\Report;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    const ADMIN_RESOURCE = 'Biz_CategorySalesReport::report';

    protected $resultPageFactory;

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Biz_CategorySalesReport::report');
        $resultPage->getConfig()->getTitle()->prepend(__('Category Sales Report'));
        return $resultPage;
    }
}
