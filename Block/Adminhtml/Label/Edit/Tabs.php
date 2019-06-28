<?php
namespace Starbucksb2b\RequestCredit\Block\Adminhtml\Label\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * Tabs constructor.
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('label_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('EDIT OPTION'));
    }
}
