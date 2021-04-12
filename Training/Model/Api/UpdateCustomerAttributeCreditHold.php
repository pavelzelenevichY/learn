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
use Codifi\Training\Model\Note\NoteSave;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\CustomerFactory;
use Laminas\Log\Writer\Stream;
use Laminas\Log\Logger;
use Exception;

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
     * Note save
     *
     * @var NoteSave
     */
    private $noteSave;

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
     * UpdateCustomerAttributeCreditHold constructor.
     *
     * @param Request $request
     * @param CustomerRepository $customerRepository
     * @param NoteSave $noteSave
     * @param Customer $customer
     * @param CustomerFactory $customerFactory
     */
    public function __construct(
        Request $request,
        CustomerRepository $customerRepository,
        NoteSave $noteSave,
        Customer $customer,
        CustomerFactory $customerFactory
    ) {
        $this->request = $request;
        $this->customerRepository = $customerRepository;
        $this->noteSave = $noteSave;
        $this->customer = $customer;
        $this->customerFactory = $customerFactory;
    }

    /**
     * Get post api
     *
     * @return array|false|string
     */
    public function getPost()
    {
        $params = $this->request->getRequestData();
        $customerId = $params['customerId'];
        $creditHoldValue = $params['credit_hold'];

        $writer = new Stream(BP . '/var/log/myfilelog.log');
        $logger = new Logger();
        $logger->addWriter($writer);

        if ($customerId >= 1) {
            if ($creditHoldValue === "1" || $creditHoldValue === "0") {
                try {
                    $customer = $this->customerRepository->getById($customerId);
                    $customer->setCustomAttribute('credit_hold', $creditHoldValue);
                    $this->customerRepository->save($customer);

                    $data = [
                        'note' => 'Credit hold status has been updated via API request.',
                        'customer_id' => $customerId
                    ];
                    $this->noteSave->save($data);
                    $status = 'OK';
                    $message = '';
                } catch (Exception $e) {
                    $status = 'Failed';
                    $message = $e->getMessage();
                    $this->getToLog($message);
                }
            } else {
                $status = 'Failed';
                $message = 'Value of credithold attribute most be 0 or 1!';
                $this->getToLog($message);
            }
        } else {
            $status = 'Failed';
            $message = 'Incorrect customer id type!';
            $this->getToLog($message);
        }

        $response = [
            'status' => $status,
            'message' => $message
        ];

        return json_encode($response);
    }

    /**
     * Add error message to log
     *
     * @param $message
     */
    private function getToLog($message): void
    {
        $writer = new \Laminas\Log\Writer\Stream(BP . '/var/log/attributupdate.log');
        $logger = new \Laminas\Log\Logger();
        $logger->addWriter($writer);
        $logger->info($message);
    }
}
