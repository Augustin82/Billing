<?php

/*
 * This file is part of the UCS package.
 *
 * Copyright 2014 Nicolas Macherey (nicolas.macherey@gmail.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace UCS\Component\Billing\Pricer;

/**
 * Default Pricer Implementation
 *
 * @author Nicolas Macherey (nicolas.macherey@gmail.com)
 */
class Pricer implements PricerInterface
{
    /**
     * @var mixed
     */
    protected $id;

    /**
     * Subject
     *
     * @var PricerSubjectInterface
     */
    protected $subject;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var float
     */
    protected $amount = 0.0;

    /**
     * Should it modify the order total?
     *
     * @var Boolean
     */
    protected $neutral = false;

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
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubject(PricerSubjectInterface $subject = null)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * {@inheritdoc}
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * {@inheritdoc}
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isNeutral()
    {
        return $this->neutral;
    }

    /**
     * {@inheritdoc}
     */
    public function setNeutral($neutral)
    {
        $this->neutral = $neutral;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isCharge()
    {
        return ($this->amount < 0);
    }

    /**
     * {@inheritdoc}
     */
    public function isCredit()
    {
        return ($this->amount > 0);
    }
}
