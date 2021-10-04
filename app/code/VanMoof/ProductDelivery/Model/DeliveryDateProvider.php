<?php
declare(strict_types=1);

namespace VanMoof\ProductDelivery\Model;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * Class to provide delivery date attribute data
 */
class DeliveryDateProvider implements DeliveryDateProviderInterface
{
    /**
     * @var TimezoneInterface
     */
    private $timezone;

    /**
     * DeliveryDateProvider Constructor
     *
     * @param TimezoneInterface $timezone
     */
    public function __construct(TimezoneInterface $timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @inheirtDoc
     */
    public function getDeliveryDate(ProductInterface $product): string
    {
        $deliveryDays = $product->getData(static::DELIVERY_DATE_ATTRIBUTE_CODE);

        if (!$deliveryDays) {
            return '';
        }

        $date = $this->timezone->date();
        $date->modify(sprintf('+%s days', $deliveryDays));

        return $date->format('Y-m-d');
    }
}
