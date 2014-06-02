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

/* Import */
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use UCS\Component\Billing\Order\Exception\CannotMergeOrderItemException;
use UCS\Component\Billing\Pricer\PricerSubjectInterface;
use UCS\Component\Billing\Pricer\PricerInterface;

/**
 * Default OrderItem implementation
 *
 * @author Nicolas Macherey (nicolas.macherey@gmail.com)
 */
class OrderItem implements OrderItemInterface
{
    /**
     * Item id.
     *
     * @var mixed
     */
    protected $id;
    
    /**
     * @var integer
     */
    protected $quantity = 0;
    
    /**
     * @var float
     */
    protected $unitPrice = 0.0;
    
    /**
     * @var float
     */
    protected $totalPrice = 0.0;
    
    /**
     * @var float
     */
    protected $totalPricersAmount = 0.0;
    
    /**
     * Pricers
     *
     * @var Collection|PricerInterface[]
     */
    protected $pricers;
    
    /**
     * @var OrderInterface
     */
    protected $order;
    
    /**
     * Default Constructor
     */
    public function __construct()
    {
        $this->pricers = new ArrayCollection();
    }
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return $this->order;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setOrder(OrderInterface $order = null)
    {
        $this->order = $order;
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function isEqualTo(OrderItemInterface $orderItem)
    {
        return $this === $orderItem;
    }
    
    /**
     * {@inheritdoc}
     */
    public function merge(OrderItemInterface $orderItem)
    {
        if (!$orderItem->isEqualTo($this)) {
            throw new CannotMergeOrderItemException('Given items are not equals, they cannot be merged');
        }
        
        $this->quantity += $orderItem->getQuantity();
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPricers()
    {
        return $this->pricers;
    }
    
    /**
     * {@inheritdoc}
     */
    public function addPricer(PricerInterface $pricer)
    {
        if( !$this->hasPricer($pricer) ) 
        {
            $pricer->setSubject($this);
            $this->pricers->add($pricer);
        }
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removePricer(PricerInterface $pricer)
    {
        if( $this->hasPricer($pricer) ) 
        {
            $pricer->setSubject(null);
            $this->pricers->removeElement($pricer);
        }
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasPricer(PricerInterface $pricer)
    {
        return $this->pricers->contains($pricer);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTotalPricersAmount()
    {
        return $this->totalPricersAmount;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setTotalPricersAmount($amount)
    {
        $this->totalPricersAmount = $amount;
    }
    
    /**
     * {@inheritdoc}
     */
    public function clearPricers()
    {
        $this->pricers->clear();
        
        return $this;
    }
}
