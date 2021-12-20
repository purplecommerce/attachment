<?php
/**
 * PurpleCommerce_Attachment Attachment Interface.
 *
 * @category    PurpleCommerce
 *
 * @author      PurpleCommerce Software Private Limited
 */
namespace PurpleCommerce\Attachment\Api\Data;

interface AttachmentInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ENTITY_ID = 'entity_id';
    const ICON = 'icon';
    const ATTACHMENT_TYPE = 'attachment_type';
    const FILE_NAME = 'file_name';
    const FILE_Label = 'file_label';
    const VISIBLE_TO = 'visible_to';
    const IS_ACTIVE = 'is_active';
    const UPDATE_TIME = 'update_time';
    const CREATED_AT = 'created_at';

    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getEntityId();

    /**
     * Set EntityId.
     */
    public function setEntityId($entityId);

    /**
     * Get Title.
     *
     * @return varchar
     */
    public function getIcon();

    /**
     * Set Title.
     */
    public function setIcon($icon);

    /**
     * Get Content.
     *
     * @return varchar
     */
    public function getAttachmentType();

    /**
     * Set Content.
     */
    public function setAttachmentType($attachmentType);

    /**
     * Get Publish Date.
     *
     * @return varchar
     */
    public function getFileName();

    /**
     * Set PublishDate.
     */
    public function setFileName($fileName);

    /**
     * Set PublishDate.
     * 
     * @return varchar
     */
    public function getFileLabel();
    /**
     * Set PublishDate.
     */
    public function setFileLabel($fileLabel);
    /**
     * Set PublishDate.
     */
    public function getVisibleTo();
    
    /**
     * Set PublishDate.
     */
    public function setVisibleTo($visibleTo);
    

    /**
     * Get IsActive.
     *
     * @return varchar
     */
    public function getIsActive();

    /**
     * Set StartingPrice.
     */
    public function setIsActive($isActive);

    /**
     * Get UpdateTime.
     *
     * @return varchar
     */
    public function getUpdateTime();

    /**
     * Set UpdateTime.
     */
    public function setUpdateTime($updateTime);

    /**
     * Get CreatedAt.
     *
     * @return varchar
     */
    public function getCreatedAt();

    /**
     * Set CreatedAt.
     */
    public function setCreatedAt($createdAt);
}