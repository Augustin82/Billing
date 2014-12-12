<?php

/*
 * This file is part of the UCS package.
 *
 * (c) Nicolas Macherey <nicolas.macherey@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace UCS\Component\Billing\Tests\Order;

/* imports */
use UCS\Component\Billing\Invoice\InvoiceGeneratorChain;

/**
 * InvoiceGeneratorChain
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
class InvoiceGeneratorChainTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InvoiceGeneratorChain
     */
    private $instance;

    /**
     * {@inheritdoc}
     */
    protected function setup()
    {
        $this->instance = new InvoiceGeneratorChain();
    }

    /**
     * Test the generation process
     */
    public function testGenerate()
    {
        // add generators
        $this->instance
            ->register($foo = $this->getMockGenerator('foo'))
            ->register($bar = $this->getMockGenerator('bar'));

        $foo->expects($this->once())
            ->method('generate');

        $bar->expects($this->once())
            ->method('generate');

        $this->instance->generate(
            $this->getMock('UCS\Component\Billing\Order\OrderInterface')
        );
    }

    private function getMockGenerator($name)
    {
        $generator = $this->getMock('UCS\Component\Billing\Invoice\InvoiceGeneratorInterface');

        $generator->expects($this->any())
            ->method('getName')
            ->will($this->returnValue($name));

        return $generator;
    }
}