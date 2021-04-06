<?php


namespace Codifi\Training\Controller\Adminhtml\Note;

use Codifi\Training\Model\AdminSessionManagement;
use Codifi\Training\Model\CustomerNoteFactory;
use Codifi\Training\Model\ResourceModel\CustomerNote as CustomerNoteResource;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

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

    public function __construct(
        Context $context,
        CustomerNoteFactory $customerNoteFactory,
        CustomerNoteResource $customerNoteResource,
        AdminSessionManagement $adminSessionManagement
    ) {
        $this->customerNoteFactory = $customerNoteFactory;
        $this->customerNoteResource = $customerNoteResource;
        $this->adminSessionManagement = $adminSessionManagement;
        parent::__construct($context);
    }

    public function execute()
    {
        $adminId = $this->adminSessionManagement->getAdminId();
        $noteId = $this->getRequest()->getParam('note_id');
        $noteText = $this->getRequest()->getParam('note');
        $createdBy = $this->getRequest()->getParam('created_by');
        $updatedBy = $this->getRequest()->getParam('updated_by');

        $response = [];
        return $response;
    }
}
