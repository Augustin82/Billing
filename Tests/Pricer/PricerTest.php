<?php

/*
 * This file is part of the UCS package.
 *
 * (c) Nicolas Macherey <nicolas.macherey@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace UCS\Component\Billing\Tests\Pricer;

/* imports */
use UCS\Component\Billing\Pricer\Pricer;

/**
 * Unit Test Suite for Pricer
 *
 * @author Nicolas Macherey (nicolas.macherey@gmail.com)
 */
class PricerTest extends \PHPUnit_Framework_TestCase
{
    protected $instance;
    
    protected function setup() {
        $this->instance = new Pricer();
    }
    
    public function testId() {
        $this->assertNull($this->instance->getId());
    }
    
    public function testLabel() {
        $this->assertNull($this->instance->getLabel());

        $value = 'label';
        $this->instance->setLabel($value);
        $this->assertEquals($value, $this->instance->getLabel());
    }
    
    public function testDescription() {
        $this->assertNull($this->instance->getDescription());

        $value = 'description';
        $this->instance->setDescription($value);
        $this->assertEquals($value, $this->instance->getDescription());
    }
    
    public function testSubject() {
        $this->assertNull($this->instance->getSubject());

        $value = $this->getMock('UCS\Component\Billing\Pricer\PricerSubjectInterface');
        $this->instance->setSubject($value);
        $this->assertEquals($value, $this->instance->getSubject());
    }
    
    public function testAmount() {
        $this->assertEquals(0.0,$this->instance->getAmount());

        $value = 10.0;
        $this->instance->setAmount($value);
        $this->assertEquals($value, $this->instance->getAmount());
        $this->assertTrue($this->instance->isCredit());
        $this->assertFalse($this->instance->isCharge());

        $value = -10.0;
        $this->instance->setAmount($value);
        $this->assertFalse($this->instance->isCredit());
        $this->assertTrue($this->instance->isCharge());
    }
    
    public function testNeutral() {
        $this->assertFalse($this->instance->isNeutral());

        $value = true;
        $this->instance->setNeutral($value);
        $this->assertEquals($value, $this->instance->isNeutral());
    }
}
