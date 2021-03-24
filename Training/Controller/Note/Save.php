<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

namespace Codifi\Training\Controller\Note;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Codifi\Training\Model\CustomerNote;
use Codifi\Training\Model\CustomerNoteFactory;
use Codifi\Training\Model\ResourceModel\CustomerNote as CustomerNoteResource;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Save
 * @package Codifi\Training\Controller\Note
 */
class Save extends Action
{
    /**
     * Customer note model.
     *
     * @var CustomerNote
     */
    private $customerNote;

    /**
     * Customer note factory
     *
     * @var CustomerNoteFactory
     */
    private $customerNoteFactory;

    /**
     * Customer note resource model.
     *
     * @var CustomerNoteResource
     */
    private $customerNoteResource;

    /**
     * Json factory
     *
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param CustomerNote $customerNote
     * @param CustomerNoteResource $customerNoteResource
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        CustomerNoteFactory $customerNoteFactory,
        CustomerNote $customerNote,
        CustomerNoteResource $customerNoteResource
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->customerNoteFactory = $customerNoteFactory;
        $this->customerNote = $customerNote;
        $this->customerNoteResource = $customerNoteResource;
    }

    /**
     * Execute
     *
     * @return ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface|string
     */
    public function execute()
    {
        $data = $this->getRequest()->getParam('note');

        $customerNoteModelFactory = $this->customerNoteFactory->create();
        $resultJson = $this->jsonFactory->create();

        if (!$data) {
            $response =  $resultJson->setData([
                'success' => false,
                'message' => 'Note text is missed.'
            ]);
        } else {
            $customerNoteModelFactory->setData($data);
            $response =  $resultJson->setData([
                'success' => true,
                'message' => ''
            ]);
        }

        try {
            $customerNoteModelFactory->save($data);
        } catch (LocalizedException $exception) {
            $response = $exception->getMessage();
        }

        return $response;
    }
}
