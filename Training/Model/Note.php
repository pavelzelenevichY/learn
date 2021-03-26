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
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Tests\NamingConvention\true\string;

/**
 * Class Note
 * @package Codifi\Training\Model
 */
class Note extends AbstractExtensibleModel implements NoteInterface
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
     * Note construct.
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\CustomerNote::class);
    }

    /**
     * Get note id.
     *
     * @return int
     */
    public function getNoteId() : int
    {
        return $this->_getData(self::NOTE_ID);
    }

    /**
     * Set note id.
     *
     * @param int $noteId
     * @return void
     */
    public function setNoteId($noteId) : void
    {
        $this->setData([self::NOTE_ID => $noteId]);
    }

    /**
     * Get note.
     *
     * @return string
     */
    public function getNoteText() : string
    {
        return $this->_getData(self::NOTE);
    }

    /**
     * Set note.
     *
     * @param string $noteText
     * @return void
     */
    public function setNoteText($noteText) : void
    {
        $this->setData([self::NOTE => $noteText]);
    }

    /**
     * Get autocomplete value.
     *
     * @return int
     */
    public function getAutocomplete() : int
    {
        return $this->_getData(self::AUTOCOMPLETE);
    }

    /**
     * Get customer id.
     *
     * @return int
     */
    public function getCustomerId() : int
    {
        return $this->_getData(self::CUSTOMER_ID);
    }

    /**
     * Get created at.
     *
     * @return string
     */
    public function getCreatedAt() : string
    {
        return $this->_getData(self::CREATED_AT);
    }

    /**
     * Get created by.
     *
     * @return string
     */
    public function getCreatedBy() : string
    {
        return $this->_getData(self::CREATED_BY);
    }

    /**
     * Get updated at.
     *
     * @return string
     */
    public function getUpdatedAt() : string
    {
        return $this->_getData(self::UPDATED_AT);
    }

    /**
     * Get updated by.
     *
     * @return string
     */
    public function getUpdatedBy() : string
    {
        return $this->_getData(self::UPDATED_BY);
    }
}


