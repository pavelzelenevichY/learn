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
use Codifi\Training\Model\ResourceModel\CustomerNote as CustomerNoteResource;

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
     * Customer note resource model.
     *
     * @var CustomerNoteResource
     */
    private $customerNoteResource;

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param CustomerNote $customerNote
     * @param CustomerNoteResource $customerNoteResource
     */
    public function __construct(
        Context $context,
        CustomerNote $customerNote,
        CustomerNoteResource $customerNoteResource
    ) {
        parent::__construct($context);
        $this->customerNote = $customerNote;
        $this->customerNoteResource = $customerNoteResource;
    }

    /**
     * Execute
     *
     * @return ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();

        $customerNoteModel = $this->customerNote;
        $customerNoteModel->setData($data);

        try {
            $this->customerNoteResource->save($customerNoteModel);
            $this->messageManager->addSuccessMessage('');
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Note text is missed.'));
        }
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setPath('/');

        return $redirect;
    }
}
