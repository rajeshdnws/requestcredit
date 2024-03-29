<?php
namespace  Starbucksb2b\RequestCredit\Model\Plugin;

class Validate extends \Magento\Config\Controller\Adminhtml\System\Config\Save
{

    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    private $redirectFactory;

    /**
     * Save constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Config\Model\Config\Structure $configStructure
     * @param \Magento\Config\Controller\Adminhtml\System\ConfigSectionChecker $sectionChecker
     * @param \Magento\Config\Model\Config\Factory $configFactory
     * @param \Magento\Framework\Cache\FrontendInterface $cache
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Config\Model\Config\Structure $configStructure,
        \Magento\Config\Controller\Adminhtml\System\ConfigSectionChecker $sectionChecker,
        \Magento\Config\Model\Config\Factory $configFactory,
        \Magento\Framework\Cache\FrontendInterface $cache,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
    ) {
        $this->redirectFactory = $redirectFactory;
        parent::__construct(
            $context,
            $configStructure,
            $sectionChecker,
            $configFactory,
            $cache,
            $string
        );
    }

    /**
     * @param $subject
     * @param $proceed
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function aroundExecute($subject, $proceed)
    {
        $parameters = $this->getRequest()->getParam("groups");
        if (isset($parameters["starbucksb2b_requestcredit_email_config"])) {
            $emails = '';
            if (isset($parameters["starbucksb2b_requestcredit_email_config"]["fields"]["admin_email"]["value"])) {
                $emails = $parameters["starbucksb2b_requestcredit_email_config"]["fields"]["admin_email"]["value"];
            }
            if ($emails != '') {
                $emailList = explode(",", $emails);
                $error = false;
                foreach ($emailList as $email) {
                    $checkEmail = trim($email);
                    if ($this->emailValidation($checkEmail)) {
                        $error = false;
                    } else {
                        $error = true;
                        break;
                    }
                }
                if ($error) {
                    $this->messageManager->addErrorMessage(__("One or more admin email has an invalid email format!"));
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath(
                        'adminhtml/system_config/edit',
                        [
                            '_current' => ['section', 'website', 'store'],
                            '_nosid' => true
                        ]
                    );
                } else {
                    return $proceed();
                }
            } else {
                return $proceed();
            }
        }
        return $proceed();
    }

    /**
     * @param $email
     * @return bool
     */
    protected function emailValidation($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        };
        return false;
    }
}
