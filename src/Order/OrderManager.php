<?php

/*
 * This file is part of the UCS package.
 *
 * Copyright 2014 Nicolas Macherey <nicolas.macherey@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace UCS\Component\Billing\Order;

/* Imports */
use Doctrine\Common\Collections\Collection;
use UCS\Component\Billing\Order\Exception\UnsupportedOrderException;
use UCS\Component\Billing\Order\Exception\OrderNotFoundException;

/**
 * Abstract Order Manager implementation which can be used as base class for your
 * concrete manager.
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
abstract class OrderManager implements OrderManagerInterface
{
    /**
     * Creates an empty order instance.
     *
     * @return OrderInterface
     */
    public function createOrder()
    {
        $class = $this->getClass();
        $order = new $class();

        return $order;
    }

    /**
     * {@inheritdoc}
     */
    public function findOrderById($id)
    {
        return $this->findOrderBy(array('id' => $id));
    }

    /**
     * {@inheritdoc}
     */
    public function findOrderByReference($reference)
    {
        return $this->findOrderBy(array('reference' => $reference));
    }

    /**
     * {@inheritdoc}
     */
    public function findOrderByIdOrReference($idOrReference)
    {
        $order = $this->findOrderByReference($idOrReference);

        if ($order == null) {
            $order = $this->findOrderById($idOrReference);
        }

        return $order;
    }

    /**
     * {@inheritdoc}
     */
    public function reloadOrder(OrderInterface $order)
    {
        $class = $this->getClass();
        if (!$order instanceof $class) {
            throw new UnsupportedOrderException('Order class is not supported.');
        }

        if (!$order instanceof Order) {
            throw new UnsupportedOrderException(sprintf('Expected an instance of UCS\Component\Billing\Order\Order, but got "%s".', get_class($order)));
        }

        $reloadedOrder = $this->findOrderBy(array('reference' => $order->getReference()));

        if (null === $reloadedOrder) {
            throw new OrderNotFoundException(sprintf('Order with Reference "%d" could not be reloaded.', $order->getReference()));
        }

        return $reloadedOrder;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateOrderTotal(OrderInterface $order)
    {
        $itemsTotal = $this->calculateItemsTotal($order->getItems());
        $pricersTotal = $this->calculatePricersTotal($order->getPricers());

        $total = $itemsTotal + $pricersTotal;

        if ($total < 0) {
            $total = 0;
        }

        $order->setTotalPrice($total);
        $order->setItemsTotalPrice($itemsTotal);
        $order->setTotalPricersAmount($pricersTotal);

        return $total;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateItemsTotal(Collection $items)
    {
        $itemsTotal = 0;

        foreach ($items as $item) {
            $this->calculateItemTotal($item);
            $itemsTotal += $item->getTotalPrice();
        }

        return $itemsTotal;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateItemTotal(OrderItemInterface $item)
    {
        $pricersTotal = $this->calculatePricersTotal($item->getPricers());
        $item->setTotalPricersAmount($pricersTotal);

        $total = ($item->getQuantity() * $item->getUnitPrice()) + $pricersTotal;

        if ($total < 0) {
            $total = 0;
        }

        $item->setTotalPrice($total);

        return $total;
    }

    /**
     * {@inheritdoc}
     */
    public function calculatePricersTotal(Collection $pricers)
    {
        $pricersTotal = 0;

        foreach ($pricers as $pricer) {
            if (!$pricer->isNeutral()) {
                $pricersTotal += $pricer->getAmount();
            }
        }

        return $pricersTotal;
    }
}
