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
use Exception;

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
     * @return NoteInterface|string
     */
    public function save(NoteInterface $note)
    {

        try {
            $this->noteResourse->save($note);
            $response = $note;
        } catch (Exception $exception) {
            $response = $exception->getMessage();
        }

        return $response;
    }

    /**
     * Delete note.
     *
     * @param NoteInterface $note
     * @return NoteInterface|string
     * @throws Exception
     */
    public function delete(NoteInterface $note)
    {
        try {
            $this->noteResourse->delete($note);
            $response = $note;
        } catch (Exception $exception) {
            $response = $exception->getMessage();
        }

        return $response;
    }

    /**
     * Delete note by id.
     *
     * @param int $noteId
     * @throws NoSuchEntityException
     */
    public function deleteById($noteId): void
    {
        $this->delete($this->getById($noteId));
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
