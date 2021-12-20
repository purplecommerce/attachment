<?php


namespace PurpleCommerce\Attachment\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface AttachmentRepositoryInterface
{
    /**
     * Save Attachment
     * @param \PurpleCommerce\Attachment\Api\Data\AttachmentInterface $changelog
     * @return \PurpleCommerce\Attachment\Api\Data\AttachmentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \PurpleCommerce\Attachment\Api\Data\AttachmentInterface $changelog
    );

    /**
     * Retrieve Attachment
     * @param string $EntityId
     * @return \PurpleCommerce\Attachment\Api\Data\AttachmentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($changelogId);

    /**
     * Retrieve Attachment matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \PurpleCommerce\Attachment\Api\Data\AttachmentSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Changelog
     * @param \PurpleCommerce\Attachment\Api\Data\AttachmentInterface $changelog
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \PurpleCommerce\Attachment\Api\Data\AttachmentInterface $changelog
    );

    /**
     * Delete Changelog by ID
     * @param string $changelogId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($changelogId);

/**
     * Delete Changelog by ID
     * @param string $changelogId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function saveNew($rewardData);
}
