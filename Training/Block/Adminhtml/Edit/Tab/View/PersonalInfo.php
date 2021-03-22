<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

declare(strict_types=1);

namespace Codifi\Training\Block\Adminhtml\Edit\Tab\View;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Codifi\Training\Model\AdminSession;
use Codifi\Training\Model\ConfigProvider;

/**
 * Class PersonalInfo
 * @package Codifi\Training\Block\Adminhtml\Edit\Tab\View
 */
class PersonalInfo extends Template
{
    /**
     * Admin session
     *
     * @var AdminSession
     */
    public $adminSession;

    /**
     * Config provider
     *
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * PersonalInfo constructor.
     * @param Context $context
     * @param AdminSession $adminSession
     * @param ConfigProvider $configProvider
     * @param array $data
     */
    public function __construct(
        Context $context,
        AdminSession $adminSession,
        ConfigProvider $configProvider,
        array $data = []
    ) {
        $this->adminSession = $adminSession;
        $this->configProvider = $configProvider;
        parent::__construct($context, $data);
    }

    /**
     * Set customer id to array in admin session.
     *
     * @return void
     */
    public function setCustomerIdToAdminSession() : void
    {
        $this->adminSession->setCustomerIdToAdminSession();
    }

    /**
     * Check parameters
     *
     * @return bool
     */
    public function check() : bool
    {
        return $this->adminSession->lastCheck();
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage() : string
    {
        $message = $this->configProvider->getMessage();

        return $this->escapeHtml($message);
    }
}
