<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

namespace Codifi\Training\Controller\Adminhtml\Note;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Controller\Result\Json;
use Codifi\Training\Model\NoteRepository;
use Codifi\Training\Model\CustomerNote;
use Magento\Backend\Model\Auth\Session;
use Magento\Backend\Model\Session as BackendSession;
use Exception;

class Save extends Action
{
    /**
     * Json factory
     *
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @var NoteRepository
     */
    private $noteRepository;

    /**
     * @var CustomerNote
     */
    private $note;

    /**
     * Auth session.
     *
     * @var Session
     */
    private $authSession;

    /**
     * Backend session.
     *
     * @var BackendSession
     */
    private $backendSession;

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param CustomerNote $note
     * @param NoteRepository $noteRepository
     * @param JsonFactory $jsonFactory
     * @param Session $authSession
     * @param BackendSession $backendSession
     */
    public function __construct(
        Context $context,
        CustomerNote $note,
        NoteRepository $noteRepository,
        JsonFactory $jsonFactory,
        Session $authSession,
        BackendSession $backendSession
    ) {
        $this->note = $note;
        $this->noteRepository = $noteRepository;
        $this->jsonFactory = $jsonFactory;
        $this->authSession = $authSession;
        $this->backendSession = $backendSession;
        parent::__construct($context);
    }

    /**
     * Execute function
     *
     * @return Json
     * @throws Exception
     */
    public function execute(): Json
    {
        $request = $this->getRequest();

        $admin = $this->authSession->getUser();
        $adminId = $admin->getId();
        $customerData = $this->backendSession->getCustomerData();
        $customerId = (int)$customerData['account']['id'] ?? 0;

        $success = false;
        if ($request->getParam('note')) {
            $noteText = $request->getParam('note');
            try {
                if ($request->getParam('note_id')) {
                    $id = $request->getParam('note_id');
                    $note = $this->noteRepository->getById($id);
                    $note->setNote($noteText);
                    $note->setUpdatedBy($adminId);
                    $message = __('Note has been successfully updated!');
                } else {
                    $data = [
                        'note' => $noteText,
                        'customer_id' => $customerId,
                        'created_by' => $adminId,
                        'updated_by' => $adminId
                    ];
                    $note = $this->note->setData($data);
                    $message = __('Note has been successfully saved!');
                }
                $this->noteRepository->save($note);
                $success = true;
            } catch (LocalizedException $exception) {
                $message = $exception->getMessage();
            }
        } else {
            $message = __('Note text is missed.');
        }

        $resultJson = $this->jsonFactory->create();
        $resultJson->setData([
            'success' => $success,
            'message' => $message
        ]);

        return $resultJson;
    }
}
