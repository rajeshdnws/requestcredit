<?php
namespace Starbucksb2b\RequestCredit\Controller\Adminhtml\Label;

class MassDisable extends \Magento\Backend\App\Action
{
    /**
     * @var \Starbucksb2b\RequestCredit\Helper\Data
     */
    protected $helper;
    /**
     * Mass Action Filter
     *
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $filter;

    /**
     * Collection Factory
     *
     * @var \Starbucksb2b\RequestCredit\Model\ResourceModel\Request\CollectionFactory
     */
    protected $collectionFactory;
    /**
     * MassDisable constructor.
     * @param \Starbucksb2b\RequestCredit\Helper\Data $helper
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Starbucksb2b\RequestCredit\Model\ResourceModel\Label\CollectionFactory $collectionFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Starbucksb2b\RequestCredit\Helper\Data $helper,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Starbucksb2b\RequestCredit\Model\ResourceModel\Label\CollectionFactory $collectionFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->helper = $helper;
        $this->filter            = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        if ($this->helper->getConfigEnableModule()) :
            $setStatus = 0;
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            try {
                foreach ($collection as $item) {
                    if ($item["status"] != 1) {
                        $this->setStatus($item);
                    }
                    $setStatus++;
                }
                $this->messageManager->addSuccessMessage(__('%1 option(s) has been disable.', $setStatus));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/');
            }
        else :
                $this->messageManager->addWarningMessage(__('Module is disabled.'));
                return $resultRedirect->setPath('*/*/');
        endif;
    }

    /**
     * @param $item
     */
    protected function setStatus($item)
    {
        $item->setData('status', 1);
        $item->save();
    }

    /**
     * Check Rule
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization
            ->isAllowed("Starbucksb2b_RequestCredit::requestcredit_access_controller_label_massdisable");
    }
}
