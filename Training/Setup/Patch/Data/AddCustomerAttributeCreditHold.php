<?php
/**
 * Codifi_Training
 *
 * @copyright   Copyright (c) 2021 Codifi
 * @author      Pavel Zelenevich <pzelenevich@codifi.me>
 */

namespace Codifi\Training\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Model\ResourceModel\Attribute as AttributeResourceModel;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

/**
 * Class AddCustomerAttributeCreditHold
 * @package Codifi\Training\Setup\Patch\Data
 */
class AddCustomerAttributeCreditHold implements DataPatchInterface, PatchRevertableInterface
{

    const CODE_CUSTOM_ATTRIBUTE = 'credit_hold';

    const LABEL_CUSTOM_ATTRIBUTE = 'Credit Hold';

    /**
     * @var ModuleDataSetupInterface
     * An additional pre-configuration environment that creates a database connection
     */
    private $moduleDataSetup;

    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * @var AttributeResourceModel
     */
    private $attributeResourceModel;

    /**
     * AddCustomerAttributeCereditHold Constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     * @param AttributeResourceModel $attributeResourceModel
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        AttributeResourceModel $attributeResourceModel
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->attributeResourceModel = $attributeResourceModel;
    }

    /**
     * Add 'Credit Hold' customer attribute
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $customerEntity = $customerSetup->getEavConfig()->getEntityType(\Magento\Customer\Model\Customer::ENTITY);
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $customerSetup->addAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            self::CODE_CUSTOM_ATTRIBUTE,
            [
                'attribute_set_id' => '',
                'attribute_group_id' => '',

                'type' => 'int',
                'label' => self::LABEL_CUSTOM_ATTRIBUTE,
                'input' => 'select',
                'source' => \Codifi\Training\Model\Source\CustomSelect::class,
                'sort_order' => '30',
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => '0',
                'unique' => false,
                'system' => false,
                'is_visible_in_grid' => true,
                'is_used_in_grid' => true,
                'is_filterable_in_grid' => true,
                'is_searchable_in_grid' => true,
            ]
        );

        $attribute = $customerSetup->getEavConfig()->getAttribute(\Magento\Customer\Model\Customer::ENTITY, self::CODE_CUSTOM_ATTRIBUTE)->addData([
            'attribute_set_id' => $attributeSetId,
            'attribute_group_id' => $attributeGroupId,
            'used_in_forms' => [
                'adminhtml_customer'
            ]
        ]);

        $this->attributeResourceModel->save($attribute);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * Delete 'Credit Hold' customer attribute. This method will be executed to remove a custom attribute
     * if you run the command "bin/magento module:uninstall Codifi_Training"
     * or "bin/magento module:uninstall --non-composer Codifi_Training".
     */
    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->attributeSetFactory->create(['setup' => $this->moduleDataSetup]);
        $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, self::CODE_CUSTOM_ATTRIBUTE);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }
}
