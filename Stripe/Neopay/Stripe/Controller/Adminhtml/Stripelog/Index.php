<?php
/**
 * Admin Index controller
 *
 * @category Neopay
 * @package Neopay_Stripe
 * @author Neo Team
 **/

namespace Neopay\Stripe\Controller\Adminhtml\Stripelog;

class Index extends \Magento\Backend\App\Action
{
	protected $_resultPage;
	protected $_resultPageFactory = false;
	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory
	) {
		parent::__construct($context);
		$this->_resultPageFactory = $resultPageFactory;
	}

	public function execute()
	{
		//Call page factory to render layout and page content
		$this->_setPageData();
        return $this->getResultPage();
	}

	/*
	 * Check permission via ACL resource
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('Neopay_Stripe::stripelog');
	}

    public function getResultPage()
    {
        if (is_null($this->_resultPage)) {
            $this->_resultPage = $this->_resultPageFactory->create();
        }
        return $this->_resultPage;
    }

    protected function _setPageData()
    {
        $resultPage = $this->getResultPage();
        $resultPage->setActiveMenu('Neopay_Stripe::stripelog');
        $resultPage->getConfig()->getTitle()->prepend((__('Stripe log')));

        //Add bread crumb
        $resultPage->addBreadcrumb(__('Neopay'), __('Neopay'));
        $resultPage->addBreadcrumb(__('Stripe log'), __('Stripe log'));

        return $this;
    }
}