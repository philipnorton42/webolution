<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual;

use Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual;

/**
 * Test class for ColorIndividual
 */
class NumberIndividualTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateIndividual()
    {
        $object = new NumberIndividual(1);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Number\Number', $object->getObject());
    }

    public function testMutateNumberThroughIndividual()
    {
        $object = new NumberIndividual(1);
        $object->mutate(0, 1);
        $this->assertNotEquals(1, $object->getObject()->getNumber());
    }

    public function testMutateNumberThroughIndividualWithDifferentAmount()
    {
        $object = new NumberIndividual(1);
        $object->mutate(0, 1);
        $this->assertNotEquals(1, $object->getObject()->getNumber());
    }

    public function testGetFitness()
    {
        $object = new NumberIndividual(1);
        $this->assertEquals(1, $object->getFitness());
        $object->getObject()->setNumber(8);
        $this->assertEquals(8, $object->getFitness());
    }

    public function testCliRender()
    {
        $object = new NumberIndividual(1);
        $renderType = 'cli';
        $this->assertEquals('1 ', $object->render($renderType));
    }

    public function testHtmlRender()
    {
        $object = new NumberIndividual(1);
        $renderType = 'html';
        $this->assertEquals('1 ', $object->render($renderType));
    }

    public function testDefaultRender()
    {
        $object = new NumberIndividual(1);
        $this->assertEquals('1 ', $object->render());
    }

    public function testMutateNumber()
    {
        $object = new NumberIndividual(1);
        $this->assertEquals(1, $object->getObject()->getNumber());
        $object->mutate();
        $this->assertNotEquals(1, $object->getObject()->getNumber());
    }

    public function testMutateZeroNumber()
    {
        $object = new NumberIndividual(1);
        $this->assertEquals(1, $object->getObject()->getNumber());
        $object->mutate(0, 0);
        $this->assertEquals(1, $object->getObject()->getNumber());
        $object->mutate(0, 0);
        $this->assertEquals(1, $object->getObject()->getNumber());
        $object->mutate(0, 0);
        $this->assertEquals(1, $object->getObject()->getNumber());
        $object->mutate(0, 0);
        $this->assertEquals(1, $object->getObject()->getNumber());
    }
}
