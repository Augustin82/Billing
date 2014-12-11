<?php

/*
 * This file is part of the UCS package.
 *
 * (c) Nicolas Macherey <nicolas.macherey@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace UCS\Component\Billing\Tests\Order;

/* imports */
use UCS\Component\Billing\Order\OrderState;

/**
 * Unit Test Suite for OrderState
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
class OrderStateTest extends \PHPUnit_Framework_TestCase
{
    protected $instance;

    protected function setup()
    {
        $this->instance = new OrderState();
    }

    /**
     * Test the id property
     */
    public function testId()
    {
        $this->assertNull($this->instance->getId());
    }

    /**
     * Test the name property
     */
    public function testName()
    {
        $this->assertNull($this->instance->getName());

        $value = 'name';
        $this->instance->setName($value);
        $this->assertEquals($value, $this->instance->getName());
    }

    /**
     * Test serialize
     */
    public function testSerialize()
    {
        $this->instance->setName('name');

        $data = serialize(array(null, 'name'));
        $this->assertEquals($data, $this->instance->serialize());
    }

    /**
     * Test unserialize
     */
    public function testUnserialize()
    {
        $data = serialize(array(1, 'name'));
        $this->instance->unserialize($data);

        $this->assertEquals('name', $this->instance->getName());
        $this->assertEquals(1, $this->instance->getId());
    }
}
