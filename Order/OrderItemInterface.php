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
use UCS\Component\Billing\Pricer\PricerSubjectInterface;

/**
 * Order Item interface main class you have to override to build your customer
 * orders.
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
interface OrderItemInterface extends PricerSubjectInterface, OrderAwareInterface, EquatableInterface, MergeableInterface
{
    /**
     * Get item quantity.
     *
     * @return integer
     */
    public function getQuantity();

    /**
     * Set quantity.
     *
     * @param integer $quantity
     */
    public function setQuantity($quantity);

    /**
     * Get unit price of item.
     *
     * @return float
     */
    public function getUnitPrice();

    /**
     * Define the unit price of item.
     *
     * @param float $unitPrice
     */
    public function setUnitPrice($unitPrice);

    /**
     * Get item total price.
     *
     * @return float
     */
    public function getTotalPrice();

    /**
     * Set item total price.
     *
     * @param float $totalPrice
     */
    public function setTotalPrice($totalPrice);
}
