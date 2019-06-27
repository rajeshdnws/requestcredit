<?php
namespace Starbucksb2b\RequestCredit\Model\Attribute\Source;

use Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory;
use Starbucksb2b\RequestCredit\Model\ResourceModel\Status;

class RefundOrder implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    protected $orderStatusCollection;

    /**
     * @var Status
     */
    protected $starbucksb2bRefundStatus;

    /**
     * RefundOrder constructor.
     * @param CollectionFactory $orderStatusCollection
     * @param Status $starbucksb2bRefundStatus
     */
    public function __construct(
        CollectionFactory $orderStatusCollection,
        Status $starbucksb2bRefundStatus
    ) {
        $this->orderStatusCollection = $orderStatusCollection;
        $this->starbucksb2bRefundStatus = $starbucksb2bRefundStatus;
    }

    /**
     * @return \Magento\Sales\Model\ResourceModel\Order\Status\Collection
     */
    public function getStatus()
    {
        $status = $this->orderStatusCollection->create();
        return $status;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $array = [];
        foreach ($this->getStatus() as $value) {
            $array[] = ['value' => $value->getStatus(), 'label' => $value->getLabel()];
        }
        return $array;
    }
}
