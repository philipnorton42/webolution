<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Test\Evolution\Population\Decorators\StylePopulationDecoratorTestBase;
use Hashbangcode\Wevolution\Evolution\Population\Decorators\StylePopulationDecoratorHtml;
use Prophecy\Prophet;

class StylePopulationDecoratorHtmlTest extends StylePopulationDecoratorTestBase
{
    public function testStatisticsObjectCreation()
    {
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Population\StylePopulation');
        $numberPopulationDecorator = new StylePopulationDecoratorHtml($numberPopulation->reveal());
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Population\Decorators\StylePopulationDecoratorHtml', $numberPopulationDecorator);
    }

    public function testRender()
    {
        $numberPopulationDecorator = new StylePopulationDecoratorHtml($this->textPopulation->reveal());
        $render = $numberPopulationDecorator->render();
        $this->assertEquals('div{color:red;}p{color:red;}div.test{color:red;}', $render);
    }
}