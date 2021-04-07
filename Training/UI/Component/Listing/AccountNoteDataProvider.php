<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

declare(strict_types=1);

namespace Codifi\Training\UI\Component\Listing;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Codifi\Training\Model\AdminSessionManagement;
use Codifi\Training\Model\NoteRepository;

/**
 * Class AccountNoteDataProvider
 * @package Codifi\Training\UI\Component\Listing
 */
class AccountNoteDataProvider extends DataProvider
{
    /**
     * Admin session management
     *
     * @var AdminSessionManagement
     */
    private $adminSessionManagement;

    /**
     * Note repository
     *
     * @var NoteRepository
     */
    private $noteRepository;

    /**
     * AccountNoteDataProvider constructor.
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ReportingInterface $reporting
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     * @param NoteRepository $noteRepository
     * @param AdminSessionManagement $adminSessionManagement
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        NoteRepository $noteRepository,
        AdminSessionManagement $adminSessionManagement,
        array $meta = [],
        array $data = []
    ) {
        $this->noteRepository = $noteRepository;
        $this->adminSessionManagement = $adminSessionManagement;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        $customerId = $this->adminSessionManagement->getCustomerId();

        $filterSetField = $this->filterBuilder->setField('customer_id');
        $filterSetValue = $filterSetField->setValue($customerId);
        $filter = $filterSetValue->create();

        $searchCriteriaAddFilter = $this->searchCriteriaBuilder->addFilter($filter);
        $searchCriteria = $searchCriteriaAddFilter->create();

        $list = $this->noteRepository->getList($searchCriteria);
        $items = $list->getItems();

        $returnData['items'] = [];

        foreach ($items as $item) {
            $returnData['items'][] = $item->getData();
        }
        $returnData['totalRecords'] = count($returnData['items']);

        return $returnData;
    }
}
