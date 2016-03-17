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
 * Pricer Subjects contains Pricers
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
interface PricerSubjectInterface
{
    /**
     * Return all pricers attached to the subject
     *
     * @return Collection|PricerInterface[]
     */
    public function getPricers();

    /**
     * Add pricer
     *
     * @param PricerInterface $pricer
     *
     * @return self
     */
    public function addPricer(PricerInterface $pricer);

    /**
     * Remove pricer
     *
     * @param PricerInterface $pricer
     *
     * @return self
     */
    public function removePricer(PricerInterface $pricer);

    /**
     * Check if the given pricer exists
     *
     * @param PricerInterface $pricer
     *
     * @return boolean
     */
    public function hasPricer(PricerInterface $pricer);

    /**
     * Get pricers total
     *
     * @return float
     */
    public function getTotalPricersAmount();

    /**
     * Set pricers total
     *
     * @param float $amount
     *
     * @return self
     */
    public function setTotalPricersAmount($amount);

    /**
     * Clears all pricers
     */
    public function clearPricers();
}
