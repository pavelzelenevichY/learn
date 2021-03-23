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
use Magento\Backend\Model\Auth\Session;

/**
 * Class AdminSession
 * @package Codifi\Training\Model
 */
class AdminSession
{
    /**
     * Auth session
     *
     * @var Session
     */
    private $authSession;

    /**
     * Backend session
     *
     * @var \Magento\Backend\Model\Session
     */
    protected $backendSession;

    /**
     * Config provider
     *
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * AdminSession constructor.
     *
     * @param \Codifi\Training\Model\ConfigProvider $configProvider
     * @param Session $authSession
     * @param \Magento\Backend\Model\Session $backendSession
     */
    public function __construct(
        ConfigProvider $configProvider,
        Session $authSession,
        \Magento\Backend\Model\Session $backendSession
    ) {
        $this->configProvider = $configProvider;
        $this->authSession = $authSession;
        $this->backendSession = $backendSession;
    }

    /**
     * Get credit_hold attribute value from current customer.
     *
     * @return bool
     */
    public function getCustomerAttr() : bool
    {
        $customerData = $this->backendSession->getCustomerData();
        $customerAttribute = $customerData['account'];
        if ($customerAttribute !== null) {
            $value = (bool)$customerAttribute[ConfigProvider::ATTRIBUTE_CODE_CREDIT_HOLD];
        } else {
            $value = 0;
        }

        return $value;
    }

    /**
     * Get current customer id from admin session.
     *
     * @return int
     */
    public function getCustomerId() : int
    {
        $customerData = $this->backendSession->getCustomerData();
        $customerAttribute = $customerData['account'];
        if ($customerAttribute !== null) {
            $value = $customerAttribute['id'];
        } else {
            $value = 0;
        }

        return $value;
    }

    /**
     * Set customer id to array in admin session.
     *
     * @return void
     */
    public function setCustomerIdToAdminSession() : void
    {
        $customersId = $this->getCustomersId();
        $customersId[] = $this->getCustomerId();
        $this->authSession->setData('customers_id', $customersId);
    }

    /**
     * Set customer id to admin session from save (AddIdAfterSave).
     *
     * @param $customerId
     * @return void
     */
    public function setCustomerIdToAdminSessionFromSave($customerId) : void
    {
        $customersId = $this->getCustomersId();
        $customersId[] = $customerId;
        $this->authSession->setData('customers_id', $customersId);
    }

    /**
     * Get array customers id from admin session.
     *
     * @return array
     */
    public function getCustomersId() : array
    {
        if ($this->authSession->getData('customers_id')){
            $customers = $this->authSession->getData('customers_id');
        } else {
            $customers = [];
        }

        return $customers;
    }

    /**
     * Check to be customer id in admin session array.
     *
     * @return bool
     */
    public function checkCustomerIdInArrayAdminSession() : bool
    {
        $currentCustomerId = $this->getCustomerId();
        $arrayCustomersId = $this->getCustomersId();

        if (!$arrayCustomersId) {
            $check = false;
        } else {
            $check = in_array($currentCustomerId, $arrayCustomersId);
        }

        return $check;
    }

    /**
     * Get options enabled.
     *
     * @return bool
     */
    public function isCreditHoldConfigEnabled() : bool
    {
        return $this->configProvider->isOptionCreditHoldEnable();
    }

    /**
     * Last check for once show.
     *
     * @return bool
     */
    public function lastCheck() : bool
    {
        if (
        $this->getCustomerAttr() &&
        $this->isCreditHoldConfigEnabled() &&
        !$this->checkCustomerIdInArrayAdminSession()
        ) {
            $check = true;
        } else {
            $check = false;
        }

        return $check;
    }

    /**
     * Get message and set customer id to admin session
     *
     * @return string
     */
    public function getMessageAndSetCustomerIdToAdminSession() : string
    {
        $this->setCustomerIdToAdminSession();

        return $this->configProvider->getMessage();
    }
}
