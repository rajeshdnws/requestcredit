<?php
namespace Starbucksb2b\RequestCredit\Model;

use Magento\Framework\Model\AbstractModel;

class Request extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Starbucksb2b\RequestCredit\Model\ResourceModel\Request');
    }

    /**
     * @param $oderId
     */
    public function setOrderId($oderId)
    {
        $this->setData("increment_id", $oderId);
    }

    /**
     * @param $reasonComment
     */
    public function setReasonComment($reasonComment)
    {
        $this->setData("reason_comment", $reasonComment);
    }

    /**
     * @param $time
     */
    public function setTime($time)
    {
        $this->setData("create_at", $time);
    }

    /**
     * @param $option
     */
    public function setOption($option)
    {
        $this->setData("reason_option", $option);
    }

    /**
     * @param $radio
     */
    public function setRadio($radio)
    {
        $this->setData("radio_option", $radio);
    }

    /**
     * @param $customerName
     */
    public function setCustomerName($customerName)
    {
        $this->setData("customer_name", $customerName);
    }

    /**
     * @param $customerEmail
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->setData("customer_email", $customerEmail);
    }
}
