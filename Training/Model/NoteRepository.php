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
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\AlreadyExistsException;

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
     * NoteRepository constructor.
     *
     * @param NoteInterface $note
     * @param CustomerNoteFactory $noteFactory
     * @param CustomerNoteResourse $noteResourse
     */
    public function __construct(
        NoteInterface $note,
        CustomerNoteFactory $noteFactory,
        CustomerNoteResourse $noteResourse
    ) {
        $this->note = $note;
        $this->noteFactory = $noteFactory;
        $this->noteResourse = $noteResourse;
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
}
