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
        return $this->customerSession->getMessageAndCallSetFlag();
    }
}
