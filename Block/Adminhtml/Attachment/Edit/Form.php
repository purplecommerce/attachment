<?php
/**
 * PurpleCommerce_Attachment Add New Row Form Admin Block.
 * @category    PurpleCommerce
 * @package     PurpleCommerce_Attachment
 * @author      PurpleCommerce Software Private Limited
 *
 */
namespace Webkul\Attachment\Block\Adminhtml\Attachment\Edit;


/**
 * Adminhtml Add New Row Form.
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry             $registry
     * @param \Magento\Framework\Data\FormFactory     $formFactory
     * @param array                                   $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \PurpleCommerce\Attachment\Model\Status $options,
        array $data = []
    ) 
    {
        $this->_options = $options;
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $dateFormat = $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT);
        $model = $this->_coreRegistry->registry('row_data');
        $form = $this->_formFactory->create(
            ['data' => [
                            'id' => 'edit_form', 
                            'enctype' => 'multipart/form-data', 
                            'action' => $this->getData('action'), 
                            'method' => 'post'
                        ]
            ]
        );

        $form->setHtmlIdPrefix('wkgrid_');
        if ($model->getEntityId()) {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Edit Row Data'), 'class' => 'fieldset-wide']
            );
            $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
        } else {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Add Row Data'), 'class' => 'fieldset-wide']
            );
        }

        $fieldset->addField(
            'file_name',
            'text',
            [
                'name' => 'file_name',
                'label' => __('File Name'),
                'id' => 'file_name',
                'title' => __('File Name'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $fieldset->addField(
            'file_label',
            'text',
            [
                'name' => 'file_label',
                'label' => __('File Label'),
                'id' => 'file_label',
                'title' => __('File Label'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );


        $fieldset->addField(
            'attachment_type',
            'select',
            [
                'name' => 'attachment_type',
                'label' => __('Attachment Type'),
                'title' => __('Attachment Type'),
                'required' => true,
                'values' => ['Image,Pdf,Word,Excel'],

            ]
        );

        $fieldset->addField(
            'visible_to',
            'select',
            [
                'name' => 'visible_to',
                'label' => __('Visible To'),
                'title' => __('Visible To'),
                'required' => true,
                'values' => ['All,Wholesale,Retail'],

            ]
        );

        $fieldset->addField(
            'file_label',
            'text',
            [
                'name' => 'file_label',
                'label' => __('File Label'),
                'id' => 'file_label',
                'title' => __('File Label'),
                'class' => 'required-entry',
                'required' => true,
            ]
        );

        $wysiwygConfig = $this->_wysiwygConfig->getConfig(['tab_id' => $this->getTabId()]);

        $fieldset->addField(
            'content',
            'editor',
            [
                'name' => 'content',
                'label' => __('Content'),
                'style' => 'height:36em;',
                'required' => true,
                'config' => $wysiwygConfig
            ]
        );

        
        $fieldset->addField(
            'is_active',
            'select',
            [
                'name' => 'is_active',
                'label' => __('Status'),
                'id' => 'is_active',
                'title' => __('Status'),
                'values' => $this->_options->getOptionArray(),
                'class' => 'status',
                'required' => true,
            ]
        );
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}