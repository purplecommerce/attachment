<?php
/**
 * PurpleCommerce Attachment List Controller.
 * @category  PurpleCommerce
 * @package   PurpleCommerce_Attachment
 * @author    PurpleCommerce
 * @copyright Copyright (c) 2010-2017 PurpleCommerce Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace PurpleCommerce\Attachment\Controller\Adminhtml\Attachment;

use Magento\Framework\Controller\ResultFactory;

class AddRow extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var \PurpleCommerce\Attachment\Model\AttachmentFactory
     */
    private $attachmentFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry,
     * @param \PurpleCommerce\Attachment\Model\AttachmentFactory $attachmentFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \PurpleCommerce\Attachment\Model\AttachmentFactory $attachmentFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->attachmentFactory = $attachmentFactory;
    }

    /**
     * Mapped Attachment List page.
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $rowId = (int) $this->getRequest()->getParam('id');
        $rowData = $this->attachmentFactory->create();
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        if ($rowId) {
           $rowData = $rowData->load($rowId);
           $rowTitle = $rowData->getTitle();
           if (!$rowData->getEntityId()) {
               $this->messageManager->addError(__('row data no longer exist.'));
               $this->_redirect('attachment/attachment/rowdata');
               return;
           }
       }

       $this->coreRegistry->register('row_data', $rowData);
       $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
       $title = $rowId ? __('Edit Attachment Data ').$rowTitle : __('Add Attachment Data');
       $resultPage->getConfig()->getTitle()->prepend($title);
       return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('PurpleCommerce_Attachment::add_row');
    }
}