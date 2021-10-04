<?php
declare(strict_types=1);

namespace VanMoof\ProductDelivery\Test\Unit\Model\Attribute\Frontend;

use Magento\Eav\Model\Entity\Attribute\Source\BooleanFactory;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\Serialize\Serializer\Json as Serializer;
use Magento\Store\Model\StoreManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use VanMoof\ProductDelivery\Model\Attribute\Frontend\DeliveryDate;
use VanMoof\ProductDelivery\Model\DeliveryDateProviderInterface;

/**
 * PHP Unit test class for \VanMoof\ProductDelivery\Model\Attribute\Frontend\DeliveryDate
 */
class DeliveryDateTest extends TestCase
{
    /**
     * @var DeliveryDate
     */
    private $instance;

    /**
     * @var DeliveryDateProviderInterface|MockObject
     */
    private $deliveryDateProviderMock;

    /**
     * @var BooleanFactory|MockObject
     */
    private $booleanFactoryMock;

    /**
     * @var CacheInterface|MockObject
     */
    private $cacheMock;

    /**
     * @var StoreManagerInterface|MockObject
     */
    private $storeManagerMock;

    /**
     * @var Serializer|MockObject
     */
    private $serializerMock;

    /**
     * @var Product|MockObject
     */
    private $productMock;

    /**
     * Test setup
     */
    protected function setUp(): void
    {
        $this->setMocks();
        $this->setInstance();
    }

    /**
     * Set Instance attribute
     */
    private function setInstance(): void
    {
        $this->instance = new DeliveryDate(
            $this->booleanFactoryMock,
            $this->deliveryDateProviderMock,
            $this->cacheMock,
            $this->storeManagerMock,
            $this->serializerMock
        );

        $this->assertInstanceOf(DeliveryDate::class, $this->instance);
    }

    /**
     * Set Mock attributes
     */
    private function setMocks(): void
    {
        $this->deliveryDateProviderMock = $this->createMock(DeliveryDateProviderInterface::class);
        $this->booleanFactoryMock = $this->createMock(BooleanFactory::class);
        $this->storeManagerMock = $this->createMock(StoreManagerInterface::class);
        $this->cacheMock = $this->createMock(CacheInterface::class);
        $this->serializerMock = $this->createMock(Serializer::class);
        $this->productMock = $this->createMock(Product::class);
    }

    public function testGetValue(): void
    {
        $expectedResult = date('Y-d-m');

        $this->deliveryDateProviderMock->expects($this->once())
            ->method('getDeliveryDate')
            ->with($this->productMock)
            ->willReturn($expectedResult);

        $result = $this->instance->getValue($this->productMock);
        $this->assertEquals($expectedResult, $result);
    }
}
