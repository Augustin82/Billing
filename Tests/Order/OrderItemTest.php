<?php

/*
 * This file is part of the UCS package.
 *
 * (c) Nicolas Macherey <nicolas.macherey@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Tests\UCS\Component\Billing\Tests\Order;

/* imports */
use UCS\Component\Billing\Order\OrderItem;

/**
 * Unit Test Suite for OrderItem
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
class OrderItemTest extends \PHPUnit_Framework_TestCase
{
    protected $instance;

    protected function setup()
    {
        $this->instance = new OrderItem();
    }

    /**
     * Test that the id property is properly handled
     */
    public function testId()
    {
        $this->assertNull($this->instance->getId());
    }

    /**
     * Test that the quantity property is properly handled
     */
    public function testQuantity()
    {
        $this->assertEquals(0, $this->instance->getQuantity());

        $value = 10;
        $this->instance->setQuantity($value);
        $this->assertEquals($value, $this->instance->getQuantity());
    }

    /**
     * Test that the unitPrice property is properly handled
     */
    public function testUnitPrice()
    {
        $this->assertEquals(0.0, $this->instance->getUnitPrice());

        $value = 19.99;
        $this->instance->setUnitPrice($value);
        $this->assertEquals($value, $this->instance->getUnitPrice());
    }

    /**
     * Test that the total price property is properly handled
     */
    public function testTotalPrice()
    {
        $this->assertEquals(0.0, $this->instance->getTotalPrice());

        $value = 19.99;
        $this->instance->setTotalPrice($value);
        $this->assertEquals($value, $this->instance->getTotalPrice());
    }

    /**
     * Test that the order property is properly handled
     */
    public function testOrder()
    {
        $this->assertNull($this->instance->getOrder());

        $value = $this->getMock('UCS\Component\Billing\Order\OrderInterface');
        $this->instance->setOrder($value);
        $this->assertEquals($value, $this->instance->getOrder());
    }

    /**
     * Test that the merging is properly handled
     */
    public function testMergeNoException()
    {
        $this->instance->setQuantity(3);
        $this->instance->merge($this->instance);
        $this->assertEquals(6, $this->instance->getQuantity());
    }

    /**
     * @expectedException UCS\Component\Billing\Order\Exception\CannotMergeOrderItemException
     */
    public function testMergeException()
    {
        $item = new OrderItem();
        $item->setQuantity(4);

        $this->instance->setQuantity(3);
        $this->instance->merge($item);
    }

    /**
     * Test that that the pricers property is properly handled
     */
    public function testPricers()
    {
        $pricer1 = $this->getMock('UCS\Component\Billing\Pricer\PricerInterface');
        $pricer2 = $this->getMock('UCS\Component\Billing\Pricer\PricerInterface');
        $pricer3 = $this->getMock('UCS\Component\Billing\Pricer\PricerInterface');

        $this->assertNotNull($this->instance->getPricers());

        $this->instance->addPricer($pricer1);
        $this->instance->addPricer($pricer2);

        $this->assertTrue($this->instance->hasPricer($pricer1));
        $this->assertTrue($this->instance->hasPricer($pricer2));
        $this->assertFalse($this->instance->hasPricer($pricer3));

        // Check remove
        $this->instance->addPricer($pricer3);
        $this->assertTrue($this->instance->hasPricer($pricer3));
        $this->instance->removePricer($pricer3);
        $this->assertFalse($this->instance->hasPricer($pricer3));

        // Test clear pricer
        $this->instance->clearPricers();
        $this->assertFalse($this->instance->hasPricer($pricer1));
        $this->assertFalse($this->instance->hasPricer($pricer2));
    }

    /**
     * Test that the total pricers ampunt is properly handled
     */
    public function testTotalPricersAmount()
    {
        $this->assertEquals(0.0, $this->instance->getTotalPricersAmount());

        $value = 19.99;
        $this->instance->setTotalPricersAmount($value);
        $this->assertEquals($value, $this->instance->getTotalPricersAmount());
    }
}
