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
 * Main interface that represent an order state, states can be the following:
 *
 * + 'cart'
 * + 'cart_locked'
 * + 'pending'
 * + 'confirmed'
 * + 'shipped'
 * + 'abandoned'
 * + 'cancelled'
 * + 'returned'
 *
 * This class has been made to control the order state workflow.
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
class OrderState implements OrderStateInterface
{
    /**
     * @®ar integer
     */
    protected $id;

    /**
     * @®ar string
     */
    protected $name;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->name,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        list(
            $this->id,
            $this->name,
        ) = $data;
    }
}
