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

/**
 * Simple class that can be linked to a order
 *
 * @author Nicolas Macherey (nicolas.macherey@gmail.com)
 */
interface OrderAwareInterface
{
    /**
     * @return OrderInterface
     */
    public function getOrder();
    
    /**
     * @param OrderInterface $order
     */
    public function setOrder(OrderInterface $order = null);
}
