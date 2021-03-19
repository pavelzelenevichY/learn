<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

namespace Codifi\Training\Block\Adminhtml\Edit\Tab\View;

use Codifi\Training\Block\Account\Dashboard\CreditHold;
use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Model\Auth\Session;

/**
 * Class PersonalInfo
 * @package Codifi\Training\Block\Adminhtml\Edit\Tab\View
 */
class PersonalInfo extends Template
{
    /**
     * @var CreditHold
     */
    public $credithold;

    /**
     * @var Session
     */
    protected $authSession;

    /**
     * @var \Magento\Customer\Block\Adminhtml\Edit\Tab\View\PersonalInfo
     */
    public $personalInfoMage;

    public function __construct(
        Context $context,
        CreditHold $creditHold,
        array $data = []
    ) {
        $this->credithold = $creditHold;
        parent::__construct($context, $data);
    }

    public function getCustomer()
    {
        return $this->personalInfoMage->getCustomer();
    }

    public function getOptions()
    {
        return 'ads';
    }

    public function getMessage()
    {
        return $this->credithold->getMessage();
    }
}
