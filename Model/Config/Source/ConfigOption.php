<?php
namespace PurpleCommerce\Attachment\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class ConfigOption implements ArrayInterface
{
    /**
     * @return array
    */
    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => 'Image',
                'value' => 'Image'
            ],
            1 => [
                'label' => 'PDF',
                'value' => 'PDF'
            ],
            2 => [
                'label' => 'Word',
                'value' => 'Word'
            ],
            3 => [
                'label' => 'Excel',
                'value' => 'Excel'
            ]
        ];

        return $options;
    }
}