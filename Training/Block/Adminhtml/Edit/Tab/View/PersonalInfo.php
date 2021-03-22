<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

namespace Codifi\Training\Block\Adminhtml\Edit\Tab\View;

use Codifi\Training\Block\Account\Dashboard\CreditHold;
use Codifi\Training\Setup\Patch\Data\AddCustomerAttributeCreditHold;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Model\Auth\Session;

/**
 * Class PersonalInfo
 * @package Codifi\Training\Block\Adminhtml\Edit\Tab\View
 */
class PersonalInfo extends Template
{
    /**
     * Customer
     *
     * @var \Magento\Customer\Api\Data\CustomerInterface
     */
    protected $customer;

    /**
     * Customer data factory
     *
     * @var \Magento\Customer\Api\Data\CustomerInterfaceFactory
     */
    protected $customerDataFactory;

    /**
     * Credit hold
     *
     * @var CreditHold
     */
    public $credithold;

    /**
     * Admin session.
     *
     * @var Session
     */
    protected $authSession;

    /**
     * Customers id.
     */
    public $customersId;

    /**
     * PersonalInfo constructor.
     * @param Context $context
     * @param CreditHold $creditHold
     * @param Session $authSession
     * @param array $data
     */
    public function __construct(
        Context $context,
        CreditHold $creditHold,
        Session $authSession,
        array $data = []
    ) {
        $this->credithold = $creditHold;
        $this->authSession = $authSession;
        parent::__construct($context, $data);
    }

    /**
     * Get options enabled.
     *
     * @return bool
     */
    public function isCreditHoldConfigEnabled() : bool
    {
        return $this->credithold->isCreditHoldConfigEnabled();
    }

    /**
     * Get credit_hold attribute value
     *
     * @return bool
     */
    public function getCustomerAttr() : bool
    {
        $customerData = $this->_backendSession->getCustomerData();
        $customerAttribute = $customerData['account'];
        if ($customerAttribute !== null) {
            $value = (bool)$customerAttribute[AddCustomerAttributeCreditHold::ATTRIBUTE_CODE];
        } else {
            $value = 0;
        }

        return $value;
    }

    /**
     * Get current customer id.
     *
     * @return int
     */
    public function getCustomerId() : int
    {
        $customerData = $this->_backendSession->getCustomerData();
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
     */
    public function setCustomerIdToAdminSession() : void
    {
        $customersId = $this->getCustomersId();
        $customersId[] = $this->getCustomerId();
        $this->authSession->setData('customers_id', $customersId);
    }

    /**
     * Check for once show
     *
     * @return bool
     */
    public function checkId() : bool
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
     * Get customers id from admin session.
     */
    public function getCustomersId()
    {
        if ($this->authSession->getData('customers_id')){
            $customers = $this->authSession->getData('customers_id');
        } else {
            $customers = [];
        }

        return $customers;
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage() : string
    {
        return $this->credithold->getMessage();
    }
}
