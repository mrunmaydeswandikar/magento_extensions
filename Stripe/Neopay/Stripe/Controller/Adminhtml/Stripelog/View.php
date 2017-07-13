<?php
/**
 * Admin View controller
 *
 * @category Neopay
 * @package Neopay_Stripe
 * @author Neo Team
 **/

namespace Neopay\Stripe\Controller\Adminhtml\Stripelog;

use Magento\Backend\App\Action;

/**
 * Strielog form
 */
class View extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Neopay\Stripe\Model\StripeFactory
     */
    protected $_stripeFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $resultLayoutFactory;

    /**
     * @var \ParadoxLabs\Subscriptions\Helper\Data
     */
    protected $helper;

    protected $_logger;

    /**
     * Index constructor.
     *
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     * @param \ParadoxLabs\Subscriptions\Api\SubscriptionRepositoryInterface $subscriptionRepository
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
     * @param \ParadoxLabs\Subscriptions\Helper\Data $helper
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \Neopay\Stripe\Model\StripeFactory $stripeFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->registry = $registry;
        $this->customerRepository = $customerRepository;
        $this->resultLayoutFactory = $resultLayoutFactory;
        $this->_stripeFactory = $stripeFactory;
        $this->_logger = $logger;
        parent::__construct($context);
    }

    /**
     * Subscriptions list action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $initialized = $this->initModels();

        if ($initialized !== true) {
            $this->messageManager->addErrorMessage(__('Could not load the requested subscription.'));

            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('*/*/index');
            return $resultRedirect;
        }

        $resultPage = $this->resultPageFactory->create();

        /**
         * Set active menu item
         */
        $resultPage->setActiveMenu('ParadoxLabs_Subscriptions::subscriptions_manage');
        $resultPage->getConfig()->getTitle()->prepend(__('Stripelog'));

        /**
         * Add breadcrumb item
         */
        $resultPage->addBreadcrumb(__('Stripelog'), __('Stripelog'));
        $resultPage->addBreadcrumb(__('View details'), __('View details'));

        return $resultPage;
    }

    /**
     * Determine if authorized to perform these actions.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('ParadoxLabs_Subscriptions::subscriptions');
    }

    /**
     * Initialize subscription/customer models for the current request.
     *
     * @return bool Successful or not
     */
    protected function initModels()
    {
        $this->_logger->addDebug("In init models");
        /**
         * Load subscription by ID.
         */
        $id = (int)$this->getRequest()->getParam('index_id');
        $this->_logger->addDebug("$id : ".$id);

        try {
            /** @var \Neopay\Stripe\Model\Stripe $stripe */
            $model = $this->_stripeFactory->create();
            $collection = $model->getCollection()->addFieldToFilter("index_id",$id);
            $stripe = $collection->getLastItem();
        } catch (\Exception $e) {
            $this->_logger->addDebug("Exception : ".$e->getMessage());
            return false;
        }
        $this->_logger->addDebug("Model id : ".$stripe->getIndexId());

        /**
         * If it doesn't exist, fail (redirect to grid).
         */
        if ($id < 1 || $stripe->getIndexId() != $id) {
            return false;
        }

        $this->registry->register('current_stripelog', $stripe);

        // /**
        //  * Load and set customer (if any) for TokenBase.
        //  */
        // if ($stripe->getCustomerEmail()) {
        //     $customer = $this->customerRepository->get($stripe->getCustomerEmail());

        //     if ($customer->getId() == $stripe->getCustomerEmail()) {
        //         $this->registry->register('current_customer', $customer);
        //     }
        // }

        return true;
    }
}
