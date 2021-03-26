<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

declare(strict_types=1);

namespace Codifi\Training\Model;

use Codifi\Training\Api\Data\NoteInterface;
use Codifi\Training\Api\NoteRepositoryInterface;
use Codifi\Training\Model\CustomerNoteFactory;
use Codifi\Training\Model\ResourceModel\CustomerNote as CustomerNoteResourse;
use Codifi\Training\Model\ResourceModel\CustomerNote\Collection;
use Codifi\Training\Model\ResourceModel\CustomerNote\CollectionFactory;
use Codifi\Training\Api\Data\NoteSearchResultInterfaceFactory;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;

/**
 * Class NoteRepository
 * @package Codifi\Training\Model
 */
class NoteRepository extends AbstractModel implements NoteRepositoryInterface
{
    /**
     * Note interface.
     *
     * @var NoteInterface
     */
    private $note;

    /**
     * Note factory.
     *
     * @var CustomerNoteFactory
     */
    private $noteFactory;

    /**
     * Note resourse.
     *
     * @var CustomerNoteResourse
     */
    private $noteResourse;

    /**
     * Note collection factory.
     *
     * @var CollectionFactory
     */
    private $noteCollectionFactory;

    /**
     * @var NoteSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * NoteRepository constructor.
     *
     * @param NoteInterface $note
     * @param \Codifi\Training\Model\CustomerNoteFactory $noteFactory
     * @param CustomerNoteResourse $noteResourse
     * @param CollectionFactory $noteCollectionFactory
     * @param NoteSearchResultInterfaceFactory $searchResultFactory
     */
    public function __construct(
        NoteInterface $note,
        CustomerNoteFactory $noteFactory,
        CustomerNoteResourse $noteResourse,
        CollectionFactory $noteCollectionFactory,
        NoteSearchResultInterfaceFactory $searchResultFactory
    ) {
        $this->note = $note;
        $this->noteFactory = $noteFactory;
        $this->noteResourse = $noteResourse;
        $this->noteCollectionFactory = $noteCollectionFactory;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * Get note by id.
     *
     * @param int $id
     * @return object
     * @throws NoSuchEntityException
     */
    public function getById($id): object
    {
        $noteModel = $this->noteFactory->create();
        $this->noteResourse->load($noteModel, $id);
        if (!$noteModel->getId()) {
            throw new NoSuchEntityException(__('Unable to find hamburger with ID "%1"', $id));
        }

        return $noteModel;
    }

    /**
     * Save note.
     *
     * @param NoteInterface $note
     * @throws AlreadyExistsException
     */
    public function save(NoteInterface $note): void
    {
        $noteModel = $this->noteFactory->create();
        $noteModel->setData($note);
        $this->noteResourse->save($noteModel);
    }

    /**
     * Delete note.
     *
     * @param NoteInterface $note
     * @throws AlreadyExistsException
     */
    public function delete(NoteInterface $note): void
    {
        $noteModel = $this->noteFactory->create();
        $this->noteResourse->delete($note);
        $this->noteResourse->save($noteModel);
    }

    /**
     * Delete note by id.
     *
     * @param int $noteId
     * @throws NoSuchEntityException
     */
    public function deleteById($noteId) : void
    {
        $noteModel = $this->noteFactory->create();
        $note = $this->noteResourse->load($noteModel, $noteId);
        if (!$noteModel->getId()) {
            throw new NoSuchEntityException(__('Unable to find hamburger with ID "%1"', $noteId));
        }
        $this->noteResourse->delete($note);
        $this->noteResourse->save($noteModel);
    }

    /**
     * Get list.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->noteCollectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * Add filters to collection.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * Add sort orders to collection.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * Add paging to collection.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * Build search result.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return mixed
     */
    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
