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

/**
 * EquatableInterface used to test if two objects are equal in order management
 * system
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
interface EquatableInterface
{
    /**
     * The equality comparison should neither be done by referential equality
     * nor by comparing identities (i.e. getId() === getId()).
     *
     * However, you do not need to compare every attribute, but only those that
     * are relevant for assessing whether two order items are equals or not.
     *
     * @param OrderItemInterface $orderItem
     *
     * @return Boolean
     */
    public function isEqualTo(OrderItemInterface $orderItem);
}
