<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

namespace Codifi\Training\Api;

use Codifi\Training\Api\Data\NoteInterface;

/**
 * Interface NoteRepositoryInterface
 * @package Codifi\Training\Api
 */
interface NoteRepositoryInterface
{
    /**
     * @param int $noteId
     * @return NoteInterface
     */
    public function getById($noteId);

    /**
     * @param NoteInterface $note
     * @return NoteInterface
     */
    public function save(NoteInterface $note);

    /**
     * @param NoteInterface $note
     * @return void
     */
    public function delete(NoteInterface $note);
}
