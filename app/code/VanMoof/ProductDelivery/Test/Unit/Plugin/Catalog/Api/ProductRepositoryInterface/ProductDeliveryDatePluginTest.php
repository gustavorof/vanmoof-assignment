<?php
declare(strict_types=1);

namespace VanMoof\ProductDelivery\Test\Unit\Ui\DataProvider\Product\Listing\Collector;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductSearchResultsInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductExtensionInterface;
use Magento\Framework\Api\ExtensionAttributesInterfaceFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use VanMoof\ProductDelivery\Model\DeliveryDateProviderInterface;
use VanMoof\ProductDelivery\Plugin\Catalog\Api\ProductRepositoryInterface\ProductDeliveryDatePlugin;

/**
 * PHP Unit test class for \VanMoof\ProductDelivery\Ui\DataProvider\Product\Listing\Collector\DeliveryDate
 */
class ProductDeliveryDatePluginTest extends TestCase
{
    /**
     * @var ProductDeliveryDatePlugin
     */
    private $instance;

    /**
     * @var DeliveryDateProviderInterface|MockObject
     */
    private $deliveryDateProviderMock;

    /**
     * @var ProductSearchResultsInterface|MockObject
     */
    private $productSearchResultsMock;

    /**
     * @var ProductRepositoryInterface|MockObject
     */
    private $productRepositoryMock;

    /**
     * @var ProductExtensionInterface|MockObject
     */
    private $extensionAttributesMock;

    /**
     * @var ExtensionAttributesInterfaceFactory|MockObject
     */
    private $extensionAttributesFactoryMock;

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
        $this->instance = new ProductDeliveryDatePlugin(
            $this->extensionAttributesFactoryMock,
            $this->deliveryDateProviderMock
        );

        $this->assertInstanceOf(ProductDeliveryDatePlugin::class, $this->instance);
    }

    /**
     * Set Mock attributes
     */
    private function setMocks(): void
    {
        $this->deliveryDateProviderMock = $this->createMock(DeliveryDateProviderInterface::class);
        $this->productSearchResultsMock = $this->createMock(ProductSearchResultsInterface::class);
        $this->productRepositoryMock = $this->createMock(ProductRepositoryInterface::class);
        $this->productMock = $this->createMock(ProductInterface::class);
        $this->extensionAttributesMock = $this->getMockBuilder(ProductExtensionInterface::class)
            ->disableOriginalConstructor()
            ->addMethods(['setData'])
            ->getMockForAbstractClass();

        $this->extensionAttributesFactoryMock = $this->getMockBuilder(ExtensionAttributesInterfaceFactory::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['create'])
            ->getMock();

    }

    public function testGetList(): void
    {
        $deliveryDateMock = date('Y-d-m');
        $collectionProductsMock = [$this->productMock];

        $this->productSearchResultsMock->expects($this->once())
            ->method('getItems')
            ->willReturn($collectionProductsMock);

        $this->productMock->expects($this->once())
            ->method('getExtensionAttributes')
            ->willReturn(null);

        $this->extensionAttributesFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->extensionAttributesMock);

        $this->deliveryDateProviderMock->expects($this->once())
            ->method('getDeliveryDate')
            ->with($this->productMock)
            ->willReturn($deliveryDateMock);

        $this->extensionAttributesMock->expects($this->once())
            ->method('setData')
            ->with(DeliveryDateProviderInterface::DELIVERY_DATE_ATTRIBUTE_CODE, $deliveryDateMock)
            ->willReturnSelf();

        $this->productMock->expects($this->once())
            ->method('setExtensionAttributes')
            ->with($this->extensionAttributesMock);

        $result = $this->instance->afterGetList($this->productRepositoryMock, $this->productSearchResultsMock);
        $this->assertSame($this->productSearchResultsMock, $result);
    }
}
