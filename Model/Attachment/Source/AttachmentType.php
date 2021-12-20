<?php

namespace PurpleCommerce\Attachment\Model\Attachment\Source;

use Magento\Framework\Data\OptionSourceInterface;

class AttachmentType implements OptionSourceInterface
{
    protected $attachmenttype;
    protected $helper;
    public function __construct(
        \PurpleCommerce\Attachment\Helper\Data $helper
    )
    {
        $this->helper = $helper;
    }
    //Here you can __construct Model

    public function toOptionArray()
    {
        $arr=$this->helper->getFileTypes();
        $data = explode(",",$arr);
        $option=[];

        foreach($data as $k=>$val){
            $option[$k] = [
                'value'=>$val,
                'label'=>$val
            ];
        }
        // print_r($option);
        // die;
        return $option;
        // return [
        //     ['value' => 'Image', 'label' => __('Image')],
        //     ['value' => 'PDF', 'label' => __('PDF')],
        //     ['value' => 'Word', 'label' => __('Word')],
        //     ['value' => 'Excel', 'label' => __('Excel')]
        // ];
    }
}