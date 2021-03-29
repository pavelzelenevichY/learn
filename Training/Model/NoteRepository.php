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
use Codifi\Training\Model\CustomerNote;
use Codifi\Training\Model\CustomerNoteFactory;
use Codifi\Training\Model\ResourceModel\CustomerNote as CustomerNoteResourse;
use Codifi\Training\Api\Data\NoteSearchResultInterfaceFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Api\SearchCriteriaInterface;
use Codifi\Training\Api\Data\NoteSearchResultInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

/**
 * Class NoteRepository
 * @package Codifi\Training\Model
 */
class NoteRepository implements NoteRepositoryInterface
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
     * @var NoteSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * NoteRepository constructor.
     *
     * @param NoteInterface $note
     * @param CustomerNoteFactory $noteFactory
     * @param CustomerNoteResourse $noteResourse
     * @param NoteSearchResultInterfaceFactory $searchResultFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        NoteInterface $note,
        CustomerNoteFactory $noteFactory,
        CustomerNoteResourse $noteResourse,
        NoteSearchResultInterfaceFactory $searchResultFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->note = $note;
        $this->noteFactory = $noteFactory;
        $this->noteResourse = $noteResourse;
        $this->searchResultFactory = $searchResultFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Get note by id.
     *
     * @param int $id
     * @return CustomerNote
     * @throws NoSuchEntityException
     */
    public function getById($id): CustomerNote
    {
        $noteModel = $this->noteFactory->create();
        $this->noteResourse->load($noteModel, $id);
        if (!$noteModel->getId()) {
            throw new NoSuchEntityException(__('Unable to find note with ID "%1"', $id));
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
     * @return void
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
     * @return void
     */
    public function deleteById($noteId): void
    {
        $noteModel = $this->noteFactory->create();
        $note = $this->noteResourse->load($noteModel, $noteId);
        if (!$noteModel->getId()) {
            throw new NoSuchEntityException(__('Unable to find note with ID "%1"', $noteId));
        }
        $this->noteResourse->delete($note);
        $this->noteResourse->save($noteModel);
    }

    /**
     * Get list.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return NoteSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): NoteSearchResultInterface
    {
        $searchResult = $this->searchResultFactory->create();
        $this->collectionProcessor->process($searchCriteria, $searchResult);
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }
}
