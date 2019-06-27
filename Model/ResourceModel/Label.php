<?php
namespace Starbucksb2b\RequestCredit\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Label extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('starbucksb2b_requestlabel', 'id');
    }
}
