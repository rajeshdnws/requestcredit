<?php
namespace Starbucksb2b\RequestCredit\Block;

use Starbucksb2b\RequestCredit\Model\ResourceModel\Request\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Sales\Block\Order\History;

class Label extends Template
{
    /**
     * @var \Starbucksb2b\RequestCredit\Helper\Data
     */
    protected $helper;

    /**
     * @var \Starbucksb2b\RequestCredit\Model\ResourceModel\Label\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var CollectionFactory
     */
    protected $requestCollectionFactory;

    /**
     * @var History
     */
    protected $history;

    /**
     * @var Context
     */
    private $context;

    /**
     * @var array
     */
    private $data;

    /**
     * @var \Magento\Framework\Data\Form\FormKey
     */
    protected $formKey;

    /**
     * Label constructor.
     * @param \Starbucksb2b\RequestCredit\Helper\Data $helper
     * @param History $history
     * @param \Starbucksb2b\RequestCredit\Model\ResourceModel\Label\CollectionFactory $collectionFactory
     * @param CollectionFactory $requestCollectionFactory
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        \Starbucksb2b\RequestCredit\Helper\Data $helper,
        History $history,
        \Starbucksb2b\RequestCredit\Model\ResourceModel\Label\CollectionFactory $collectionFactory,
        CollectionFactory $requestCollectionFactory,
        Context $context,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->requestCollectionFactory = $requestCollectionFactory;
        $this->history = $history;
        $this->collectionFactory = $collectionFactory;
        $this->formKey = $context->getFormKey();
        parent::__construct($context, $data);
        $this->context = $context;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getConfigEnableModule()
    {
        return $this->helper->getConfigEnableModule();
    }

    /**
     * @return string
     */
    public function getConfigEnableDropdown()
    {
        return $this->helper->getConfigEnableDropdown();
    }

    /**
     * @return string
     */
    public function getDropdownTitle()
    {
        return $this->helper->getDropdownTitle();
    }

    /**
     * @return string
     */
    public function getConfigEnableOption()
    {
        return $this->helper->getConfigEnableOption();
    }

    /**
     * @return string
     */
    public function getOptionTitle()
    {
        return $this->helper->getOptionTitle();
    }

    /**
     * @return string
     */
    public function getDetailTitle()
    {
        return $this->helper->getDetailTitle();
    }

    /**
     * @return string
     */
    public function getPopupModuleTitle()
    {
        return $this->helper->getPopupModuleTitle();
    }

    /**
     * @return mixed
     */
    public function getOrderRefund()
    {
        return $this->helper->getOrderRefund();
    }

    /**
     * @return \Starbucksb2b\RequestCredit\Model\ResourceModel\Request\Collection
     */
    public function getRefundStatus()
    {
        $refundCollection = $this->requestCollectionFactory->create();
        $refundCollection->addFieldToSelect(['refund_status', 'increment_id']);
        return $refundCollection;
    }

    /**
     * @return \Starbucksb2b\RequestCredit\Model\ResourceModel\Label\Collection
     */
    public function getLabel()
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('status', 0);
        return $collection;
    }

    /**
     * @return bool|\Magento\Sales\Model\ResourceModel\Order\Collection
     */
    public function getOrder()
    {
        return $this->history->getOrders();
    }

    /**
     * @return string
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

    /**
     * @return array
     */
    public function getOrderCollectionByCutomerId()
    {
        return $this->helper->getOrderByCustomerId();
    }
}
