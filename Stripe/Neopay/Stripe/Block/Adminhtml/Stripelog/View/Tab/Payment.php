<?php
/**
 * Stripe admin grid tab - Payment
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
class Payment extends Generic implements TabInterface
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
        return __('Payment');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Payment');
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
        $form->setHtmlIdPrefix('payment_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Payment Details')]);

        if ($stripe->getId()) {
            $fieldset->addField('index_id', 'hidden', ['name' => 'index_id']);
        }

        
        $fieldset->addField(
            'cc_last_4',
            'note',
            [
                'name'  => 'cc_last_4',
                'label' => __('Credit Card'),
                'title' => __('Credit Card'),
                'text' => $stripe->getCcLast4()
            ]
        );

        $fieldset->addField(
            'cc_type',
            'note',
            [
                'name'  => 'cc_type',
                'label' => __('Card Type'),
                'title' => __('Card Type'),
                'text' => $stripe->getCcType()
            ]
        );


        $form->setValues($stripe->getData());
        $this->setForm($form);

        parent::_prepareForm();

        return $this;
    }
}
