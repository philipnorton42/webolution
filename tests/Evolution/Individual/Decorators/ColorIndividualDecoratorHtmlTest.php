<?php

namespace Hashbangcode\Webolution\Test\Evolution\Individual\Decorators;

use Hashbangcode\Webolution\Evolution\Individual\Decorators\ColorIndividualDecoratorHtml;
use Prophecy\Prophet;

class ColorIndividualDecoratorHtmlTest extends \PHPUnit_Framework_TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testObjectCreation()
    {
        $individual = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Individual\ColorIndividual');
        $individualDecorator = new ColorIndividualDecoratorHtml($individual->reveal());
        $this->assertInstanceOf('\Hashbangcode\Webolution\Evolution\Individual\Decorators\ColorIndividualDecoratorHtml', $individualDecorator);
    }

    public function testRender()
    {
        $object = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Color\Color');
        $object->getHex()->willReturn('000');
        $objectIndividual = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Individual\ColorIndividual');
        $objectIndividual->getObject()->willReturn($object);

        $objectIndividualDecorator = new ColorIndividualDecoratorHtml($objectIndividual->reveal());
        $render = $objectIndividualDecorator->render();
        $this->assertEquals('<span style="background-color:#000"> </span>', $render);
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
