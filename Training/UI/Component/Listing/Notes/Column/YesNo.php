<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

declare(strict_types=1);

namespace Codifi\Training\UI\Component\Listing\Notes\Column;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class YesNo
 * @package Codifi\Training\UI\Component\Listing\Notes\Column
 */
class YesNo implements OptionSourceInterface
{
    /**
     * Get option yes/no.
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['label' => __('Yes'), 'value' => 1],
            ['label' => __('No'), 'value' => 0]
        ];
    }
}
