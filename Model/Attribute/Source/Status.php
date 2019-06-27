<?php
namespace Starbucksb2b\RequestCredit\Model\Attribute\Source;

use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Starbucksb2b\RequestCredit\Model\ResourceModel\Status as starbucksb2bRefundStatus;

class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Remind Status values
     */
    const PENDING = 0;
    const ACCEPT = 1;
    const REJECT = 2;
    const NA = null;

    /**
     * @var CollectionFactory
     */
    protected $orderStatusCollection;

    /**
     * @var starbucksb2bRefundStatus
     */
    protected $starbucksb2bRefundStatus;

    /**
     * Status constructor.
     * @param CollectionFactory $orderStatusCollection
     * @param starbucksb2bRefundStatus $starbucksb2bRefundStatus
     */
    public function __construct(
        CollectionFactory $orderStatusCollection,
        starbucksb2bRefundStatus $starbucksb2bRefundStatus
    ) {
        $this->orderStatusCollection = $orderStatusCollection;
        $this->starbucksb2bRefundStatus = $starbucksb2bRefundStatus;
    }

    /**
     * To Option Array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $this->starbucksb2bRefundStatus->updateOrderRefundStatus();

        return [
            ['value' => self::PENDING,  'label' => __('Pending')],
            ['value' => self::ACCEPT,  'label' => __('Accept')],
            ['value' => self::REJECT,  'label' => __('Reject')],
            ['value' => self::NA,  'label' => __('N/A')]
        ];
    }
}
