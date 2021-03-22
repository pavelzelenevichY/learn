<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

declare(strict_types=1);

namespace Codifi\Training\Block\Account\Dashboard;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session;
use Codifi\Training\Setup\Patch\Data\AddCustomerAttributeCreditHold;
use Magento\Framework\Escaper;

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
     * Name of session attribute for once show popup.
     *
     * @var string
     */
    const SESSION_FLAG = 'flag';

    /**
     * Customer session.
     *
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
     * @var Escaper
     */
    public $escaper;

    /**
     * CreditHold constructor
     *
     * @param Context $context
     * @param Session $session
     * @param BlockRepositoryInterface $blockRepository,
     * @param array $data
     */
    public function __construct(
        Context $context,
        Session $session,
        BlockRepositoryInterface $blockRepository,
        array $data = []
    ) {
        $this->session = $session;
        $this->blockRepository = $blockRepository;
        parent::__construct($context, $data);
    }

    /**
     * Get credit_hold attribute value
     *
     * @return bool
     */
    public function getCustomerAttr() : bool
    {
        $customerData = $this->session->getCustomerData();
        $customerAttribute = $customerData->getCustomAttribute(AddCustomerAttributeCreditHold::ATTRIBUTE_CODE);
        if ($customerAttribute !== null) {
            $value = (bool)$customerAttribute->getValue();
        } else {
            $value = 0;
        }
        return $value;
    }

    /**
     * Get options enabled and message value and check customer attribute.
     *
     * @return bool
     */
    public function isCreditHoldConfigEnabled() : bool
    {
        return (bool)$this->_scopeConfig->getValue(self::PATH_OPTION_ENABLE, $this->_scopeConfig::SCOPE_TYPE_DEFAULT);
    }

    /**
     * Flag for onse show popup
     *
     * @return bool
     */
    public function getFlag() : bool
    {
        return (bool)$this->session->getData(self::SESSION_FLAG);
    }

    /**
     * Set flag value true
     */
    public function setFlag() : void
    {
        $this->session->setData(self::SESSION_FLAG, true);
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage() : string
    {
        $message = $this->_scopeConfig->getValue(self::PATH_OPTION_MESSAGE);
        return $this->escapeHtml($message);
    }
}
