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
use UCS\Component\Billing\Order\Order;

/**
 * Unit Test Suite for OrderManager
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
class OrderManagerTest extends \PHPUnit_Framework_TestCase
{
    protected $instance;

    protected function setup()
    {
        $this->instance = $this->getMockForAbstractClass('UCS\Component\Billing\Order\OrderManager');
    }

    /**
     * Test order creation
     */
    public function testCreateOrder()
    {
        $this->instance->expects($this->once())
          ->method('getClass')
          ->will($this->returnValue('UCS\Component\Billing\Order\Order'));

        $order = $this->instance->createOrder();
        $this->assertTrue($order instanceof \UCS\Component\Billing\Order\Order,
            '->createOrder() must create a valid order instance');
    }

    /**
     * Test find by order id
     */
    public function testFindOrderById()
    {
        $order = $this->getMock('UCS\Component\Billing\Order\OrderInterface');
        $this->instance->expects($this->once())
          ->method('findOrderBy')
          ->with($this->equalTo(array('id' => 'order')))
          ->will($this->returnValue($order));

        $this->assertEquals($order, $this->instance->findOrderById('order'),
            '->findOrderById() must return an order or null');
    }

    /**
     * Test find by order reference
     */
    public function testFindOrderByReference()
    {
        $order = $this->getMock('UCS\Component\Billing\Order\OrderInterface');
        $this->instance->expects($this->once())
          ->method('findOrderBy')
          ->with($this->equalTo(array('reference' => 'order')))
          ->will($this->returnValue($order));

        $this->assertEquals($order, $this->instance->findOrderByReference('order'),
            '->findOrderByName() must return an order or null');
    }

    /**
     * Test find by order reference with reference first
     */
    public function testFindOrderByIdOrReferenceWithReferenceFirst()
    {
        $order = $this->getMock('UCS\Component\Billing\Order\OrderInterface');
        $instance = $this->getMockForAbstractClass(
            'UCS\Component\Billing\Order\OrderManager',
            $arguments = array(),
            $mockClassName = '',
            $callOriginalConstructor = false,
            $callOriginalClone = false,
            $callAutoload = true,
            $mockedMethods = array('findOrderByReference', 'findOrderById')
        );

        $instance->expects($this->once())
          ->method('findOrderByReference')
          ->with($this->equalTo('order'))
          ->will($this->returnValue($order));

        $this->assertEquals($order, $instance->findOrderByIdOrReference('order'),
            '->findOrderByIdOrReference() must return an order or null');
    }

    /**
     * Test find an order by name or reference
     */
    public function testFindOrderByNameOrReferenceWithName()
    {
        $order = $this->getMock('UCS\Component\Billing\Order\OrderInterface');
        $instance = $this->getMockForAbstractClass(
            'UCS\Component\Billing\Order\OrderManager',
            $arguments = array(),
            $mockClassName = '',
            $callOriginalConstructor = false,
            $callOriginalClone = false,
            $callAutoload = true,
            $mockedMethods = array('findOrderByReference', 'findOrderById')
        );

        $instance->expects($this->once())
          ->method('findOrderByReference')
          ->with($this->equalTo('order'))
          ->will($this->returnValue(null));

        $instance->expects($this->once())
          ->method('findOrderById')
          ->with($this->equalTo('order'))
          ->will($this->returnValue($order));

        $this->assertEquals($order, $instance->findOrderByIdOrReference('order'),
            '->findOrderByIdOrReference() must return a order or null');
    }

    /**
     * @expectedException UCS\Component\Billing\Order\Exception\UnsupportedOrderException
     */
    public function testRefreshWrongClass()
    {
        $order = $this->getMock('UCS\Component\Billing\Order\OrderInterface');
        $this->instance->expects($this->once())
          ->method('getClass')
          ->will($this->returnValue('UCS\Component\Billing\Order\Order'));

        // Wrong expected order got Mock
        $this->instance->reloadOrder($order);
    }

    /**
     * @expectedException UCS\Component\Billing\Order\Exception\UnsupportedOrderException
     */
    public function testRefreshWrongInherit()
    {
        $order = $this->getMock('UCS\Component\Billing\Order\OrderInterface');
        $this->instance->expects($this->once())
          ->method('getClass')
          ->will($this->returnValue('UCS\Component\Billing\Order\OrderInterface'));

        // Wrong expected Order got Mock
        $this->instance->reloadOrder($order);
    }

    /**
     * @expectedException UCS\Component\Billing\Order\Exception\OrderNotFoundException
     */
    public function testRefreshOrderNotFound()
    {
        $order = $this->getMock('UCS\Component\Billing\Order\Order');
        $order->expects($this->exactly(2))
          ->method('getReference')
          ->will($this->returnValue('order'));

        $this->instance->expects($this->once())
          ->method('getClass')
          ->will($this->returnValue('UCS\Component\Billing\Order\Order'));

        $this->instance->expects($this->once())
          ->method('findOrderBy')
          ->with($this->equalTo(array('reference' => 'order')));

        // Wrong expected Order got Mock
        $this->instance->reloadOrder($order);
    }

    /**
     * Test refresh order
     */
    public function testRefreshComplete()
    {
        $order = $this->getMock('UCS\Component\Billing\Order\Order');
        $order->expects($this->once())
          ->method('getReference')
          ->will($this->returnValue('order'));

        $this->instance->expects($this->once())
          ->method('getClass')
          ->will($this->returnValue('UCS\Component\Billing\Order\Order'));

        $this->instance->expects($this->once())
          ->method('findOrderBy')
          ->with($this->equalTo(array('reference' => 'order')))
          ->will($this->returnValue($order));

        // Wrong expected Order got Mock
        $this->assertEquals($order, $this->instance->reloadOrder($order),
            '->reloadOrder() the order reference must be returned');
    }

    /**
     * Test pricers total calculation
     */
    public function testCalculatePricersTotal()
    {
        $pricers = new \Doctrine\Common\Collections\ArrayCollection();
        $pricers->add($this->getMockPricer(10.0, false));
        $pricers->add($this->getMockPricer(0.0, true));
        $pricers->add($this->getMockPricer(-2.0, false));

        $total = $this->instance->calculatePricersTotal($pricers);
        $this->assertEquals(8.0, $total,
            '->calculatePricersTotal() must return the total calculated pricer amount');
    }

    /**
     * Test calculate order item total
     */
    public function testCalculateItemTotal()
    {
        $pricers = new \Doctrine\Common\Collections\ArrayCollection();
        $pricers->add($this->getMockPricer(10.0, false));
        $pricers->add($this->getMockPricer(0.0, true));
        $pricers->add($this->getMockPricer(-2.0, false));

        $item = $this->getMockItem(2, 10.0, $pricers);

        $total = $this->instance->calculateItemTotal($item);
        $this->assertEquals(28.0, $total,
            '->calculateItemTotal() must return the total item price including pricers');
    }

    /**
     * Test the calculation with an order total less than zero
     */
    public function testCalculateItemTotalWithTotalLessThanZero()
    {
        $pricers = new \Doctrine\Common\Collections\ArrayCollection();
        $pricers->add($this->getMockPricer(-20.0, false));
        $pricers->add($this->getMockPricer(0.0, true));
        $pricers->add($this->getMockPricer(-2.0, false));

        $item = $this->getMockItem(2, 10.0, $pricers);

        $total = $this->instance->calculateItemTotal($item);
        $this->assertEquals(0.0, $total,
            '->calculateItemTotal() must always return a positive or zero value');
    }

    /**
     * Test calculate items total
     */
    public function testCalculateItemsTotal()
    {
        $items = new \Doctrine\Common\Collections\ArrayCollection();

        $pricers = new \Doctrine\Common\Collections\ArrayCollection();
        $pricers->add($this->getMockPricer(10.0, false));
        $pricers->add($this->getMockPricer(0.0, true));
        $pricers->add($this->getMockPricer(-2.0, false));
        $item = $this->getMockItem(2, 10.0, $pricers); // 28.0 in total
        $item->expects($this->once())
          ->method('getTotalPrice')
          ->will($this->returnValue(28.0));

        $items->add($item);

        $pricers = new \Doctrine\Common\Collections\ArrayCollection();
        $pricers->add($this->getMockPricer(-4.0, false));
        $pricers->add($this->getMockPricer(0.0, true));
        $pricers->add($this->getMockPricer(-2.0, false));
        $item = $this->getMockItem(3, 16.0, $pricers); // 42.0 in total
        $item->expects($this->once())
          ->method('getTotalPrice')
          ->will($this->returnValue(42.0));

        $items->add($item);

        $total = $this->instance->calculateItemsTotal($items);
        $this->assertEquals(70.0, $total,
            '->calculateItemdTotal() must return the total itemd price including pricers');
    }

    /**
     * Test order total
     */
    public function testCalculateOrderTotal()
    {
        $items = new \Doctrine\Common\Collections\ArrayCollection();

        $pricers = new \Doctrine\Common\Collections\ArrayCollection();
        $pricers->add($this->getMockPricer(10.0, false));
        $pricers->add($this->getMockPricer(0.0, true));
        $pricers->add($this->getMockPricer(-2.0, false));
        $item = $this->getMockItem(2, 10.0, $pricers); // 28.0 in total
        $item->expects($this->once())
          ->method('getTotalPrice')
          ->will($this->returnValue(28.0));

        $items->add($item);

        $pricers = new \Doctrine\Common\Collections\ArrayCollection();
        $pricers->add($this->getMockPricer(-4.0, false));
        $pricers->add($this->getMockPricer(0.0, true));
        $pricers->add($this->getMockPricer(-2.0, false));
        $item = $this->getMockItem(3, 16.0, $pricers); // 42.0 in total
        $item->expects($this->once())
          ->method('getTotalPrice')
          ->will($this->returnValue(42.0));

        $items->add($item);

        // Order Mock
        $order = $this->getMock('UCS\Component\Billing\Order\OrderInterface');
        $order->expects($this->once())
          ->method('setTotalPrice');
        $order->expects($this->once())
          ->method('setItemsTotalPrice');
        $order->expects($this->once())
          ->method('setTotalPricersAmount');
        $order->expects($this->once())
          ->method('getItems')
          ->will($this->returnValue($items));

        $pricers = new \Doctrine\Common\Collections\ArrayCollection();
        $pricers->add($this->getMockPricer(-2.0, false));

        $order->expects($this->once())
          ->method('getPricers')
          ->will($this->returnValue($pricers));

        $total = $this->instance->calculateOrderTotal($order);
        $this->assertEquals(68.0, $total,
            '->calculateOrderTotal() must return the total order price the user sould pay for');
    }

    /**
     * Test order total with a total less than zero
     */
    public function testCalculateOrderTotalWithTotalLessThanZero()
    {
        $items = new \Doctrine\Common\Collections\ArrayCollection();

        $pricers = new \Doctrine\Common\Collections\ArrayCollection();
        $pricers->add($this->getMockPricer(10.0, false));
        $pricers->add($this->getMockPricer(0.0, true));
        $pricers->add($this->getMockPricer(-2.0, false));
        $item = $this->getMockItem(2, 10.0, $pricers); // 28.0 in total
        $item->expects($this->once())
          ->method('getTotalPrice')
          ->will($this->returnValue(0.0));

        $items->add($item);

        $pricers = new \Doctrine\Common\Collections\ArrayCollection();
        $pricers->add($this->getMockPricer(-4.0, false));
        $pricers->add($this->getMockPricer(0.0, true));
        $pricers->add($this->getMockPricer(-2.0, false));
        $item = $this->getMockItem(3, 16.0, $pricers); // 42.0 in total
        $item->expects($this->once())
          ->method('getTotalPrice')
          ->will($this->returnValue(0.0));

        $items->add($item);

        // Order Mock
        $order = $this->getMock('UCS\Component\Billing\Order\OrderInterface');
        $order->expects($this->once())
          ->method('setTotalPrice');
        $order->expects($this->once())
          ->method('setItemsTotalPrice');
        $order->expects($this->once())
          ->method('setTotalPricersAmount');
        $order->expects($this->once())
          ->method('getItems')
          ->will($this->returnValue($items));

        $pricers = new \Doctrine\Common\Collections\ArrayCollection();
        $pricers->add($this->getMockPricer(-2.0, false));

        $order->expects($this->once())
          ->method('getPricers')
          ->will($this->returnValue($pricers));

        $total = $this->instance->calculateOrderTotal($order);
        $this->assertEquals(0.0, $total,
            '->calculateOrderTotal() must return the total order price the user sould pay for');
    }

    protected function getMockPricer($amount = 0, $neutral = false)
    {
        $pricer = $this->getMock('UCS\Component\Billing\Pricer\PricerInterface');
        $pricer->expects($this->once())
          ->method('isNeutral')
          ->will($this->returnValue($neutral));

        if ($neutral === false) {
            $pricer->expects($this->once())
              ->method('getAmount')
              ->will($this->returnValue($amount));
        }

        return $pricer;
    }

    protected function getMockItem($quantity = 0, $unitPrice = 0.0, $pricers = array())
    {
        $item = $this->getMock('UCS\Component\Billing\Order\OrderItemInterface');
        $item->expects($this->once())
          ->method('getQuantity')
          ->will($this->returnValue($quantity));

        $item->expects($this->once())
          ->method('getUnitPrice')
          ->will($this->returnValue($unitPrice));

        $item->expects($this->once())
          ->method('getPricers')
          ->will($this->returnValue($pricers));

        return $item;
    }
}
