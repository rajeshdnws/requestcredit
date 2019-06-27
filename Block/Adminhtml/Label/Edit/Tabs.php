<?php
/**
 * BSS Commerce Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://starbucksb2bcommerce.com/Starbucksb2b-Commerce-License.txt
 *
 * @category   BSS
 * @package    Starbucksb2b_RequestCredit
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 BSS Commerce Co. ( http://starbucksb2bcommerce.com )
 * @license    http://starbucksb2bcommerce.com/Starbucksb2b-Commerce-License.txt
 */

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
