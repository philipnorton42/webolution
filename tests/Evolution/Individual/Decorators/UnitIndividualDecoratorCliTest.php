<?php

namespace Hashbangcode\Webolution\Test\Evolution\Individual\Decorators;

use Hashbangcode\Webolution\Evolution\Individual\Decorators\UnitIndividualDecoratorCli;
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
        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Individual\UnitIndividual');
        $individualDecorator = new UnitIndividualDecoratorCli($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Evolution\Individual\Decorators\UnitIndividualDecoratorCli', $individualDecorator);
    }

    /**
     * @dataProvider unitRenderDataProvider
     */
    public function testRender($number, $unit, $expectedRender)
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Unit\Unit');
        $object->getUnit()->willReturn($unit);
        $object->getNumber()->willReturn($number);

        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Individual\UnitIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $individualDecorator = new UnitIndividualDecoratorCli($objectIndividual->reveal());
        $render = $individualDecorator->render();
        $this->assertEquals($expectedRender, $render);
    }

    public function unitRenderDataProvider()
    {
        return [
            [1, 'px', '1px'],
            [50, 'px', '50px'],
            [-1, 'px', '-1px'],
            [1, 'em', '1em'],
            [100, 'em', '100em'],
            [1, '%', '1%'],
            [123, '%', '123%'],
            [1, 'auto', 'auto'],
        ];
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
