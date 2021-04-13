<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

namespace Codifi\Training\Api;

/**
 * Interface CreditHoldAttributeManagementInterface
 * @package Codifi\Training\Api
 */
interface CreditHoldAttributeManagementInterface
{
    /**
     * Update attribute
     *
     * @param int $customerId
     * @param int $credit_hold
     * @return AttributeManagementResponseInterface
     */
    public function updateAttribute(int $customerId, int $credit_hold): AttributeManagementResponseInterface;
}
