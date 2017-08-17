<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Individual;

use Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual;
use Hashbangcode\Wevolution\Type\Style\Style;
use Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual;

/**
 * Test class for ColorIndividual
 */
class StyleIndividualTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateIndividual()
    {
        $object = StyleIndividual::generateFromSelector('.div');
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Style\Style', $object->getObject());
    }

    public function testCreateIndividualWithObject()
    {
        $style = new Style('.div');
        $object = new StyleIndividual($style);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Style\Style', $object->getObject());
    }

    public function testCliRender()
    {
        $object = StyleIndividual::generateFromSelector('.div');
        $renderType = 'cli';
        $this->assertEquals('.div{}' . PHP_EOL, $object->render($renderType));
    }

    public function testHtmlRender()
    {
        $object = StyleIndividual::generateFromSelector('.div');
        $renderType = 'html';
        $this->assertEquals('.div{}<br>', $object->render($renderType));
    }

    public function testDefaultRender()
    {
        $object = StyleIndividual::generateFromSelector('.div');
        $this->assertEquals('.div{}' . PHP_EOL, $object->render());
    }

    public function testGetFitness()
    {
        $object = StyleIndividual::generateFromSelector('.div');
        $this->assertEquals(1, $object->getFitness());
    }

    public function testSetProperties()
    {
        $object = StyleIndividual::generateFromSelector('.div');
        $object->getObject()->setAttribute('color', 'black');
        $this->assertContains('.div{color:black;}', $object->render());
    }

    public function testMutateStyle()
    {
        $object = StyleIndividual::generateFromSelector('.div');
        $object->getObject()->setAttribute('color', ColorIndividual::generateFromHex('000000'));

        $object->mutate(0, 50);

        $output = $object->render();

        $this->assertTrue(is_string($output));
    }
}
