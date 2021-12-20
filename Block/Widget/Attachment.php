<?php 
namespace PurpleCommerce\Attachment\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface; 
use Magento\Customer\Api\GroupRepositoryInterface as CustomerGroup;
use Magento\Store\Model\StoreManagerInterface;

class Attachment extends Template implements BlockInterface {

	protected $_template = "widget/attachments.phtml";
	protected $attachmentmodelFactory;
	protected $_customerSession;
    protected $customerGroup;
	protected $storeManager;
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		CustomerGroup $customerGroup,
		StoreManagerInterface $storeManager,
		\Magento\Customer\Model\Session $session,
		\PurpleCommerce\Attachment\Model\ResourceModel\Attachment\CollectionFactory $attachmentmodelFactory,
		array $data = []
	){
		parent::__construct($context, $data);
		$this->_customerSession = $session;
		$this->storeManager = $storeManager;
		$this->customerGroup = $customerGroup;
		$this->attachmentmodelFactory = $attachmentmodelFactory;
	}
	
	public function getAttachment($id){
		// echo "inside";
		// die;
		$collection = $this->attachmentmodelFactory->create()->addFieldToFilter('entity_id',$id);
		// echo "<pre>";
		// print_r($collection->getData());
		// die;
		return $collection->getData();
	}

	public function getTestdata(){
		
		return 'you got this';
	}

	public function getCustomerInfo(){
		if ($this->_customerSession->isLoggedIn()) {
			$customerGroupId = $this->_customerSession->getCustomer()->getGroupId();
            $groupCollection = $this->customerGroup->getById($customerGroupId);
            return $currentCustCode= $groupCollection->getCode();
		}else{
			$customerGroupId = $this->_customerSession->getCustomer()->getGroupId();
            $groupCollection = $this->customerGroup->getById($customerGroupId);
            return $currentCustCode= $groupCollection->getCode();
		}
	}

	public function getFileIcon($ext){
		if($ext=='jpg' || $ext=='png' || $ext=='jpeg'){
			$url = $this->storeManager->getStore()->getBaseUrl(
				\Magento\Framework\UrlInterface::URL_TYPE_MEDIA
			).'attachment_icons/icons8-image.png';
		}elseif($ext=='pdf'){
			$url = $this->storeManager->getStore()->getBaseUrl(
				\Magento\Framework\UrlInterface::URL_TYPE_MEDIA
			).'attachment_icons/icons8-pdf.png';
		}elseif($ext=='docx'){
			$url = $this->storeManager->getStore()->getBaseUrl(
				\Magento\Framework\UrlInterface::URL_TYPE_MEDIA
			).'attachment_icons/icons8-microsoft-word.png';
		}elseif($ext='xlsx'){
			$url = $this->storeManager->getStore()->getBaseUrl(
				\Magento\Framework\UrlInterface::URL_TYPE_MEDIA
			).'attachment_icons/icons8-microsoft-excel.png';
		}
		return $url;
	}

}