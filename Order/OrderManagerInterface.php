<?php

/*
 * This file is part of the UCS package.
 *
 * Copyright 2014 Nicolas Macherey (nicolas.macherey@gmail.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace UCS\Component\Billing\Order;

/* Imports */
use Doctrine\Common\Collections\Collection;

/**
 * Interface to be implemented by order managers. This adds an additional level
 * of abstraction between your application, and the actual repository.
 *
 * All changes to orders should happen through this interface.
 *
 * @author Nicolas Macherey (nicolas.macherey@gmail.com)
 */
interface OrderManagerInterface
{
    /**
     * Creates an empty order instance.
     *
     * @return OrderInterface
     */
    public function createOrder();

    /**
     * Deletes an order.
     *
     * @param OrderInterface $order
     *
     * @return void
     */
    public function deleteOrder(OrderInterface $order);

    /**
     * Finds one order by the given criteria.
     *
     * @param array $criteria
     *
     * @return OrderInterface
     */
    public function findOrderBy(array $criteria);

    /**
     * Find an order by its identifier.
     *
     * @param string $id
     *
     * @return OrderInterface or null if order does not exist
     */
    public function findOrderById($id);

    /**
     * Finds an order by its reference.
     *
     * @param string $reference
     *
     * @return OrderInterface or null if order does not exist
     */
    public function findOrderByReference($reference);

    /**
     * Finds an order by its id or reference.
     *
     * @param string $idOrReference
     *
     * @return OrderInterface or null if order does not exist
     */
    public function findOrderByIdOrReference($idOrReference);

    /**
     * Returns a collection with all order instances.
     *
     * @return \Traversable
     */
    public function findOrders();

    /**
     * Returns the order's fully qualified class name.
     *
     * @return string
     */
    public function getClass();

    /**
     * Reloads an order.
     *
     * @param OrderInterface $order
     *
     * @return void
     */
    public function reloadOrder(OrderInterface $order);

    /**
     * Updates an order.
     *
     * @param OrderInterface $order
     *
     * @return void
     */
    public function updateOrder(OrderInterface $order);

    /**
     * Updates an order.
     *
     * @param OrderInterface $order
     *
     * @return float
     */
    public function calculateOrderTotal(OrderInterface $order);

    /**
     * Calculates the items total value
     *
     * @param Collection|OrderItemInterface[] $items
     *
     * @return float
     */
    public function calculateItemsTotal(Collection $items);

    /**
     * Calculates the item total
     *
     * @param OrderItemInterface $item
     *
     * @return float
     */
    public function calculateItemTotal(OrderItemInterface $item);

    /**
     * Calculates the pricers total value
     *
     * @param Collection|PricerItemInterface[] $orderItem
     *
     * @return void
     */
    public function calculatePricersTotal(Collection $pricers);
}
