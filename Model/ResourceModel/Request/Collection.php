<?php
namespace Starbucksb2b\RequestCredit\Model\ResourceModel\Request;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Starbucksb2b\RequestCredit\Model\Request',
            'Starbucksb2b\RequestCredit\Model\ResourceModel\Request'
        );
    }
}
