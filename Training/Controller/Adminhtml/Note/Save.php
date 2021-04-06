<?php


namespace Codifi\Training\Controller\Adminhtml\Note;

use Codifi\Training\Model\AdminSessionManagement;
use Codifi\Training\Model\CustomerNoteFactory;
use Codifi\Training\Model\ResourceModel\CustomerNote as CustomerNoteResource;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Codifi\Training\Model\NoteRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Controller\ResultFactory;

class Save extends Action
{
    /**
     * Customer note factory.
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
     * Admin session management
     *
     * @var AdminSessionManagement
     */
    private $adminSessionManagement;

    /**
     * Note repository
     *
     * @var NoteRepository
     */
    private $noteRepository;

    /**
     * Json factory.
     *
     * @var JsonFactory
     */
    private $jsonFactory;

    public function __construct(
        Context $context,
        CustomerNoteFactory $customerNoteFactory,
        CustomerNoteResource $customerNoteResource,
        AdminSessionManagement $adminSessionManagement,
        NoteRepository $noteRepository,
        JsonFactory $jsonFactory
    ) {
        $this->customerNoteFactory = $customerNoteFactory;
        $this->customerNoteResource = $customerNoteResource;
        $this->adminSessionManagement = $adminSessionManagement;
        $this->noteRepository = $noteRepository;
        $this->jsonFactory = $jsonFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws AlreadyExistsException
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function execute()
    {

        $customerNoteModel = $this->customerNoteFactory->create();
        $resultJson = $this->jsonFactory->create();

        $ids = $this->adminSessionManagement->getAdminId();

        $adminId = $ids['admin_id'];
        $customerId = $ids['customer_id'];

        $noteId = $this->getRequest()->getParam('note_id');

        $noteText = $this->getRequest()->getParam('note');

        $createdAt = $this->getRequest()->getParam('created_at');

        $createdBy = $this->getRequest()->getParam('created_by');

        if ($noteText) {
            if (!$noteId) {
                $data = [
                    'customer_id' => $customerId,
                    'note' => $noteText,
                    'created_by' => $adminId,
                    'updated_by' => $adminId,
                    'autocomplete' => 0
                ];
                $resultData = [
                    'success' => true,
                    'message' => __(''),
                    'data' => [
                        'note_id' => $noteId
                    ]
                ];
            } else {
                $data = [
                    'note_id' => $noteId,
                    'customer_id' => $customerId,
                    'note' => $noteText,
                    'created_at' => $createdAt,
                    'created_by' => $createdBy,
                    'updated_by' => $adminId,
                    'autocomplete' => 0
                ];
                $resultData = [
                    'success' => true,
                    'message' => __(''),
                    'data' => [
                        'note_id' => $noteId
                    ]
                ];
            }

            try {
                $customerNoteModel->setData($data);
                $this->customerNoteResource->save($customerNoteModel);
            } catch (LocalizedException $exception) {
                $resultData = [
                    'success' => false,
                    'message' => $exception->getMessage()
                ];
                throw $exception;
            }
        } else {
            $resultData = [
                'success' => false,
                'message' => __('Note text is missed.'),
                'data' => [
                    'note_id' => $noteId
                ]
            ];
        }

        $resultJson->setData($resultData);
////
//        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_JSON);
//        $resultRedirect->setHeader('sad', 'asd',);
//        $resultRedirect->setHttpResponseCode(1);
//        $resultRedirect->renderResult($response);
////        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
//        return $resultRedirect;

//        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_JSON);
//
//        // Your code
//
//        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
//        return $resultRedirect;
        return $resultJson;
    }
}
