<?php
declare(strict_types=1);

namespace VanMoof\ProductDelivery\Model\Attribute\Frontend;

use Magento\Eav\Model\Entity\Attribute\Frontend\AbstractFrontend;
use Magento\Eav\Model\Entity\Attribute\Source\BooleanFactory;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Serialize\Serializer\Json as Serializer;
use Magento\Store\Model\StoreManagerInterface;
use VanMoof\ProductDelivery\Model\DeliveryDateProviderInterface;

/**
 * Class to provide delivery date product attribute data on frontend
 */
class DeliveryDate extends AbstractFrontend
{
    /**
     * @var DeliveryDateProviderInterface
     */
    private $deliveryDateProvider;

    /**
     * DeliveryDate Constructor
     *
     * @param BooleanFactory $attrBooleanFactory
     * @param DeliveryDateProviderInterface $deliveryDateProvider
     * @param CacheInterface $cache
     * @param StoreManagerInterface $storeManager
     * @param Serializer $serializer
     * @param null $storeResolver
     * @param array|null $cacheTags
     */
    public function __construct(
        BooleanFactory $attrBooleanFactory,
        DeliveryDateProviderInterface $deliveryDateProvider,
        CacheInterface $cache,
        StoreManagerInterface $storeManager,
        Serializer $serializer,
        $storeResolver = null,
        array $cacheTags = null
    ) {
        parent::__construct($attrBooleanFactory, $cache, $storeResolver, $cacheTags, $storeManager, $serializer);
        $this->deliveryDateProvider = $deliveryDateProvider;
    }

    /**
     * Retrieve attribute value
     *
     * @param DataObject $object
     * @return string
     */
    public function getValue(DataObject $object): string
    {
        return $this->deliveryDateProvider->getDeliveryDate($object);
    }
}
