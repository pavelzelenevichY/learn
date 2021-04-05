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
use Magento\Framework\Api\Search\SearchCriteriaBuilder as ParentSearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Codifi\Training\Model\ResourceModel\CustomerNote\CollectionFactory;
use Codifi\Training\Model\AdminSessionManagement;
use Codifi\Training\Model\NoteRepository;

/**
 * Class AccountNoteDataProvider
 * @package Codifi\Training\UI\Component\Listing
 */
class AccountNoteDataProvider extends DataProvider
{
    /**
     * Customer note collection factory
     *
     * @var CollectionFactory
     */
    protected $collectionFactory;

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
     * Search criteria builder
     *
     * @var SearchCriteriaBuilder
     */
    public $searchCriteriaBuilderChild;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        ParentSearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request, FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilderChild,
        NoteRepository $noteRepository,
        AdminSessionManagement $adminSessionManagement,
        array $meta = [],
        array $data = [])
    {
        $this->searchCriteriaBuilderChild = $searchCriteriaBuilderChild;
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
            $data);
    }

    /**
     * Get data
     */
    public function getData()
    {
        $customerId = $this->adminSessionManagement->getCustomerId();
        $searchCriteria = $this->searchCriteriaBuilderChild->addFilter('customer_id', $customerId)->create();
        $repo = $this->noteRepository->getList($searchCriteria)->getItems();
        $returnData = [
            'items' => []
        ];

        foreach ($repo as $item) {
            if ($item->getData('note_id')) {
                $returnData['items'][] = $item->getData();
            }
        }
        $returnData['totalRecords'] = count($returnData['items']);

        return $returnData;
    }
}
