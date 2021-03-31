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
 * Class CreatorAdminName
 * @package Codifi\Training\UI\Component\Listing\Notes\Column
 */
class CreatorAdminName extends Column
{
    /**
     * Admin collection factory
     *
     * @var CollectionFactory
     */
    public $userCollection;

    /**
     * CreatorAdminName constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     * @param CollectionFactory $userCollection
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = [],
        CollectionFactory $userCollection
    ) {
        parent::__construct(
            $context,
            $uiComponentFactory,
            $components,
            $data
        );
        $this->userCollection = $userCollection;
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
                    $adminName = $this->getAdminName($item[$fieldName]);
                    $item[$fieldName] = $adminName.'(ID:'.$item[$fieldName].')';
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
        $users = $this->userCollection->create();
        $array = $users->getData();
        foreach ($array as $item) {
            if ($item['user_id'] === $userId) {
                $name = $item['username'];
            }
        }

        return $name;
    }
}
