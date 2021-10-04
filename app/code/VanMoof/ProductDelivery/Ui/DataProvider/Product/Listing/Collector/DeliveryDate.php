<?php
declare(strict_types=1);

namespace VanMoof\ProductDelivery\Ui\DataProvider\Product\Listing\Collector;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductRenderExtensionFactory;
use Magento\Catalog\Api\Data\ProductRenderInterface;
use Magento\Catalog\Ui\DataProvider\Product\ProductRenderCollectorInterface;
use VanMoof\ProductDelivery\Model\DeliveryDateProviderInterface;

/**
 * Delivery Date extension attribute Collector Listing data provider
 */
class DeliveryDate implements ProductRenderCollectorInterface
{
    /**
     * @var ProductRenderExtensionFactory
     */
    private $productRenderExtensionFactory;

    /**
     * @var DeliveryDateProviderInterface
     */
    private $deliveryDateProvider;

    /**
     * DeliveryDate Constructor
     *
     * @param ProductRenderExtensionFactory $productRenderExtensionFactory
     * @param DeliveryDateProviderInterface $deliveryDateProvider
     */
    public function __construct(
        ProductRenderExtensionFactory $productRenderExtensionFactory,
        DeliveryDateProviderInterface $deliveryDateProvider
    ) {
        $this->productRenderExtensionFactory = $productRenderExtensionFactory;
        $this->deliveryDateProvider = $deliveryDateProvider;
    }

    /**
     * @inheirtDoc
     */
    public function collect(ProductInterface $product, ProductRenderInterface $productRender)
    {
        $extensionAttributes = $productRender->getExtensionAttributes();

        if (!$extensionAttributes) {
            $extensionAttributes = $this->productRenderExtensionFactory->create();
        }

        $extensionAttributes->setData(
            DeliveryDateProviderInterface::DELIVERY_DATE_ATTRIBUTE_CODE,
            $this->deliveryDateProvider->getDeliveryDate($product)
        );
        $productRender->setExtensionAttributes($extensionAttributes);
    }
}
