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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use UCS\Component\Referenceable\ReferenceableInterface;
use UCS\Component\Billing\Pricer\PricerSubjectInterface;

/**
 * Order Interface Representation, the interface implements the \Countable
 * interface so that it should return in count the total number of items. 
 *
 * It also must implements the \IteratorAggregate interface so that you can 
 * easily iterate over order items.
 * 
 * @author Nicolas Macherey (nicolas.macherey@gmail.com)
 */
interface OrderInterface extends PricerSubjectInterface, ReferenceableInterface, \Countable, \IteratorAggregate
{
    /**
     * Get the order state
     * 
     * @return OrderStateInterface
     */
    public function getState();
    
    /**
     * Set the order state
     *
     * @param OrderStateInterface $orderState
     *
     * @return OrderInterface
     */
    public function setState(OrderStateInterface $state);
    
    /**
     * Check wheather the order has been completed or not
     *
     * @return Boolean
     */
    public function isCompleted();

    /**
     * Mark the order as completed.
     *
     * @return OrderInterface
     */
    public function complete();
    
    /**
     * Get order items
     *
     * @return Collection|OrderItemInterface[] An array or collection of 
     *    OrderItemInterface
     */
    public function getItems();

    /**
     * Set items
     *
     * @param Collection|OrderItemInterface[] $items
     *
     * @return OrderInterface
     */
    public function setItems(Collection $items);

    /**
     * Add one item to the order
     *
     * @param OrderItemInterface $item
     */
    public function addItem(OrderItemInterface $item);

    /**
     * Remove the given item
     *
     * @param OrderItemInterface $item
     *
     * @return OrderInterface
     */
    public function removeItem(OrderItemInterface $item);

    /**
     * Check if the item exists in the order
     *
     * @param OrderItemInterface $item
     *
     * @return Boolean
     */
    public function hasItem(OrderItemInterface $item);
    
    /**
     * Checks whether the order is empty or not
     *
     * @return Boolean
     */
    public function isEmpty();

    /**
     * Clears all items
     */
    public function clearItems();
    
    /**
     * Returns total quantity of items, i.e sums all items quantities and
     * returns the value.
     *
     * @return integer
     */
    public function getTotalQuantity();
    
    /**
     * Get order total. 
     * Items Price + adjustments
     *
     * @return float
     */
    public function getTotalPrice();

    /**
     * Set total.
     * Items Price + adjustments
     *
     * @param float $total
     */
    public function setTotalPrice($total);
    
    /**
     * Get items total.
     * Sums all items prices
     *
     * @return float
     */
    public function getItemsTotalPrice();

    /**
     * Set items total price. This should be the price without promotions
     * or adjustments and so on...
     *
     * @param float $total
     */
    public function setItemsTotalPrice($total);
}
