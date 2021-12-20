<?php

/**
 * Attachment Attachment Model.
 * @category  PurpleCommerce
 * @package   PurpleCommerce_Attachment
 * @author    PurpleCommerce
 * @copyright Copyright (c) 2010-2017 PurpleCommerce Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace PurpleCommerce\Attachment\Model;

use PurpleCommerce\Attachment\Api\Data\AttachmentInterface;

class Attachment extends \Magento\Framework\Model\AbstractModel implements AttachmentInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'pc_attachment_records';

    /**
     * @var string
     */
    protected $_cacheTag = 'pc_attachment_records';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'pc_attachment_records';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('PurpleCommerce\Attachment\Model\ResourceModel\Attachment');
    }
    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Set EntityId.
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Get Icon.
     *
     * @return varchar
     */
    public function getIcon()
    {
        return $this->getData(self::ICON);
    }

    /**
     * Set Icon.
     */
    public function setIcon($icon)
    {
        return $this->setData(self::ICON, $icon);
    }

    /**
     * Get getAttachmentType.
     *
     * @return varchar
     */
    public function getAttachmentType()
    {
        return $this->getData(self::ATTACHMENT_TYPE);
    }

    /**
     * Set AttachmentType.
     */
    public function setAttachmentType($attachmentType)
    {
        return $this->setData(self::ATTACHMENT_TYPE, $attachmentType);
    }

    /**
     * Get FileName.
     *
     * @return varchar
     */
    public function getFileName()
    {
        return $this->getData(self::FILE_NAME);
    }

    /**
     * Set FileName.
     */
    public function setFileName($fileName)
    {
        return $this->setData(self::FILE_NAME, $fileName);
    }

    /**
     * Get FileLabel.
     *
     * @return varchar
     */
    public function getFileLabel()
    {
        return $this->getData(self::FILE_Label);
    }

    /**
     * Set FileLabel.
     */
    public function setFileLabel($fileLabel)
    {
        return $this->setData(self::FILE_Label, $fileLabel);
    }

    /**
     * Get VisibleTo.
     *
     * @return varchar
     */
    public function getVisibleTo()
    {
        return $this->getData(self::VISIBLE_TO);
    }

    /**
     * Set VisibleTo.
     */
    public function setVisibleTo($visibleTo)
    {
        return $this->setData(self::VISIBLE_TO, $visibleTo);
    }

    /**
     * Get IsActive.
     *
     * @return varchar
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set IsActive.
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Get UpdateTime.
     *
     * @return varchar
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Set UpdateTime.
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Get CreatedAt.
     *
     * @return varchar
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set CreatedAt.
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}