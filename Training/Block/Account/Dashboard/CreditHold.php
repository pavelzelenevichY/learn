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

class CreditHold extends Template
{
    /**
     * Path to the system option Enabled - Credit Hold.
     */
    const PATH_OPTION_ENABLE = 'codifi/credit_hold/active';

    /**
     * Path to the system option Value - Message Credit Hold.
     */
    const PATH_OPTION_MESSAGE = 'codifi/credit_hold/message';

    /**
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
     * @return mixed
     */
    private function getCustomerAttr() {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        if ($customerSession->isLoggedIn()) {
            return $customerCreditHold = $customerSession->getCustomer()->getData('credit_hold');
        }
    }

    /**
     * @return false|mixed
     */
    public function getOptionCreditHoldEnable() {
        $optionIsEnable = $this->_scopeConfig->getValue(self::PATH_OPTION_ENABLE);
        if ($optionIsEnable === '1' && $this->getCustomerAttr() === '1') {
            return $this->_scopeConfig->getValue(self::PATH_OPTION_MESSAGE);
        } else {
            return '';
        }
    }

}
