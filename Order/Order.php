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
use UCS\Component\Billing\Pricer\PricerInterface;

/**
 * This class forces the bidirectionnal relation as it makes no sense to have
 * it unidirectionnal.
 * 
 * @author Nicolas Macherey (nicolas.macherey@gmail.com)
 */
class Order implements OrderInterface
{
    /**
     * Item id.
     *
     * @var mixed
     */
    protected $id;
    
    /**
     * @var OrderStateInterface
     */
    protected $state;
    
    /**
     * @var string
     */
    protected $reference;
    
    /**
     * @var boolean
     */
    protected $completed = false;
    
    /**
     * @var ArrayCollection
     */
    protected $items;
    
    /**
     * @var float
     */
    protected $totalPrice = 0.0;
    
    /**
     * @var float
     */
    protected $totalItemsAmount = 0.0;
    
    /**
     * @var float
     */
    protected $totalPricersAmount = 0.0;
    
    /**
     * Default Constructor
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
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
    public function getState()
    {
        return $this->state;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setState(OrderStateInterface $state)
    {
        $this->state = $state;
        return $this; 
    }
    
    /**
     * {@inheritdoc}
     */
    public function getReference()
    {
        return $this->reference;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this; 
    }
    
    /**
     * {@inheritdoc}
     */
    public function isCompleted()
    {
        return $this->completed;
    }
    
    /**
     * {@inheritdoc}
     */
    public function complete()
    {
        $this->completed = true;
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;
        return $this; 
    }
    
    /**
     * {@inheritdoc}
     */
    public function getItems()
    {
        return $this->items;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setItems(Collection $items)
    {
        $this->items = $items;
        return $this; 
    }
    
    /**
     * {@inheritdoc}
     */
    public function addItem(OrderItemInterface $item)
    {
        if ($this->hasItem($item)) {
            return $this;
        }
        
        foreach ($this->items as $existingItem) {
            if ($item->isEqualTo($existingItem)) {
                $existingItem->merge($item, false);
                return $this;
            }
        }
        
        $item->setOrder($this);
        $this->items->add($item);
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function removeItem(OrderItemInterface $item)
    {
        if ($this->hasItem($item)) {
            $item->setOrder(null);
            $this->items->removeElement($item);
        }

        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function hasItem(OrderItemInterface $item)
    {
        return $this->items->contains($item);
    }
    
    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return $this->count() == 0;
    }
    
    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->items->count();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return $this->items;
    }
    
    /**
     * {@inheritdoc}
     */
    public function clearItems()
    {
        $this->items->clear();
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTotalQuantity()
    {
        $quantity = 0;
        
        foreach ($this->items as $existingItem) {
            $quantity += $existingItem->getQuantity();
        }
        
        return $quantity;
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
    public function setTotalPrice($total)
    {
        $this->totalPrice = $total;
        return $this; 
    }
    
    /**
     * {@inheritdoc}
     */
    public function getItemsTotalPrice()
    {
        return $this->totalItemsAmount;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setItemsTotalPrice($total)
    {
        $this->totalItemsAmount = $total;
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
