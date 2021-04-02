<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

namespace Codifi\Training\UI\Config;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Codifi\Training\Model\ResourceModel\CustomerNote\CollectionFactory;

/**
 * Class CustomDataProvider
 * @package Codifi\Training\UI\Config
 */
class CustomDataProvider extends AbstractDataProvider
{
    /**
     * Collection factory
     *
     * @var CollectionFactory
     */
    public $collectionFactory;

    /**
     * Loaded data
     *
     * @var array
     */
    protected $loadedData;

    /**
     * CustomDataProvider constructor.
     *
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if ($this->loadedData === null) {
            $this->loadedData = [];
            $items = $this->collection->getItems();

            foreach ($items as $item) {
                $this->loadedData[$item->getId()] = $item->getData();
            }
        }

        return $this->loadedData;
    }
}
