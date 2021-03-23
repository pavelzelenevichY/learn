<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

declare(strict_types=1);

namespace Codifi\Training\Model;

use Codifi\Training\Model\ConfigProvider;
use Magento\Customer\Model\Session;

/**
 * Class CustomerSession
 * @package Codifi\Training\Model
 */
class CustomerSession
{
    /**
     * Session
     *
     * @var Session
     */
    private $session;

    /**
     * Config provider
     *
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * CustomerSession constructor.
     *
     * @param \Codifi\Training\Model\ConfigProvider $configProvider
     * @param Session $session
     */
    public function __construct(
        ConfigProvider $configProvider,
        Session $session
    ) {
        $this->configProvider = $configProvider;
        $this->session = $session;
    }

    /**
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCustomerAttr(): bool
    {
        $customerData = $this->session->getCustomerData();
        $customerAttribute = $customerData->getCustomAttribute($this->configProvider::ATTRIBUTE_CODE_CREDIT_HOLD);
        if ($customerAttribute !== null) {
            $value = (bool)$customerAttribute->getValue();
        } else {
            $value = 0;
        }

        return $value;
    }

    /**
     * Get flag
     *
     * @return bool
     */
    public function getFlag(): bool
    {
        return (bool)$this->session->getData($this->configProvider::SESSION_FLAG);
    }

    /**
     * Set flag value true
     *
     * @return void
     */
    public function setFlag(): void
    {
        $this->session->setData($this->configProvider::SESSION_FLAG, true);
    }

    /**
     * Check
     *
     * @return bool
     */
    public function check(): bool
    {
        if (
            $this->configProvider->isOptionCreditHoldEnable() &&
            $this->getCustomerAttr() &&
            !$this->getFlag()
        ) {
            $check = true;
        } else {
            $check = false;
        }

        return $check;
    }

    /**
     * Get message and call set flag function
     *
     * @return string
     */
    public function getMessageAndCallSetFlag() : string
    {
        $this->setFlag();

        return $this->configProvider->getMessage();
    }
}
