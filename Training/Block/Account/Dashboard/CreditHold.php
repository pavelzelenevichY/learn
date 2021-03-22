<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

declare(strict_types=1);

namespace Codifi\Training\Block\Account\Dashboard;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Codifi\Training\Model\ConfigProvider;
use Codifi\Training\Model\CustomerSession;

/**
 * Class CreditHold
 * @package Codifi\Training\Block\Account\Dashboard
 */
class CreditHold extends Template
{
    /**
     * Customer session
     *
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * Config Provider
     *
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * CreditHold constructor.
     *
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        CustomerSession $customerSession,
        ConfigProvider $configProvider,
        array $data = []
    ) {
        $this->customerSession = $customerSession;
        $this->configProvider = $configProvider;

        parent::__construct($context, $data);
    }

    /**
     * Set flag value true
     */
    public function setFlag() : void
    {
        $this->customerSession->setFlag();
    }

    /**
     * Check function
     *
     * @return bool
     */
    public function check() : bool
    {
        return $this->customerSession->check();
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage() : string
    {
        $message = $this->configProvider->getMessage();

        return $this->escapeHtml($message);
    }
}
