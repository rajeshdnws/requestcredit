<?php
namespace Starbucksb2b\RequestCredit\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\Filter\FilterManager;
use Magento\Sales\Api\Data\OrderInterface;

/**
 * Class Name
 * @package Starbucksb2b\RequestCredit\Ui\Component\Listing\Columns
 */
class Customer extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var OrderInterface
     */
    protected $orderInterface;

    /**
     * @var FilterManager
     */
    private $filterManager;

    /**
     * Customer constructor.
     * @param OrderInterface $orderInterface
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param FilterManager $filterManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        OrderInterface $orderInterface,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        FilterManager $filterManager,
        array $components = [],
        array $data = []
    ) {
        $this->orderInterface = $orderInterface;
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->filterManager = $filterManager;
    }

    /**
     * {@inheritdoc}
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['customer_name'])) {
                    $customerId = $this->getCustomerId($item);
                    $item['customer_name_url'] = $this->getLink($customerId);
                }
            }
        }

        return $dataSource;
    }

    /**
     * @param $entityId
     * @return string
     */
    private function getLink($entityId)
    {
        return $this->context->getUrl('customer/index/edit', ['id' => $entityId]);
    }

    /**
     * @param $item
     * @return mixed
     */
    private function getCustomerId($item)
    {
        $incrementId = $item['increment_id'];
        $orderData = $this->orderInterface->loadByIncrementId($incrementId)->getCustomerId();
        return $orderData;
    }
}
