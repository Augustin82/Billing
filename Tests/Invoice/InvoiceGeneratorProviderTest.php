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
use UCS\Component\Billing\Invoice\InvoiceGeneratorProvider;

/**
 * InvoiceGeneratorProvider
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
class InvoiceGeneratorProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InvoiceGeneratorProvider
     */
    private $instance;

    /**
     * {@inheritdoc}
     */
    protected function setup()
    {
        $this->instance = new InvoiceGeneratorProvider();
    }

    /**
     * Test Register
     */
    public function testRegister()
    {
        // Check that the method return null il foo is not defined
        $this->assertNull($this->instance->get('foo'));

        // add generators
        $this->instance
            ->register($foo = $this->getMockGenerator('foo'))
            ->register($bar = $this->getMockGenerator('bar'));

        $this->assertEquals($foo, $this->instance->get('foo'));
        $this->assertEquals($bar, $this->instance->get('bar'));
        $this->assertNull($this->instance->get('moo'));
    }

    /**
     * Test Register
     */
    public function testRemove()
    {
        // add generators
        $this->instance
            ->register($foo = $this->getMockGenerator('foo'))
            ->register($bar = $this->getMockGenerator('bar'));

        $this->assertEquals($foo, $this->instance->get('foo'));
        $this->instance->remove('foo');
        $this->assertEquals($bar, $this->instance->get('bar'));
        $this->assertNull($this->instance->get('foo'));
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