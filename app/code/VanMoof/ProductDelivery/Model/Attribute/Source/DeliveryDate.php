<?php
declare(strict_types=1);

namespace VanMoof\ProductDelivery\Model\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Class to provide Delivery Date product attribute available options
 *
 * @codeCoverageIgnore
 */
class DeliveryDate extends AbstractSource
{
    /**
     * @inheirtDoc
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['value' => '7', 'label' => __('7 Days')],
                ['value' => '14', 'label' => __('14 Days')],
                ['value' => '30', 'label' => __('30 Days')]
            ];
        }

        return $this->_options;
    }
}
