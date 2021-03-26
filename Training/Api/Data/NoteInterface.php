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
    public function getNoteText();

    /**
     * @param string $noteText
     * @return void
     */
    public function setNoteText($noteText);

    /**
     * @return int
     */
    public function getAutocomplete();

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @return string
     */
    public function getUpdatedBy();
}
