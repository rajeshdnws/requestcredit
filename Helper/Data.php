<?php
namespace Starbucksb2b\RequestCredit\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollection;
use Magento\Customer\Model\Session as CustomerSession;

class Data extends AbstractHelper
{
    /**
     * B2B_CONFIG_ENABLE_MODULE
     */
    const B2B_CONFIG_ENABLE_MODULE = 'starbucksb2b_requestcredit/starbucksb2b_requestcredit_general/enable';

    /**
     * B2B_CONFIG_ORDER_REFUND
     */
    const B2B_CONFIG_ORDER_REFUND = 'starbucksb2b_requestcredit/starbucksb2b_requestcredit_general/canrefund';

    /**
     * B2B_CONFIG_TITLE_POPUP
     */
    const B2B_CONFIG_POPUP_TITLE = 'starbucksb2b_requestcredit/starbucksb2b_requestcredit_config/popup_title';

    /**
     * B2B_CONFIG_ENABLE_DROPDOWN
     */
    const B2B_CONFIG_ENABLE_DROPDOWN = 'starbucksb2b_requestcredit/starbucksb2b_requestcredit_config/enable_dropdown';

    /**
     * B2B_CONFIG_DROPDOWN_TITLE
     */
    const B2B_CONFIG_DROPDOWN_TITLE = 'starbucksb2b_requestcredit/starbucksb2b_requestcredit_config/dropdown_title';

    /**
     * B2B_CONFIG_ENABLE_OPTION
     */
    const B2B_CONFIG_ENABLE_OPTION = 'starbucksb2b_requestcredit/starbucksb2b_requestcredit_config/enable_option';

    /**
     * B2B_CONFIG_OPTION_TITLE
     */
    const B2B_CONFIG_OPTION_TITLE = 'starbucksb2b_requestcredit/starbucksb2b_requestcredit_config/option_title';

    /**
     * B2B_CONFIG_DETAIL_TITLE
     */
    const B2B_CONFIG_DETAIL_TITLE = 'starbucksb2b_requestcredit/starbucksb2b_requestcredit_config/detail_title';

    /**
     * B2B_CONFIG_TITLE
     */
    const B2B_CONFIG_TITLE = 'starbucksb2b_requestcredit/starbucksb2b_requestcredit_config/title';

    /**
     * B2B_CONFIG_ADMIN_EMAIL
     */
    const B2B_CONFIG_ADMIN_EMAIL = 'starbucksb2b_requestcredit/starbucksb2b_requestcredit_email_config/admin_email';

    /**
     * B2B_CONFIG_EMAIL_TEMPLATE
     */
    const B2B_CONFIG_EMAIL_TEMPLATE = 'starbucksb2b_requestcredit/starbucksb2b_requestcredit_email_config/email_template';

    /**
     * B2B_CONFIG_EMAIL_SENDER
     */
    const B2B_CONFIG_EMAIL_SENDER = 'starbucksb2b_requestcredit/starbucksb2b_requestcredit_email_config/email_sender';

    /**
     * B2B_CONFIG_ACCEPT_EMAIL
     */
    const B2B_CONFIG_ACCEPT_EMAIL = 'starbucksb2b_requestcredit/starbucksb2b_requestcredit_email_config/accept_email';

    /**
     * B2B_CONFIG_REJECT_EMAIL
     */
    const B2B_CONFIG_REJECT_EMAIL = 'starbucksb2b_requestcredit/starbucksb2b_requestcredit_email_config/reject_email';

    /**
     * ScopeConfigInterface
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var OrderCollection
     */
    protected $orderCollectionFactory;

    /**
     * @var CustomerSession
     */
    protected $customerSession;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param OrderCollection $orderCollectionFactory
     * @param CustomerSession $customerSession
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        OrderCollection $orderCollectionFactory,
        CustomerSession $customerSession
    ) {
        parent::__construct($context);
        $this->scopeConfig = $context->getScopeConfig();
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->customerSession = $customerSession;
    }

    //General config admin

    /**
     * Get Config Enable Module
     *
     * @return string
     */
    public function getConfigEnableModule()
    {
        return $this->scopeConfig->getValue(
            self::B2B_CONFIG_ENABLE_MODULE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getOrderRefund()
    {
        return $this->scopeConfig->getValue(
            self::B2B_CONFIG_ORDER_REFUND,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get Config Title Module
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->scopeConfig->getValue(
            self::B2B_CONFIG_TITLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get Config Title Module
     *
     * @return string
     */
    public function getPopupModuleTitle()
    {
        return $this->scopeConfig->getValue(
            self::B2B_CONFIG_POPUP_TITLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get Config Enable Dropdown In Modal Popup
     *
     * @return string
     */
    public function getConfigEnableDropdown()
    {
        return $this->scopeConfig->getValue(
            self::B2B_CONFIG_ENABLE_DROPDOWN,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get Config Title Dropdown Modal Popup
     *
     * @return string
     */
    public function getDropdownTitle()
    {
        return $this->scopeConfig->getValue(
            self::B2B_CONFIG_DROPDOWN_TITLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get Config Enable Yes/No Option
     *
     * @return string
     */
    public function getConfigEnableOption()
    {
        return $this->scopeConfig->getValue(
            self::B2B_CONFIG_ENABLE_OPTION,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get Config Title Yes/No Option
     *
     * @return string
     */
    public function getOptionTitle()
    {
        return $this->scopeConfig->getValue(
            self::B2B_CONFIG_OPTION_TITLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get Config
     *
     * @return string
     */
    public function getDetailTitle()
    {
        return $this->scopeConfig->getValue(
            self::B2B_CONFIG_DETAIL_TITLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getAdminEmail()
    {
        return $this->scopeConfig->getValue(
            self::B2B_CONFIG_ADMIN_EMAIL,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getEmailTemplate()
    {
        return $this->scopeConfig->getValue(
            self::B2B_CONFIG_EMAIL_TEMPLATE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function configSenderEmail()
    {
        return $this->scopeConfig->getValue(
            self::B2B_CONFIG_EMAIL_SENDER,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getRejectEmailTemplate()
    {
        return $this->scopeConfig->getValue(
            self::B2B_CONFIG_REJECT_EMAIL,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getAcceptEmailTemplate()
    {
        return $this->scopeConfig->getValue(
            self::B2B_CONFIG_ACCEPT_EMAIL,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return array
     */
    public function getOrderByCustomerId()
    {
        $customerId = $this->customerSession->getCustomer()->getId();
        $collection = $orders = [];

        if ($customerId) {
            $collection = $this->orderCollectionFactory->create()->addFieldToSelect(
                '*'
            )->addFieldToFilter(
                'customer_id',
                $customerId
            )->setOrder(
                'created_at',
                'desc'
            );
        }

        if (!empty($collection)) {
            foreach ($collection as $order) {
                $orders[] = [
                    "increment_id" => $order->getIncrementId(),
                    "status" => $order->getStatus()
                ];
            }
        }

        return $orders;
    }
}
