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

/**
 * Register and provides invoice generators
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
interface InvoiceGeneratorProviderInterface
{
    /**
     * @param string $name
     * 
     * @return InvoiceGeneratorInterface|null
     */
    public function get($name);

    /**
     * @param string $name
     *
     * @return boolean weather the generator exists or not
     */
    public function has($name);

    /**
     * Register an invoice generator
     *
     * @param InvoiceGeneratorInterface $generator
     *
     * @return self
     */
    public function register(InvoiceGeneratorInterface $generator);

    /**
     * @param string $name
     *
     * @return self
     */
    public function remove($name);
}
