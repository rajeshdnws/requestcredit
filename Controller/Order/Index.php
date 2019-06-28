<?php
/**
 * B2B Commerce Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://starbucksb2bcommerce.com/Starbucksb2b-Commerce-License.txt
 *
 * @category   B2B
 * @package    Starbucksb2b_RequestCredit
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 B2B Commerce Co. ( http://starbucksb2bcommerce.com )
 * @license    http://starbucksb2bcommerce.com/Starbucksb2b-Commerce-License.txt
 */
namespace Starbucksb2b\RequestCredit\Controller\Order;

use Starbucksb2b\RequestCredit\Helper\Data;
use Starbucksb2b\RequestCredit\Helper\Email;
use Starbucksb2b\RequestCredit\Model\RequestFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var Email
     */
    protected $emailSender;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var OrderInterface
     */
    protected $orderInterface;

    /**
     * @var RequestFactory
     */
    protected $requestFactory;

    /**
     * @var
     */
    protected $resultFactory;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $formKeyValidator;
    
    /**
     * @var PageFactory
     */
    protected $UploaderFactory;
	
    /**
     * @var PageFactory
     */
    protected $AdapterFactory;
	
    /**
     * @var PageFactory
     */
    protected $filesystem;
    /**
     * Index constructor.
     * @param Email $emailSender
     * @param Data $helper
     * @param OrderInterface $orderInterface
     * @param RequestFactory $requestFactory
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param UploaderFactory $UploaderFactory
	 * @param AdapterFactory $AdapterFactory
	 * @param Filesystem $filesystem
	 * @param Validator $formKeyValidator
     */
    public function __construct(
        Email $emailSender,
        Data $helper,
        OrderInterface $orderInterface,
        RequestFactory $requestFactory,
        Context $context,
        PageFactory $resultPageFactory,
        Validator $formKeyValidator,
		UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory,
        Filesystem $filesystem
    ) {
        $this->emailSender        = $emailSender;
        $this->helper             = $helper;
        $this->orderInterface     = $orderInterface;
        $this->requestFactory    = $requestFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->formKeyValidator = $formKeyValidator;
		$this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            $this->messageManager->addErrorMessage("Invalid request!");
            return $resultRedirect->setPath('customer/account/');
        }
        $model= $this->requestFactory->create();
        $data= $this->getRequest()->getPostValue();
		echo $_FILES['starbucksb2b-image']['name'];die;
		if(isset($_FILES['starbucksb2b-image']['name']) && $_FILES['starbucksb2b-image']['name'] != '') {
		try{
		$uploaderFactory = $this->uploaderFactory->create(['fileId' => 'starbucksb2b-image']);
		$uploaderFactory->setAllowedExtensions(['jpg','png']);
		$imageAdapter = $this->adapterFactory->create();
		//$uploaderFactory->addValidateCallback('custom_image_upload',$imageAdapter,'validateUploadFile');
		$uploaderFactory->setAllowRenameFiles(true);
		$uploaderFactory->setFilesDispersion(true);
		$mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
		$destinationPath = $mediaDirectory->getAbsolutePath('starbucksb2b/requestcredit');
		$result = $uploaderFactory->save($destinationPath);
		if (!$result)
			{
		throw new LocalizedException(
		__('File cannot be saved to path: $1', $destinationPath)
		);
		  $this->messageManager->addErrorMessage(__('File cannot be saved to path: $1', $destinationPath));
            return $resultRedirect->setPath('customer/account/');
		}
		
		$imagePath = 'starbucksb2b/requestcredit'.$result['file'];
		$data['image'] = $imagePath;
		} 
		catch (\Exception $e)
		{
		$this->messageManager->addErrorMessage($e->getMessage());
		$resultRedirect->setPath('customer/account/');
		return $resultRedirect;
		}
			
		}
        if ($data) {
            if ($this->helper->getConfigEnableDropdown()) {
                $option = $data['starbucksb2b-option'];
            } else {
                $option = '';
            }
            if ($this->helper->getConfigEnableDropdown()) {
                $radio = $data['starbucksb2b-radio'];
            } else {
                $radio = '';
            }
            $reasonComment = $data['starbucksb2b-refund-reason'];
            $incrementId   = $data['starbucksb2b-refund-order-id'];
            $orderData     = $this->orderInterface->loadByIncrementId($incrementId);
            try {
                $model->setOption($option);
                $model->setRadio($radio);
                $model->setOrderId($incrementId);
                $model->setReasonComment($reasonComment);
                $model->setCustomerName($orderData->getCustomerName());
                $model->setCustomerEmail($orderData->getCustomerEmail());
                $model->save();
                try {
                    $this->sendEmail($orderData);
                    $this->messageManager
                        ->addSuccessMessage(__('Your refund request number #' . $incrementId . ' has been submited.'));
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                    return $resultRedirect->setPath('customer/account/');
                }
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('customer/account/');
            }
        }
        return $resultRedirect->setPath('customer/account/');
    }

    /**
     * @param $orderData
     */
    protected function sendEmail($orderData)
    {
        $emailTemplate = $this->helper->getEmailTemplate();
        $adminEmail    = $this->helper->getAdminEmail();
        $adminEmails   = explode(",", $adminEmail);
        $countEmail    = count($adminEmails);
        if ($countEmail > 1) {
            foreach ($adminEmails as $value) {
                $value             = str_replace(' ', '', $value);
                $emailTemplateData = [
                    'adminEmail'   => $value,
                    'incrementId'  => $orderData->getIncrementId(),
                    'customerName' => $orderData->getCustomerName(),
                    'createdAt'    => $orderData->getCreatedAt(),
                ];
                $this->emailSender->sendEmail($value, $emailTemplate, $emailTemplateData);
            }
        } else {
            $emailTemplateData = [
                'adminEmail'   => $adminEmail,
                'incrementId'  => $orderData->getIncrementId(),
                'customerName' => $orderData->getCustomerName(),
                'createdAt'    => $orderData->getCreatedAt(),
            ];
            $this->emailSender->sendEmail($adminEmail, $emailTemplate, $emailTemplateData);
        }
    }
}
