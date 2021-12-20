<?php

namespace PurpleCommerce\Attachment\Model\Attachment\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Customer\Model\ResourceModel\Group\Collection as CustomerGroup;

class VisibleTo implements OptionSourceInterface
{
    protected $locators;
    protected $customerGroup;

    public function __construct(
        CustomerGroup $customerGroup
    )
    {
        $this->customerGroup = $customerGroup;
    }
    public function toOptionArray()
    {
        $customerGroups = $this->customerGroup->toOptionArray();
        // return [
        //     ['value' => 'All', 'label' => __('All')],
        //     ['value' => 'Wholesale', 'label' => __('Wholesale')],
        //     ['value' => 'Retail', 'label' => __('Retail')]
        // ];
        return $customerGroups;
    }

    public function getCustomerGroups()
    {
        $customerGroups = $this->customerGroup->toOptionArray();
        return $customerGroups;
    }
}