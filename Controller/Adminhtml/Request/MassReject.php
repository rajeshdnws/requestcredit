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
namespace Starbucksb2b\RequestCredit\Controller\Adminhtml\Request;

class MassReject extends \Magento\Backend\App\Action
{
    /**
     * @var \Starbucksb2b\RequestCredit\Helper\Data
     */
    protected $helper;

    /**
     * @var \Starbucksb2b\RequestCredit\Helper\Email
     */
    protected $emailSender;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $datetime;

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
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $timezone;

    /**
     * @var \Magento\Framework\Locale\ListsInterface
     */
    protected $localeLists;

    /**
     * MassReject constructor.
     * @param \Starbucksb2b\RequestCredit\Helper\Email $emailSender
     * @param \Starbucksb2b\RequestCredit\Helper\Data $helper
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $datetime
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Starbucksb2b\RequestCredit\Model\ResourceModel\Request\CollectionFactory $collectionFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     * @param \Magento\Framework\Locale\ListsInterface $localeLists
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Starbucksb2b\RequestCredit\Helper\Email $emailSender,
        \Starbucksb2b\RequestCredit\Helper\Data $helper,
        \Magento\Framework\Stdlib\DateTime\DateTime $datetime,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Starbucksb2b\RequestCredit\Model\ResourceModel\Request\CollectionFactory $collectionFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        \Magento\Framework\Locale\ListsInterface $localeLists,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->helper = $helper;
        $this->emailSender = $emailSender;
        $this->datetime = $datetime;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->scopeConfig = $scopeConfig;
        $this->timezone = $timezone;
        $this->localeLists = $localeLists;
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
            $acceptOder = 0;
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            try {
                foreach ($collection as $item) {
                    if ($item["refund_status"] != 2) {
                        $this->setStatus($item);
                        $this->sendEmail($item);
                        $acceptOder++;
                    }
                }
                $this->messageManager->addSuccessMessage(__('%1 refund request has been rejected.', $acceptOder));
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
        $item->setData('refund_status', 2);
        $item->save();
    }

    /**
     * @param $item
     */
    protected function sendEmail($item)
    {
        $customerEmail = $item->getCustomerEmail();
        $timezone = $this->scopeConfig->getValue('general/locale/timezone', \Magento\Store\Model\
            ScopeInterface::SCOPE_STORE);
        $date = $this->timezone->date();
        $timezoneLabel = $this->getTimezoneLabelByValue($timezone);
        $date = $date->format('Y-m-d h:i:s A')." ".$timezoneLabel;
        $emailTemplate = $this->helper->getRejectEmailTemplate();
        $emailTemplateData = [
            'incrementId' => $item["increment_id"],
            'id' => $item["id"],
            'timeApproved'=> $date,
            'customerName' => $item["customer_name"]
        ];
        $this->emailSender->sendEmail($customerEmail, $emailTemplate, $emailTemplateData);
    }

    /**
     * @param $timezoneValue
     * @return string
     */
    protected function getTimezoneLabelByValue($timezoneValue)
    {
        $timezones = $this->localeLists->getOptionTimezones();
        $label = '';
        foreach ($timezones as $zone) {
            if ($zone["value"] == $timezoneValue) {
                $label = $zone["label"];
            }
        }
        return $label;
    }

    /**
     * Check Rule
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization
            ->isAllowed("Starbucksb2b_RequestCredit::requestcredit_access_controller_request_massreject");
    }
}
