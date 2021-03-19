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
use Magento\Customer\Model\Session;

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
     * @var Session
     */
    private $session;

    /**
     * Block Repository Interface
     *
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

    /**
     * CreditHold constructor.
     * @param Session $session
     * @param BlockRepositoryInterface $blockRepository
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Session $session,
        BlockRepositoryInterface $blockRepository,
        Context $context,
        array $data = []
    ) {
        $this->session = $session;
        $this->blockRepository = $blockRepository;
        parent::__construct($context, $data);
    }

    /**
     * Get credit_hold attribute
     *
     * @return int
     */
    public function getCustomerAttr() : int
    {
        $customerData = $this->session->getCustomerData();
        $customerAttribute = $customerData->getCustomAttribute('credit_hold');
        $value = $customerAttribute->getValue();

        return $value;
    }

    /**
     * Get options enabled and message value and check customer attribute.
     *
     * @return int
     */
    public function getOptionCreditHoldEnable() : int
    {
        $optionIsEnable = $this->_scopeConfig->getValue(self::PATH_OPTION_ENABLE);
        if ($optionIsEnable === '1') {
            $enabled = 1;
        } else {
            $enabled = 0;
        }

        return $enabled;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->_scopeConfig->getValue(self::PATH_OPTION_MESSAGE);
    }
}
