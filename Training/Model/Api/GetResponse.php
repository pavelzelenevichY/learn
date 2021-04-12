<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

namespace Codifi\Training\Model\Api;

use Codifi\Training\Api\GetResponseInterface;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Class GetResponse
 * @package Codifi\Training\Model\Api
 */
class GetResponse implements GetResponseInterface
{
    /**
     * Serializer interface
     *
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * GetResponse constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Get status
     *
     * @param string $message
     * @return string
     */
    public function getStatus($message)
    {
        if ($message === '') {
            $status = 'OK';
        } else {
            $status = 'Failed';
        }
        return $status;
    }

    /**
     * Get response
     *
     * @param $message
     * @return array|bool|string
     */
    public function getResponse($message)
    {
        $data = [
            'status' => $this->getStatus($message),
            'message' => $message
        ];

        return $this->serializer->serialize($data);
    }
}
