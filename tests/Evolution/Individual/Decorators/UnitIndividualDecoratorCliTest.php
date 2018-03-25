<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\UnitIndividualDecoratorCli;
use Prophecy\Prophet;

class UnitIndividualDecoratorCliTest extends \PHPUnit_Framework_TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\UnitIndividual');
        $individualDecorator = new UnitIndividualDecoratorCli($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Individual\Decorators\UnitIndividualDecoratorCli', $individualDecorator);
    }

    public function testRender()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Unit\Unit');
        $object->getUnit()->willReturn('px');
        $object->getNumber()->willReturn('1');

        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\UnitIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $individualDecorator = new UnitIndividualDecoratorCli($objectIndividual->reveal());
        $render = $individualDecorator->render();
        $this->assertEquals('1px', $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}