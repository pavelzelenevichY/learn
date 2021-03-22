<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

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
    public function getCustomerAttr() : bool
    {
        $customerData = $this->session->getCustomerData();
        $customerAttribute = $customerData->getCustomAttribute(ConfigProvider::ATTRIBUTE_CODE_CREDIT_HOLD);
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
    public function getFlag() : bool
    {
        return (bool)$this->session->getData(ConfigProvider::SESSION_FLAG);
    }

    /**
     * Set flag value true
     */
    public function setFlag() : void
    {
        $this->session->setData(ConfigProvider::SESSION_FLAG, true);
    }

    /**
     * Check
     *
     * @return bool
     */
    public function check() : bool
    {
        if (
        $this->configProvider->isOptionEnable() &&
        $this->getCustomerAttr() &&
        !$this->getFlag()
        ) {
            $check = true;
        } else {
            $check = false;
        }

        return $check;
    }

}
