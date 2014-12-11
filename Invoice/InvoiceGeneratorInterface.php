<?php

/*
 * This file is part of the UCS package.
 *
 * Copyright 2014 Nicolas Macherey <nicolas.macherey@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace UCS\Component\Billing\Invoice;

/* Imports */
use UCS\Component\Billing\Order\OrderInterface;

/**
 * Generator 
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
interface InvoiceGeneratorInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * Generate invoice
     *
     * @param OrderInterface $order
     */
    public function generate(OrderInterface $order);
}
