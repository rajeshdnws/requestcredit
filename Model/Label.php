<?php
namespace Starbucksb2b\RequestCredit\Model;

use Magento\Framework\Model\AbstractModel;

class Label extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Starbucksb2b\RequestCredit\Model\ResourceModel\Label');
    }
}
