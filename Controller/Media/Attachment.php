<?php
namespace PurpleCommerce\Attachment\Controller\Media;
use Magento\Customer\Api\GroupRepositoryInterface as CustomerGroup;
// use Magento\Framework\App\Filesystem\DirectoryList;
class Attachment extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
    protected $request;
    protected $_customerSession;
    protected $customerGroup;
    protected $attachmentmodelFactory;
    protected $_storeManager;
    /**
     * @var Magento\Framework\App\Response\Http\FileFactory
     */
    protected $_downloader;

    /**
     * @var Magento\Framework\Filesystem\DirectoryList
     */
    protected $_directory;

    /**
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Customer\Model\Session $session,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        CustomerGroup $customerGroup,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Filesystem\DirectoryList $directory,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \PurpleCommerce\Attachment\Model\ResourceModel\Attachment\CollectionFactory $attachmentmodelFactory,
		\Magento\Framework\View\Result\PageFactory $pageFactory)
	{
		$this->_pageFactory = $pageFactory;
        $this->request = $request;
        $this->customerGroup = $customerGroup;
        $this->_storeManager = $storeManager;
        $this->_downloader =  $fileFactory;
        $this->directory = $directory;
        $this->resultRawFactory      = $resultRawFactory;
        $this->attachmentmodelFactory = $attachmentmodelFactory;
        $this->_customerSession = $session;
		return parent::__construct($context);
	}

	public function execute()
	{
        $data = $this->request->getParams();
        $id=$data['id'];
        $collection = $this->attachmentmodelFactory->create()->addFieldToFilter('file_name',$id);
        
        $attachment=$collection->getData();
        $visibleto = explode(',',$attachment[0]['visible_to']);
        if ($this->_customerSession->isLoggedIn()) {
            $customerGroupId = $this->_customerSession->getCustomer()->getGroupId();
            $groupCollection = $this->customerGroup->getById($customerGroupId);
            $currentCustCode= $groupCollection->getCode();
            if(in_array($currentCustCode,$visibleto)){
                $this->downloadfile($currentCustCode,$visibleto,$attachment);
            }
        } else {
            $customerGroupId = $this->_customerSession->getCustomer()->getGroupId();
            $groupCollection = $this->customerGroup->getById($customerGroupId);
            $currentCustCode= $groupCollection->getCode();
            if(in_array($currentCustCode,$visibleto)){
                $this->downloadfile($currentCustCode,$visibleto,$attachment);
            }
        }
		return $this->_pageFactory->create();
	}

    public function downloadfile($currentCustCode,$visibleto,$attachment){
            
            $url= $attachment[0]['icon'];
            $dir = dirname($url);
            $subdir = substr($dir, strpos($dir, 'attachment')+10);
            $fileName = basename($url);

            $file = $this->directory->getPath("media")."/attachment".$subdir.'/'.$fileName;
            $imageHeaders = get_headers($url);
            return $this->_downloader->create(
                $fileName,
                @file_get_contents($file)
            );
    }
}