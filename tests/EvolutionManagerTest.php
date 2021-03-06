<?php

namespace Hashbangcode\Webolution\Test;

use Hashbangcode\Webolution\Evolution;
use Hashbangcode\Webolution\EvolutionManager;
use Hashbangcode\Webolution\Type\Number\NumberPopulation;
use PHPUnit\Framework\TestCase;

class EvolutionManagerTest extends TestCase
{
    public function testCreateObject()
    {
        $object = new EvolutionManager();
        $this->assertInstanceOf('Hashbangcode\Webolution\Evolution', $object->getEvolutionObject());
    }

    public function testSetEvolutionOption()
    {
        $object = new EvolutionManager();
        $object->getEvolutionObject()->setMaxGenerations(10);
        $this->assertEquals(10, $object->getEvolutionObject()->getMaxGenerations());
    }

    public function testSetupEvolution()
    {
        $object = new EvolutionManager();
        $object->setUpEvolution(10);
        $this->assertEquals(10, $object->getEvolutionObject()->getIndividualsPerGeneration());
    }

    public function testRunEmptyEvolution()
    {
        $object = new EvolutionManager();
        $message = 'No population object exists in evolution class.';

        $this->expectException('Hashbangcode\Webolution\Exception\NoPopulationException');
        $this->expectExceptionMessage($message);

        $object->runEvolution();
    }

    public function testRunEvolution()
    {
        $object = new EvolutionManager();
        $population = new NumberPopulation();
        $population->addIndividual();
        $object->getEvolutionObject()->setPopulation($population);

        $this->assertEquals(1, $object->getEvolutionObject()->getGeneration());

        $object->runEvolution();
        $this->assertEquals(30, $object->getEvolutionObject()->getGeneration());
    }

    public function testRunEmptyPopulation()
    {
        $object = new EvolutionManager();
        $population = new NumberPopulation();
        $object->getEvolutionObject()->setPopulation($population);
        $object->runEvolution();
        $this->assertEquals(30, $object->getEvolutionObject()->getGeneration());
    }

    public function testSetEvolutionObject()
    {
        $evolution = new Evolution();
        $object = new EvolutionManager($evolution);
        $this->assertInstanceOf(Evolution::class, $object->getEvolutionObject());
    }
}
