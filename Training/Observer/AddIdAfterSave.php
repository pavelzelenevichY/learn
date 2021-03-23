<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

namespace Codifi\Training\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Codifi\Training\Model\AdminSession;
use Magento\Framework\View\Element\Context;

/**
 * Class AddIdAfterSave
 * @package Codifi\Training\Observer
 */
class AddIdAfterSave implements ObserverInterface
{
    /**
     * Admin session
     *
     * @var AdminSession
     */
    public $adminSession;

    /**
     * AddIdAfterSave constructor.
     *
     * @param Context $context
     * @param AdminSession $adminSession
     */
    public function __construct(
        Context $context,
        AdminSession $adminSession
    ) {
        $this->_layout = $context->getLayout();
        $this->adminSession = $adminSession;
    }

    /**
     * Execute function
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(EventObserver $observer) : void
    {
        $event = $observer->getEvent();
        $customer = $event->getCustomer();
        $id = (int)$customer->getId();
        $this->adminSession->setCustomerIdToAdminSessionFromSave($id);
    }
}
