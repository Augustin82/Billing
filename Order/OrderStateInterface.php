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
 * Main interface that represent an order state
 *
 * @author Nicolas Macherey (nicolas.macherey@gmail.com)
 */
interface OrderStateInterface extends \Serializable
{
    /**
     * @return string
     */
    public function getName();
    
    /**
     * @param string
     */
    public function setName($name);
}
