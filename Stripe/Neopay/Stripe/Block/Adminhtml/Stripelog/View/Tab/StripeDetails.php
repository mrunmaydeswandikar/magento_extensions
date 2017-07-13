<?php
/**
 * Stripe admin grid tab - StripeDetails
 *
 * @category Neopay
 * @package Neopay_Stripe
 * @author Neo Team
 **/

namespace Neopay\Stripe\Block\Adminhtml\Stripelog\View\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

/**
 * Payment tab
 */
class StripeDetails extends Generic implements TabInterface
{
    /**
     * Main constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Stripe Account Details');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Stripe Account Details');
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Neopay\Stripe\Model\Stripe $stripe */
        $stripe = $this->_coreRegistry->registry('current_stripelog');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('stripedetails_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Sripe account details')]);

        if ($stripe->getId()) {
            $fieldset->addField('index_id', 'hidden', ['name' => 'index_id']);
        }

        
        $fieldset->addField(
            'stripe_account_number',
            'note',
            [
                'name'  => 'stripe_account_number',
                'label' => __('Account Number'),
                'title' => __('Account Number'),
                'text' => $stripe->getStripeAccountNumber()
            ]
        );

        $fieldset->addField(
            'stripe_account_email',
            'note',
            [
                'name'  => 'stripe_account_number',
                'label' => __('Account email'),
                'title' => __('Account email'),
                'text' => $stripe->getStripeAccountEmail()
            ]
        );


        $form->setValues($stripe->getData());
        $this->setForm($form);

        parent::_prepareForm();

        return $this;
    }
}
