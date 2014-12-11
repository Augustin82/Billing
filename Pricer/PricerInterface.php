<?php

/*
 * This file is part of the UCS package.
 *
 * Copyright 2014 Nicolas Macherey <nicolas.macherey@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace UCS\Component\Billing\Pricer;

/**
 * Define an item that contains either a debit or a credit. Pricers are used
 * to adjust orders/orer items accordingly
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
interface PricerInterface
{
    /**
     * Get pricer subject
     *
     * @return PricerSubjectInterface
     */
    public function getSubject();

    /**
     * Set subject
     *
     * @param PricerSubjectInterface|null $subject
     */
    public function setSubject(PricerSubjectInterface $subject = null);

    /**
     * Get the label
     *
     * @return string
     */
    public function getLabel();

    /**
     * Set label
     *
     * @param string $label
     */
    public function setLabel($label);

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description);

    /**
     * Get the amount
     *
     * @return float
     */
    public function getAmount();

    /**
     * Set the amount
     *
     * @param float $amount
     */
    public function setAmount($amount);

    /**
     * @return Boolean
     */
    public function isNeutral();

    /**
     * @param Boolean $neutral
     *
     * @return PricerInterface
     */
    public function setNeutral($neutral);

    /**
     * Is charge?
     *
     * Pricers with amount < 0 are called "charges".
     *
     * @return Boolean
     */
    public function isCharge();

    /**
     * Is credit?
     *
     * Pricers with amount > 0 are called "credits".
     *
     * @return Boolean
     */
    public function isCredit();
}
