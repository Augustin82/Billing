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
use UCS\Component\Billing\Order\Order;

/**
 * Unit Test Suite for Order
 *
 * @author Nicolas Macherey (nicolas.macherey@gmail.com)
 */
class OrderTest extends \PHPUnit_Framework_TestCase
{
    protected $instance;
    
    protected function setup() {
        $this->instance = new Order();
    }
    
    public function testId() {
        $this->assertNull($this->instance->getId());
    }
    
    public function testState() {
        $this->assertNull($this->instance->getState());

        $value = $this->getMock('UCS\Component\Billing\Order\OrderState');
        $this->instance->setState($value);
        $this->assertEquals($value, $this->instance->getState());
    }
    
    public function testReference() {
        $this->assertNull($this->instance->getReference());

        $value = 'reference';
        $this->instance->setReference($value);
        $this->assertEquals($value, $this->instance->getReference());
    }
    
    public function testCompleted() {
        $this->assertFalse($this->instance->isCompleted());
        $this->instance->complete();
        $this->assertTrue($this->instance->isCompleted());

        $value = false;
        $this->instance->setCompleted($value);
        $this->assertFalse($this->instance->isCompleted());
    }
    
    public function testTotalPrice() {
        $this->assertEquals(0.0,$this->instance->getTotalPrice());

        $value = 10.0;
        $this->instance->setTotalPrice($value);
        $this->assertEquals($value, $this->instance->getTotalPrice());
    }
    
    public function testTotalItemsAmount() {
        $this->assertEquals(0.0,$this->instance->getItemsTotalPrice());

        $value = 10.0;
        $this->instance->setItemsTotalPrice($value);
        $this->assertEquals($value, $this->instance->getItemsTotalPrice());
    }
    
    public function testTotalPricersAmount() {
        $this->assertEquals(0.0,$this->instance->getTotalPricersAmount());

        $value = 10.0;
        $this->instance->setTotalPricersAmount($value);
        $this->assertEquals($value, $this->instance->getTotalPricersAmount());
    }
    
    public function testItems() {
        $item1 = $this->getMock('UCS\Component\Billing\Order\OrderItemInterface');
        $item2 = $this->getMock('UCS\Component\Billing\Order\OrderItemInterface');
        $item3 = $this->getMock('UCS\Component\Billing\Order\OrderItemInterface');
    
        $this->assertNotNull($this->instance->getItems());
        $this->assertTrue($this->instance->isEmpty());
        
        $this->instance->addItem($item1);
        $this->instance->addItem($item2);
        
        $this->assertTrue($this->instance->hasItem($item1));
        $this->assertTrue($this->instance->hasItem($item2));
        $this->assertFalse($this->instance->hasItem($item3));
        $this->assertEquals(2,$this->instance->count());
        $this->assertFalse($this->instance->isEmpty());
        
        // Check remove
        $this->instance->addItem($item3);
        $this->assertTrue($this->instance->hasItem($item3));
        $this->instance->removeItem($item3);
        $this->assertFalse($this->instance->hasItem($item3));
        
        // Try to add an existing item
        $item4 = $this->getMock('UCS\Component\Billing\Order\OrderItemInterface');
        $item4->expects($this->once())
          ->method('isEqualTo')
          ->will($this->returnValue(true));
          
        $this->instance->addItem($item4);
        $this->assertEquals(2,$this->instance->count());
        
        // Try adding an existing item
        $this->instance->addItem($item1);
        $this->assertEquals(2,$this->instance->count());
        
        // Test clear pricer
        $this->instance->clearItems();
        $this->assertFalse($this->instance->hasItem($item1));
        $this->assertFalse($this->instance->hasItem($item2));
        $this->assertTrue($this->instance->isEmpty());
        
        
        // Finally try to set items
        $items = new \Doctrine\Common\Collections\ArrayCollection();
        for( $i = 0; $i < 15; ++$i )
        {
            $items->add($this->getMock('UCS\Component\Billing\Order\OrderItemInterface'));
        }
        
        $this->instance->setItems($items);
        $this->assertEquals(15,$this->instance->count());
        $this->assertEquals($items,$this->instance->getItems());
        $this->assertEquals($items,$this->instance->getIterator());
    }
    
    public function testTotalQuantity() {
        $item1 = $this->getMock('UCS\Component\Billing\Order\OrderItemInterface');
        $item1->expects($this->once())
          ->method('getQuantity')
          ->will($this->returnValue(3));
          
        $item2 = $this->getMock('UCS\Component\Billing\Order\OrderItemInterface');
        $item2->expects($this->once())
          ->method('getQuantity')
          ->will($this->returnValue(10));
          
        $item3 = $this->getMock('UCS\Component\Billing\Order\OrderItemInterface');
        $item3->expects($this->once())
          ->method('getQuantity')
          ->will($this->returnValue(4));
        
        $this->instance->addItem($item1);
        $this->instance->addItem($item2);
        $this->instance->addItem($item3);
        
        $this->assertEquals(17,$this->instance->getTotalQuantity());
    }
    
    public function testPricers() {
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
}
