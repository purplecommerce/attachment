<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace PurpleCommerce\Attachment\Block\Adminhtml\Block\Widget;

/**
 * CMS attachment chooser for Wysiwyg CMS widget
 */
class Chooser extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \PurpleCommerce\Attachment\Model\AttachmentFactory
     */
    protected $_attachmentFactory;

    /**
     * @var \PurpleCommerce\Attachment\Model\ResourceModel\Attachment\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \PurpleCommerce\Attachment\Model\AttachmentFactory $attachmentFactory
     * @param \PurpleCommerce\Attachment\Model\ResourceModel\Attachment\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \PurpleCommerce\Attachment\Model\AttachmentFactory $attachmentFactory,
        \PurpleCommerce\Attachment\Model\ResourceModel\Attachment\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_attachmentFactory = $attachmentFactory;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Block construction, prepare grid params
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setDefaultFilter(['chooser_is_active' => '1']);
    }

    /**
     * Prepare chooser element HTML
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element Form Element
     * @return \Magento\Framework\Data\Form\Element\AbstractElement
     */
    public function prepareElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $uniqId = $this->mathRandom->getUniqueHash($element->getId());
        // echo "here";
        // print_r($uniqId);
        // die;
        $sourceUrl = $this->getUrl('attachment/block_widget/chooser', ['uniq_id' => $uniqId]);

        $chooser = $this->getLayout()->createBlock(
            \Magento\Widget\Block\Adminhtml\Widget\Chooser::class
        )->setElement(
            $element
        )->setConfig(
            $this->getConfig()
        )->setFieldsetId(
            $this->getFieldsetId()
        )->setSourceUrl(
            $sourceUrl
        )->setUniqId(
            $uniqId
        );

        if ($element->getValue()) {
            $block = $this->_attachmentFactory->create()->load($element->getValue());
            if ($block->getEntityId()) {
                $chooser->setLabel($this->escapeHtml($block->getFileLabel()));
            }
        }

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }

    /**
     * Grid Row JS Callback
     *
     * @return string
     */
    public function getRowClickCallback()
    {
        $chooserJsObject = $this->getId();
        $js = '
            function (grid, event) {
                var trElement = Event.findElement(event, "tr");
                var entityId = trElement.down("td").innerHTML.replace(/^\s+|\s+$/g,"");
                var fileLabel = trElement.down("td").next().innerHTML;
                ' .
            $chooserJsObject .
            '.setElementValue(entityId);
                ' .
            $chooserJsObject .
            '.setElementLabel(fileLabel);
                ' .
            $chooserJsObject .
            '.close();
            }
        ';
        return $js;
    }

    /**
     * Prepare Cms static blocks collection
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareCollection()
    {
        $this->setCollection($this->_collectionFactory->create());
        return parent::_prepareCollection();
    }

    /**
     * Prepare columns for Cms blocks grid
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'chooser_entity_id',
            ['header' => __('ID'), 'align' => 'right', 'index' => 'entity_id', 'width' => 50]
        );

        $this->addColumn('chooser_file_label', ['header' => __('File Label'), 'align' => 'left', 'index' => 'file_label']);
        $this->addColumn(
            'chooser_file_name',
            ['header' => __('File Key'), 'align' => 'left', 'index' => 'file_name']
        );
        $this->addColumn(
            'chooser_attachment_type',
            ['header' => __('Attachment Type'), 'align' => 'left', 'index' => 'attachment_type']
        );
        $this->addColumn(
            'chooser_visible_to',
            ['header' => __('Visible To'), 'align' => 'left', 'index' => 'visible_to']
        );
        

        $this->addColumn(
            'chooser_is_active',
            [
                'header' => __('Status'),
                'index' => 'is_active',
                'type' => 'options',
                'options' => [0 => __('Disabled'), 1 => __('Enabled')]
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Get grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('attachment/block_widget/chooser', ['_current' => true]);
    }
}
