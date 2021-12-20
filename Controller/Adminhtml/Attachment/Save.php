<?php

namespace PurpleCommerce\Attachment\Controller\Adminhtml\Attachment;


use Magento\Backend\App\Action\Context;
use PurpleCommerce\Attachment\Helper\Data as HelperData;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Api\DataObjectHelper;
use PurpleCommerce\Attachment\Api\AttachmentRepositoryInterface;
use PurpleCommerce\Attachment\Api\Data\AttachmentInterfaceFactory;
/**
 * Class PurpleCommerce\Attachment\Controller\Adminhtml\Attachment\Save
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var DataObjectHelper
     */
    protected $_dataObjectHelper;
    
    /**
     * @var HelperData
     */
    protected $helperData;

    /**
     * @var \PurpleCommerce\Attachment\Api\Data\AttachmentInterfaceFactory;
     */
    protected $_attachmentInterface;
    /**
     * @var \PurpleCommerce\Attachment\Api\AttachmentRepositoryInterface;
     */
    protected $_attachmentRepository;
    protected $groupRepository;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param HelperData $helperData
     */
    public function __construct(
        Context $context,
        AttachmentInterfaceFactory $attachmentInterface,
        AttachmentRepositoryInterface $attachmentRepository,
        DataPersistorInterface $dataPersistor,
        DataObjectHelper $dataObjectHelper,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository,
        HelperData $helperData
    ) {
        $this->helperData = $helperData;
        $this->_attachmentRepository = $attachmentRepository;
        $this->_attachmentInterface = $attachmentInterface;
        $this->dataPersistor = $dataPersistor;
        $this->_dataObjectHelper = $dataObjectHelper;
        $this->groupRepository = $groupRepository;
        parent::__construct($context);
    }

    /**
     *  {@inheritDoc}
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $this->getRequest()->getPostValue();
        // $data['locatorid']=1;
        // echo '<pre>';
        // print_r($data);
        
        // echo $customerG;
        // die;
        $check=false;
        $attch_type=$data['attachment_type'];
        $upload_ext=pathinfo($data['icon'][0]['name'],PATHINFO_EXTENSION);
        $arr=['jpg','jpeg','png','PNG','JPG','JPEG'];
        if(in_array($upload_ext,$arr) && $attch_type=='Image'){
            $check=true;
        }
        if($upload_ext=='docx' && $attch_type=='Word'){
            $check=true;
        }
        if($upload_ext=='xlsx' && $attch_type=='Excel'){
            $check=true;
        }
        if($upload_ext=='pdf' && $attch_type=='PDF'){
            $check=true;
        }
        
        if ($data) {
            if($check==false){
                $this->messageManager->addErrorMessage('Selected attachment type did not matched with the file uploaded.');
            }else{
                try {
                    $this->dataPersistor->set('details', $data);
                    $this->setDataFromAdmin($data);
                    $this->dataPersistor->clear('details');
                    $this->messageManager->addSuccessMessage(__('Details are saved successfully!!'));
                    return $resultRedirect->setPath('*/*/');
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                } catch (\Exception $e) {
                    echo $e->getMessage();die('errorMessage'); 
                    $this->messageManager->addExceptionMessage(
                        $e,
                        __('Something went wrong while saving the details.')
                    );
                }
                return $resultRedirect->setPath('*/*/new');
            }
            
            
        }
        return $resultRedirect->setPath('*/*/');
    }


    public function setDataFromAdmin($storeData) {
        $customerG='';
        if($storeData['visible_to']){
            foreach($storeData['visible_to'] as $v){
                $customerG.= $this->groupRepository->getById($v)->getCode().',';
            }
        }
        $customerG=rtrim($customerG, ',');
        $random = '';
        $digits = 5;
        $length=3;
        for ($i = 0; $i < $length; $i++) {
            $random .= chr(rand(ord('a'), ord('z')));
        }
        // rand(pow(10, $digits-1), pow(10, $digits)-1)
        $filekey= $storeData['file_name'].'-'.$random.rand(pow(10, $digits-1), pow(10, $digits)-1);
        $filekey = preg_replace('/\s+/', '', $filekey);
        $recordDetail = [
            'file_name' =>$filekey,
            'file_label' => $storeData['file_label'],
            'is_active' => $storeData['is_active'],
            'icon' => $storeData['icon'][0]['url'],
            'attachment_type' => $storeData['attachment_type'],
            'visible_to' => $customerG
            
        ];
        
        $dataObjectRecordDetail = $this->_attachmentInterface->create();
        $this->_dataObjectHelper->populateWithArray(
            $dataObjectRecordDetail,
            $recordDetail,
            \PurpleCommerce\Attachment\Api\Data\StoredetailInterface::class
        );
        // echo 'tada';
        // echo '<pre>';
        // print_r($storeData);
        // die;
        // $dataObjectRecordDetail = $this->_storeDetailInterface->create();
        $this->saveDataStoreDetail($dataObjectRecordDetail);

    }

    public function saveDataStoreDetail($completeDataObject)
    {
        try {
            $this->_attachmentRepository->save($completeDataObject);
        } catch (\Exception $e) {
            throw new LocalizedException(
                __(
                    $e->getMessage()
                )
            );
        }
    }
}
