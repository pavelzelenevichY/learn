<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

namespace Codifi\Training\Api;

/**
 * Interface GetResponseInterface
 * @package Codifi\Training\Api
 */
interface GetResponseInterface
{
    /**
     * Get status
     *
     * @param string $message
     * @return string
     */
    public function getStatus($message);

    /**
     * Get response
     *
     * @param $message
     * @return array
     */
    public function getResponse($message);

}
