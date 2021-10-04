<?php
declare(strict_types=1);

namespace VanMoof\ProductDelivery\Test\Unit\Ui\DataProvider\Product\Listing\Collector;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductRenderExtensionInterface;
use Magento\Catalog\Api\Data\ProductRenderExtensionFactory;
use Magento\Catalog\Api\Data\ProductRenderInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use VanMoof\ProductDelivery\Ui\DataProvider\Product\Listing\Collector\DeliveryDate;
use VanMoof\ProductDelivery\Model\DeliveryDateProviderInterface;

/**
 * PHP Unit test class for \VanMoof\ProductDelivery\Ui\DataProvider\Product\Listing\Collector\DeliveryDate
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
     * @var ProductRenderExtensionFactory|MockObject
     */
    private $productRenderExtensionFactoryMock;

    /**
     * @var ProductRenderExtensionInterface|MockObject
     */
    private $productRenderExtensionMock;

    /**
     * @var ProductRenderInterface|MockObject
     */
    private $productRenderMock;

    /**
     * @var ProductInterface|MockObject
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
            $this->productRenderExtensionFactoryMock,
            $this->deliveryDateProviderMock
        );

        $this->assertInstanceOf(DeliveryDate::class, $this->instance);
    }

    /**
     * Set Mock attributes
     */
    private function setMocks(): void
    {
        $this->deliveryDateProviderMock = $this->createMock(DeliveryDateProviderInterface::class);
        $this->productRenderMock = $this->createMock(ProductRenderInterface::class);
        $this->productMock = $this->createMock(ProductInterface::class);
        $this->productRenderExtensionMock = $this->getMockBuilder(ProductRenderExtensionInterface::class)
            ->disableOriginalConstructor()
            ->addMethods(['setData'])
            ->getMockForAbstractClass();

        $this->productRenderExtensionFactoryMock = $this->getMockBuilder(ProductRenderExtensionFactory::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['create'])
            ->getMock();

    }

    public function testCollect(): void
    {
        $deliveryDateMock = date('Y-d-m');

        $this->productRenderMock->expects($this->once())
            ->method('getExtensionAttributes')
            ->willReturn(null);

        $this->productRenderExtensionFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->productRenderExtensionMock);

        $this->deliveryDateProviderMock->expects($this->once())
            ->method('getDeliveryDate')
            ->with($this->productMock)
            ->willReturn($deliveryDateMock);

        $this->productRenderExtensionMock->expects($this->once())
            ->method('setData')
            ->with(DeliveryDateProviderInterface::DELIVERY_DATE_ATTRIBUTE_CODE, $deliveryDateMock)
            ->willReturnSelf();

        $this->productRenderMock->expects($this->once())
            ->method('setExtensionAttributes')
            ->with($this->productRenderExtensionMock);

        $this->instance->collect($this->productMock, $this->productRenderMock);
    }
}
