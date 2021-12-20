<?php

namespace PurpleCommerce\Attachment\Block\Adminhtml\Attachment\NewAction;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class PurpleCommerce\Attachment\Block\Adminhtml\Attachment\NewAction\SaveButton
 */
class SaveButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save Attachment'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
