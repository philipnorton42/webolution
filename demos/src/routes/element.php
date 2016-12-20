<?php

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\ElementPopulation;
use Hashbangcode\Wevolution\Type\Element\Element;
use Hashbangcode\Wevolution\Evolution\EvolutionStorage;
use Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual;

$app->get('/element_creation_test', function ($request, $response, $args) {
  $styles = 'div {width:10px;height:10px;display:inline-block;padding:0px;margin:0px;}';

  $title = 'Element Creation Test';

  $population = new ElementPopulation();

  $html = new Element('html');
  $body = new Element('body');
  $div = new Element('div');
  $p1 = new Element('p');
  $p2 = new Element('p');
  $p3 = new Element('p');

  $div->addChild($p1);
  $div->addChild($p2);
  $div->addChild($p3);
  $body->addChild($div);
  $html->addChild($body);

  $element_individual = new ElementIndividual($html);

  $population->addIndividual($element_individual);

  $output = '';

  $population->setDefaultRenderType('htmltextarea');
  $output .= $population->render();

  $population->setDefaultRenderType('html');
  $output .= $population->render();

  return $this->view->render($response, 'demos.twig', [
    'title' => $title,
    'output' => $output,
    'styles' => $styles
  ]);
});

$app->get('/element_evolution', function ($request, $response, $args) {
  $styles = 'div {width:10px;height:10px;display:inline-block;padding:0px;margin:0px;}';

  $title = 'Element Evolution Test';

  $population = new ElementPopulation();
  $element = new ElementIndividual('html');
  $element->getObject()->addChild(new Element('body'));
  $population->addIndividual($element);
  $population->addIndividual(clone $element);
  $population->addIndividual(clone $element);
  $population->addIndividual(clone $element);
  $population->addIndividual(clone $element);
  $population->addIndividual(clone $element);
  $population->addIndividual(clone $element);
  $population->addIndividual(clone $element);

  $population->setDefaultRenderType('html');
  $population->setDefaultRenderType('htmltextarea');

  $evolution = new Evolution($population);
  $evolution->setIndividualsPerGeneration(10);
  $evolution->setMaxGenerations(5);
//  $evolution->setGlobalMutationFactor(1);

  for ($i = 0; $i < $evolution->getMaxGenerations(); ++$i) {
    if ($evolution->runGeneration() === FALSE) {
      print '<p>Everyone is dead.</p>';
      break;
    }
  }

  $output = '';
  $output .= $evolution->renderGenerations();

  return $this->view->render($response, 'demos.twig', [
    'title' => $title,
    'output' => $output,
    'styles' => $styles
  ]);
});

$app->get('/element_evolution_storage', function ($request, $response, $args) {
  $styles = 'div {width:10px;height:10px;display:inline-block;padding:0px;margin:0px;}';

  $title = 'Element Evolution Storage Test';

  $database = realpath(__DIR__ . '/../../database') . '/database.sqlite';
  $evolution = new EvolutionStorage();

  $evolution->setEvolutionId(2);

  $evolution->setupDatabase('sqlite:' . $database);

  $evolution->setIndividualsPerGeneration(200);
  $evolution->setGlobalMutationFactor(0.1);

  $generation = $evolution->getGeneration();

  $population = new ElementPopulation();
  $population->setDefaultRenderType('html');

  if ($generation == 1) {
    $population->addIndividual();
    $evolution->setPopulation($population);
  } else {
    $evolution->setPopulation($population);
    $evolution->loadPopulation();
  }

  $evolution->runGeneration();

  $output = '';

  $output .= '<p>Generation: ' . $evolution->getGeneration() . '</p>';

  $output .= nl2br($evolution->renderGenerations());

  return $this->view->render($response, 'demos.twig', [
    'title' => $title,
    'output' => $output,
    'styles' => $styles
  ]);
});