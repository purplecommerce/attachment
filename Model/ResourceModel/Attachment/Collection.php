<?php

/**
 * Attachment Attachment Collection.
 * @category    PurpleCommerce
 * @author      PurpleCommerce Software Private Limited
 */
namespace PurpleCommerce\Attachment\Model\ResourceModel\Attachment;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('PurpleCommerce\Attachment\Model\Attachment', 'PurpleCommerce\Attachment\Model\ResourceModel\Attachment');
    }
}