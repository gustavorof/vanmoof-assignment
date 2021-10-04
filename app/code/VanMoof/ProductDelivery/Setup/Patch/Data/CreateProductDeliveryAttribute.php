<?php
declare(strict_types=1);

namespace VanMoof\ProductDelivery\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use VanMoof\ProductDelivery\Model\Attribute\Frontend\DeliveryDate as FrontendDeliveryDate;
use VanMoof\ProductDelivery\Model\Attribute\Source\DeliveryDate as SourceDeliveryDate;
use VanMoof\ProductDelivery\Model\DeliveryDateProviderInterface;

/**
 * Data patch class to create delivery date product attribute
 */
class CreateProductDeliveryAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * CreateProductDeliveryAttribute Constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        /** @var EavSetup $customerSetup */
        $customerSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $customerSetup->addAttribute(Product::ENTITY, DeliveryDateProviderInterface::DELIVERY_DATE_ATTRIBUTE_CODE, [
            'type' => 'int',
            'label' => 'Delivery date',
            'input' => 'select',
            'backend' => '',
            'frontend' => FrontendDeliveryDate::class,
            'source' => SourceDeliveryDate::class,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => false,
            'user_defined' => false,
            'searchable' => true,
            'filterable' => true,
            'comparable' => true,
            'visible_on_front' => true,
            'used_in_product_listing' => true,
            'unique' => false
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }
}
