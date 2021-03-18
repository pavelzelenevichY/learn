<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

namespace Codifi\Training\Model\Source;

/**
 * Class CustomSelect
 * @package Codifi\Training\Model\Source
 */
class CustomSelect extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @return array|array[]|null
     */
    public function getAllOptions()
    {
        if (null === $this->_options) {
            $this->_options = [
                ['label' => __('Yes'), 'value' => 1],
                ['label' => __('No'), 'value' => 0],
            ];
        }
        return $this->_options;
    }

    /**
     * @param int|string $value
     * @return bool|mixed|string
     */
    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
}
