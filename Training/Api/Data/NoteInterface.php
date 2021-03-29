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
     * Note id.
     */
    const NOTE_ID = 'note_id';

    /**
     * Customer id.
     */
    const CUSTOMER_ID = 'customer_id';

    /**
     * Created at.
     */
    const CREATED_AT = 'created_at';

    /**
     * Created by.
     */
    const CREATED_BY = 'created_by';

    /**
     * Note text.
     */
    const NOTE = 'note';

    /**
     * Updated at.
     */
    const UPDATED_AT = 'updated_at';

    /**
     * Updated by.
     */
    const UPDATED_BY = 'updated_by';

    /**
     * Autocomplete.
     */
    const AUTOCOMPLETE = 'autocomplete';

    /**
     * Get note id.
     *
     * @return int
     */
    public function getNoteId();

    /**
     * Set note id.
     *
     * @param int $noteId
     * @return void
     */
    public function setNoteId(int $noteId);

    /**
     * Get note text.
     *
     * @return string
     */
    public function getNoteText();

    /**
     * Set note text.
     *
     * @param string $noteText
     * @return void
     */
    public function setNoteText(string $noteText);

    /**
     * Get autocomplete value.
     *
     * @return int
     */
    public function getAutocomplete();

    /**
     * Set autocomplete
     *
     * @param $autocomplete
     * @return void
     */
    public function setAutocomplete(int $autocomplete);

    /**
     * Get customer id.
     *
     * @return int
     */
    public function getCustomerId();

    /**
     * Set customer id.
     *
     * @param $customerId
     * @return void
     */
    public function setCustomerId(int $customerId);

    /**
     * Get created at.
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set created at.
     *
     * @param string $createdAt
     * @return void
     */
    public function setCreatedAt(string $createdAt);

    /**
     * Get created by.
     *
     * @return string
     */
    public function getCreatedBy();

    /**
     * Set created by.
     *
     * @param string $createdBy
     * @return void
     */
    public function setCreatedBy(string $createdBy);

    /**
     * Get updated at.
     *
     * @return string
     */
    public function getUpdatedAt();

    /**
     * Set updated at.
     *
     * @param string $updatedAt
     * @return void
     */
    public function setUpdatedAt(string $updatedAt);

    /**
     * Get updated by.
     *
     * @return string
     */
    public function getUpdatedBy();

    /**
     * Set updated by.
     *
     * @param string $updatedBy
     * @return void
     */
    public function setUpdatedBy(string $updatedBy);
}
