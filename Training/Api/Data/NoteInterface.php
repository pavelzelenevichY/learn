<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

namespace Codifi\Training\Api\Data;

/**
 * Interface NoteInterface
 * @package Codifi\Training\Api\Data
 */
interface NoteInterface
{
    /**
     * @return int
     */
    public function getNoteId();

    /**
     * @param int $noteId
     * @return void
     */
    public function setNoteId($noteId);

    /**
     * @return string
     */
    public function getNote();

    /**
     * @param string $noteText
     * @return void
     */
    public function setNote($noteText);

    /**
     * @return int
     */
    public function getAutocomplete();
}
