<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

declare(strict_types=1);

namespace Codifi\Training\Model\Api;

use Magento\Framework\Webapi\Rest\Request;
use Codifi\Training\Api\UpdateCustomerAttributeCreditHoldInterface;
use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\CustomerFactory;
use Exception;
use Codifi\Training\Model\NoteRepository;
use Codifi\Training\Model\CustomerNote;
use Codifi\Training\Model\Api\GetResponse;
use \Psr\Log\LoggerInterface;

/**
 * Class UpdateCustomerAttributeCreditHold
 * @package Codifi\Training\Model\Api
 */
class UpdateCustomerAttributeCreditHold implements UpdateCustomerAttributeCreditHoldInterface
{
    /**
     * Request
     *
     * @var Request
     */
    private $request;

    /**
     * Customer repository
     *
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * Customer model
     *
     * @var Customer
     */
    protected $customer;

    /**
     * Customer factory
     *
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var NoteRepository
     */
    private $noteRepository;

    /**
     * @var CustomerNote
     */
    private $note;

    /**
     * @var GetResponse
     */
    private $getResponse;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * UpdateCustomerAttributeCreditHold constructor.
     *
     * @param Request $request
     * @param CustomerRepository $customerRepository
     * @param Customer $customer
     * @param CustomerFactory $customerFactory
     * @param NoteRepository $noteRepository
     * @param CustomerNote $note
     * @param \Codifi\Training\Model\Api\GetResponse $getResponse
     * @param LoggerInterface $logger
     */
    public function __construct(
        Request $request,
        CustomerRepository $customerRepository,
        Customer $customer,
        CustomerFactory $customerFactory,
        NoteRepository $noteRepository,
        CustomerNote $note,
        GetResponse $getResponse,
        LoggerInterface $logger
    ) {
        $this->request = $request;
        $this->customerRepository = $customerRepository;
        $this->customer = $customer;
        $this->customerFactory = $customerFactory;
        $this->noteRepository = $noteRepository;
        $this->note = $note;
        $this->getResponse = $getResponse;
        $this->logger = $logger;
    }

    /**
     * Get post api
     *
     * @return array|false|string
     */
    public function getPost()
    {
        $pattern = '/^[\d]+$/';
        $params = $this->request->getRequestData();
        $customerId = $params['customerId'];
        $creditHoldValue = $params['credit_hold'];

        if (preg_match($pattern, $customerId) && $customerId >= 1) {
            if ($creditHoldValue === "1" || $creditHoldValue === "0") {
                try {
                    $customer = $this->customerRepository->getById($customerId);
                    $customer->setCustomAttribute('credit_hold', $creditHoldValue);
                    $this->customerRepository->save($customer);
                    $data = [
                        'note' => 'Credit hold status has been updated via API request.',
                        'customer_id' => $customerId,
                        'autocomplete' => 1
                    ];
                    $note = $this->note->setData($data);
                    $this->noteRepository->save($note);
                    $message = '';
                } catch (Exception $e) {
                    $message = $e->getMessage();
                    $this->logger->info($message);
                }
            } else {
                $message = 'Value of credithold attribute most be 0 or 1!';
                $this->logger->info($message);
            }
        } else {
            $message = 'Incorrect customer id type!';
            $this->logger->info($message);
        }

        return $this->getResponse->response($message);
    }
}
