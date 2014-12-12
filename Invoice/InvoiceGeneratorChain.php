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
 * Generator chain that allows to generate once more than one generator
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
class InvoiceGeneratorChain extends InvoiceGeneratorProvider implements InvoiceGeneratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'invoice_generator_chain';
    }

    /**
     * {@inheritdoc}
     */
    public function generate(OrderInterface $order)
    {
        foreach ($this->generators as $name => $generator) {
            $generator->generate($order);
        }

        return $this;
    }
}
