<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

declare(strict_types=1);

namespace Codifi\Training\UI\Component\Listing;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Codifi\Training\Model\AdminSessionManagement;
use Codifi\Training\Model\NoteRepository;
use Magento\Backend\Model\Session as BackendSession;
use Magento\Backend\Model\Auth\Session;

/**
 * Class CustomDataProvider
 * @package Codifi\Training\UI\Component\Listing
 */
class CustomDataProvider extends DataProvider
{
    /**
     * @var AdminSessionManagement
     */
    public $adminSession;

    /**
     * @var BackendSession
     */
    public $backendSession;

    /**
     * @var Session
     */
    public $authSession;

    /**
     * @var NoteRepository
     */
    public $noteRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    public $searchCriteriaBuilder;

    public function _construct(
//        AdminSessionManagement $adminSession,
        NoteRepository $noteRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        BackendSession $backendSession,
        Session $authSession
    ) {
//        $this->adminSession = $adminSession;
        $this->noteRepository = $noteRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->backendSession = $backendSession;
        $this->authSession = $authSession;
    }

    /**
     * Get current customer id from admin session.
     *
     * @return int
     */
    public function getCustomerId() : int
    {
        die($this->authSession->getSessionId());
        $customerData = $this->backendSession->getCustomerData();

        return (int)$customerData['account']['id'] ?? 0;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $customerId = $this->getCustomerId();
        $searchCriteria = $this->searchCriteriaBuilder->addFilter('customer_id', $customerId)->create();
//        die(var_dump($this->noteRepository->getList($searchCriteria)->getItems()));
        return $this->noteRepository->getList($searchCriteria)->getItems();
    }
}
