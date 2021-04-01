<?php


namespace Codifi\Training\UI\Config;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Codifi\Training\Model\ResourceModel\CustomerNote\Collection;
use Codifi\Training\Model\ResourceModel\CustomerNote\CollectionFactory;


class CustomDataProvider extends AbstractDataProvider
{
    /**
     * @var CollectionFactory
     */
    public $collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
    }

//    /**
//     * Get collection
//     *
//     * @return Collection
//     */
//    public function getCollection()
//    {
//        return $this->collectionFactory->create();
//    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return [];
    }
}
