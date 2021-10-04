<?php
declare(strict_types=1);

namespace VanMoof\ProductDelivery\Model;

use Magento\Catalog\Api\Data\ProductInterface;

/**
 * Interface to provide product delivery date information
 */
interface DeliveryDateProviderInterface
{
    public const DELIVERY_DATE_ATTRIBUTE_CODE = 'delivery_date';

    /**
     * Get Delivery Date of Product
     *
     * @param ProductInterface $product
     *
     * @return string
     */
    public function getDeliveryDate(ProductInterface $product): string;
}
