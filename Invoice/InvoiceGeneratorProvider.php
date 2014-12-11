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
 * Default Invoice generator provider
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
class InvoiceGeneratorProvider implements InvoiceGeneratorProviderInterface
{
    /**
     * @var array
     */
    protected $generators;

    /**
     * Constructor
     *
     * @param array $generators Initila generators set
     */
    public function __construct(array $generators = array())
    {
        $this->generators = $generators;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        return isset($this->generators[$name]) ? $this->generators[$name] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
        return isset($this->generators[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function register(InvoiceGeneratorInterface $generator)
    {
        $name = $generator->getName();
        unset($this->generators[$name]);

        $this->generators[$name] = $generator;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($name)
    {
        unset($this->generators[$name]);

        return $this;
    }
}
