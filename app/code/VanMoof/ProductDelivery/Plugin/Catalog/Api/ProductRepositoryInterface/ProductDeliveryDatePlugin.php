<?php
declare(strict_types=1);

namespace VanMoof\ProductDelivery\Plugin\Catalog\Api\ProductRepositoryInterface;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductSearchResultsInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\ExtensionAttributesInterface;
use Magento\Framework\Api\ExtensionAttributesInterfaceFactory;
use VanMoof\ProductDelivery\Model\DeliveryDateProviderInterface;

/**
 * Plugin class to intercept product repository class
 */
class ProductDeliveryDatePlugin
{
    /**
     * @var DeliveryDateProviderInterface
     */
    private $deliveryDateProvider;

    /**
     * @var ExtensionAttributesInterfaceFactory
     */
    private $extensionAttributesFactory;

    /**
     * ProductDeliveryDatePlugin Constructor
     *
     * @param ExtensionAttributesInterfaceFactory $extensionAttributesFactory
     * @param DeliveryDateProviderInterface $deliveryDateProvider
     */
    public function __construct(
        ExtensionAttributesInterfaceFactory $extensionAttributesFactory,
        DeliveryDateProviderInterface $deliveryDateProvider
    ) {
        $this->deliveryDateProvider = $deliveryDateProvider;
        $this->extensionAttributesFactory = $extensionAttributesFactory;
    }

    /**
     * Execute method after ProductRepositoryInterface get method to add delivery date attribute
     *
     * @param ProductRepositoryInterface $subject
     * @param ProductInterface $result
     *
     * @return ProductInterface
     */
    public function afterGet(ProductRepositoryInterface $subject, ProductInterface $result): ProductInterface
    {
        $extensionAttributes = $result->getExtensionAttributes();
        if (!$extensionAttributes) {
            /** @var ExtensionAttributesInterface $extensionAttributes */
            $extensionAttributes = $this->extensionAttributesFactory->create();
        }

        $extensionAttributes->setData(
            DeliveryDateProviderInterface::DELIVERY_DATE_ATTRIBUTE_CODE,
            $this->deliveryDateProvider->getDeliveryDate($result)
        );
        $result->setExtensionAttributes($extensionAttributes);

        return $result;
    }

    /**
     * Execute method after ProductRepositoryInterface getList method to add delivery date attribute to collection
     *
     * @param ProductRepositoryInterface $subject
     * @param ProductSearchResultsInterface $result
     *
     * @return ProductSearchResultsInterface
     */
    public function afterGetList(ProductRepositoryInterface $subject, ProductSearchResultsInterface $result): ProductSearchResultsInterface
    {
        foreach ($result->getItems() as $product) {
            $this->afterGet($subject, $product);
        }

        return $result;
    }
}
