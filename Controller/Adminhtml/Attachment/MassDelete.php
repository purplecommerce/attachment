<?php

namespace PurpleCommerce\Attachment\Controller\Adminhtml\Attachment;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use PurpleCommerce\Attachment\Model\ResourceModel\Attachment\CollectionFactory;

class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var Filter
     */
    private $filter;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Filesystem\Driver\File $file,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->filter = $filter;
        $this->_file = $file;
        parent::__construct($context);
    }

    /**
     * Delete one or more subscribers action
     *
     * @return void
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize  = $collection->getSize();
        $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
        ->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $mediaRootDir = $mediaDirectory->getAbsolutePath();

        
        foreach($collection as $attachment){
            $url=$attachment->getData('icon');
            $dir = dirname($url);
            $subdir = substr($dir, strpos($dir, 'attachment')+10);
            $fileName = basename($url);
            if ($this->_file->isExists($mediaRootDir."/attachment".$subdir.'/'.$fileName))  {
                $this->_file->deleteFile($mediaRootDir."/attachment".$subdir.'/'.$fileName);
            }
            $attachment->delete();
        }
        $this->messageManager->addSuccess(__('Total of %1 record(s) were deleted.', $collectionSize));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/index');
    }
}
