<?php
/**
 * Stripe admin view block
 *
 * @category Neopay
 * @package Neopay_Stripe
 * @author Neo Team
 **/

namespace Neopay\Stripe\Block\Adminhtml\Stripelog;


/**
 * View Class
 */
class View extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * View constructor.
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param Status $statusSource
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data
    ) {
        parent::__construct($context, $data);

        $this->registry = $registry;
    }

    /**
     * Internal constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Stripelog'));

        $this->_objectId = 'index_id';
        $this->_blockGroup = 'Neopay_Stripe';
        $this->_controller = 'adminhtml_stripelog';
        $this->_mode = 'view';
    }

    /**
     * Get header text
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        return __('Edit stripelog');
    }

    /**
     * Prepare layout.
     *
     * @return $this
     */
    protected function _preparelayout()
    {
        /** @var \ParadoxLabs\Subscriptions\Model\Subscription $subscription */
        //$subscription = $this->registry->registry('current_subscription');

        $this->addButton(
            'save_and_edit',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => ['button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form']],
                ]
            ],
            100
        );

        parent::_prepareLayout();

        return $this;
    }
}
