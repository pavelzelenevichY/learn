<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

namespace Codifi\Training\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface NoteSearchResultInterface
 * @package Codifi\Training\Api\Data
 */
interface NoteSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Codifi\Training\Api\Data\NoteInterface[]
     */
    public function getItems();

    /**
     * @param \Codifi\Training\Api\Data\NoteInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
