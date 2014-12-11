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
 * Mergeable used to merge two order items
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
interface MergeableInterface
{
    /**
     * Merging should be done when two order items are equals. This method
     * should take this into consideration.
     *
     * @param OrderItemInterface $orderItem
     *
     * @return Boolean
     */
    public function merge(OrderItemInterface $orderItem);
}
