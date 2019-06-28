<?php
namespace Starbucksb2b\RequestCredit\Controller\Adminhtml\Label;

use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Backend\App\Action\Context;

class NewAction extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Starbucksb2b_RequestCredit::label';

    /**
     * ForwardFactory
     * @var ForwardFactory
     */
    private $resultForwardFactory;

    /**
     * NewAction constructor.
     * @param Context $context
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory
    ) {
        parent::__construct($context);
        $this->resultForwardFactory = $resultForwardFactory;
    }

    /**
     * Forward to edit
     *
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();

        return $resultForward->forward('edit');
    }

    /**
     * Check Rule
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization
            ->isAllowed("Starbucksb2b_RequestCredit::requestcredit_access_controller_label_newaction");
    }
}
