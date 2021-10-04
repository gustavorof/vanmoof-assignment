<?php
declare(strict_types=1);

namespace VanMoof\ProductDelivery\Test\Unit\Model;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use VanMoof\ProductDelivery\Model\DeliveryDateProvider;
use VanMoof\ProductDelivery\Model\DeliveryDateProviderInterface;

/**
 * PHP Unit test class for \VanMoof\ProductDelivery\Model\DeliveryDateProviderInterface
 */
class DeliveryDateProviderTest extends TestCase
{
    /**
     * @var DeliveryDateProvider
     */
    private $instance;

    /**
     * @var TimezoneInterface|MockObject
     */
    private $timezoneMock;

    /**
     * @var ProductInterface|MockObject
     */
    private $productMock;

    /**
     * @var \DateTime|MockObject
     */
    private $dateTimeMock;

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
        $this->instance = new DeliveryDateProvider($this->timezoneMock);
        $this->assertInstanceOf(DeliveryDateProvider::class, $this->instance);
    }

    /**
     * Set Mock attributes
     */
    private function setMocks(): void
    {
        $this->timezoneMock = $this->createMock(TimezoneInterface::class);
        $this->dateTimeMock = $this->createMock(\DateTime::class);

        $this->productMock = $this->getMockBuilder(ProductInterface::class)
            ->disableOriginalConstructor()
            ->addMethods(['getData'])
            ->getMockForAbstractClass();
    }

    public function testGetDeliveryDate(): void
    {
        $expectedResult = date('Y-d-m');
        $daysMock = '21';

        $this->productMock->expects($this->once())
            ->method('getData')
            ->with(DeliveryDateProviderInterface::DELIVERY_DATE_ATTRIBUTE_CODE)
            ->willReturn($daysMock);

        $this->timezoneMock->expects($this->once())
            ->method('date')
            ->willReturn($this->dateTimeMock);

        $this->dateTimeMock->expects($this->once())
            ->method('modify')
            ->willReturn($this->dateTimeMock);

        $this->dateTimeMock->expects($this->once())
            ->method('format')
            ->willReturn($expectedResult);

        $result = $this->instance->getDeliveryDate($this->productMock);
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetDeliveryDateWithEmptyDeliveryDaysAttribute(): void
    {
        $expectedResult = '';
        $this->productMock->expects($this->once())
            ->method('getData')
            ->with(DeliveryDateProviderInterface::DELIVERY_DATE_ATTRIBUTE_CODE)
            ->willReturn($expectedResult);

        $result = $this->instance->getDeliveryDate($this->productMock);
        $this->assertEquals($expectedResult, $result);
    }
}
