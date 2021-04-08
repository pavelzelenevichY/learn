<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

namespace Codifi\Training\Model;

use Magento\Framework\Model\AbstractModel;
use Codifi\Training\Model\ResourceModel\CustomerNote as ResourceModel;

/**
 * Class CustomerNote
 * @package Codifi\Training\Model
 */
class CustomerNote extends AbstractModel
{
    /**
     * CustomerNote constructor.
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
