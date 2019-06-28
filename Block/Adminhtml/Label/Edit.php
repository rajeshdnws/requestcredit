<?php
namespace Starbucksb2b\RequestCredit\Block\Adminhtml\Label;

use \Magento\Backend\Block\Widget;
use \Magento\Backend\Block\Widget\Form\Container;
use \Magento\Framework\Registry;

class Edit extends Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry $_coreRegistry
     */
    protected $coreRegistry = null;

    /**
     * Edit constructor.
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        Widget\Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Edit constructor.
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Starbucksb2b_RequestCredit';
        $this->_controller = 'adminhtml_label';
        parent::_construct();
        $this->buttonList->update('save', 'label', __('Save'));
        $this->buttonList->update('delete', 'label', __('Delete'));
    }

    /**
     * @return \Magento\Framework\Phrase|string
     */
    public function getHeaderText()
    {
        if ($this->coreRegistry->registry('starbucksb2b_requestcredit')->getId()) {
            return __(
                "Edit '%1'",
                $this->escapeHtml(
                    $this->coreRegistry->registry('starbucksb2b_requestcredit')->getTitle()
                )
            );
        } else {
            return __('Add New');
        }
    }
}
