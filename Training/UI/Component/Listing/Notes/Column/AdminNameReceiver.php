<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

declare(strict_types=1);

namespace Codifi\Training\UI\Component\Listing\Notes\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\User\Model\ResourceModel\User\CollectionFactory;

/**
 * Class AdminNameReceiver
 * @package Codifi\Training\UI\Component\Listing\Notes\Column
 */
class AdminNameReceiver extends Column
{
    /**
     * Admin collection factory
     *
     * @var CollectionFactory
     */
    public $userCollectionFactory;

    /**
     * AdminNameReceiver constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param CollectionFactory $userCollectionFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        CollectionFactory $userCollectionFactory,
        array $components = [],
        array $data = []
    ) {
        $this->userCollectionFactory = $userCollectionFactory;
        parent::__construct(
            $context,
            $uiComponentFactory,
            $components,
            $data
        );
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                if ($item[$fieldName] != '') {
                    $item[$fieldName] = $this->getAdminName($item[$fieldName]);
                }
            }
        }

        return $dataSource;
    }

    /**
     * Get admin name by id.
     *
     * @param $userId
     * @return string
     */
    private function getAdminName($userId): string
    {
        $name = '';
        $users = $this->userCollectionFactory->create();
        $array = $users->getData();
        foreach ($array as $item) {
            if ($item['user_id'] === $userId) {
                $name = $item['firstname'] . ' ' . $item['lastname'] . ' (ID: ' . $item['user_id'] . ')';
            }
        }

        return $name;
    }
}
