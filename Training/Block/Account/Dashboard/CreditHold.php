<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

namespace Codifi\Training\Block\Account\Dashboard;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\App\ObjectManager;

/**
 * Class CreditHold
 * @package Codifi\Training\Block\Account\Dashboard
 */
class CreditHold extends Template
{
    /**
     * Path to the system option Enabled - Credit Hold.
     *
     * @var string
     */
    const PATH_OPTION_ENABLE = 'codifi/credit_hold/active';

    /**
     * Path to the system option Value - Message Credit Hold.
     *
     * @var string
     */
    const PATH_OPTION_MESSAGE = 'codifi/credit_hold/message';

    /**
     * Block Repository Interface
     *
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

    /**
     * CreditHold constructor.
     * @param BlockRepositoryInterface $blockRepository
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        BlockRepositoryInterface $blockRepository,
        Context $context,
        array $data = []
    ) {
        $this->blockRepository = $blockRepository;
        parent::__construct($context, $data);
    }

    /**
     * Get credit_hold attribute
     *
     * @return string
     */
    private function getCustomerAttr() : string
    {
        $objectManager = ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        if ($customerSession->isLoggedIn())
        {
            $customer = $customerSession->getCustomer();
            $customerCreditHold = $customer->getData('credit_hold');
        } else {
            $customerCreditHold = '';
        }

        return $customerCreditHold;
    }

    /**
     * Get options enabled and message value and check customer attribute.
     *
     * @return string
     */
    public function getOptionCreditHoldEnable() : string
    {
        $optionIsEnable = $this->_scopeConfig->getValue(self::PATH_OPTION_ENABLE);
        if (
            $optionIsEnable === '1' &&
            $this->getCustomerAttr() === '1'
        ) {
            $message = $this->_scopeConfig->getValue(self::PATH_OPTION_MESSAGE);
        } else {
            $message = '';
        }

        return $message;
    }
}
