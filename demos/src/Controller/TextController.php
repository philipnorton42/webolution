<?php

namespace Hashbangcode\Wevolution\Demos\Controller;

use Hashbangcode\Wevolution\Demos\Controller\BaseController;
use Slim\Http\Request;
use Slim\Http\Response;
use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\TextPopulation;
use Hashbangcode\Wevolution\Evolution\Individual\TextIndividual;

class TextController extends BaseController
{

    public function textEvolution(Request $request, Response $response, $args)
    {
        $title = 'Text Evolution Test';

        $population = new TextPopulation();
        $population->setDefaultRenderType('html');

        $goal = 'Monkey say monkey do';

        for ($i = 0; $i < 10; $i++) {
            $population->addIndividual(TextIndividual::generateRandomTextIndividual(strlen($goal)));
        }

        $evolution = new Evolution($population);
        $evolution->setGlobalFitnessGoal($goal);
        $evolution->setIndividualsPerGeneration(10);
        $evolution->setMaxGenerations(1000);
        $evolution->setGlobalMutationFactor(100);

        $output = '';

        for ($i = 0; $i < $evolution->getMaxGenerations(); ++$i) {
            if ($evolution->runGeneration() === false) {
                print '<p>Everyone is dead.</p>';
                break;
            }
        }

        $output .= $evolution->renderGenerations();

        return $this->view->render($response, 'demos.twig', [
            'title' => $title,
            'output' => $output
        ]);
    }

    public function textEvolutionLength(Request $request, Response $response, $args)
    {
        $title = 'Text Evolution Test With Different Length Goal';

        $population = new TextPopulation();
        $population->setDefaultRenderType('html');

        $goal = 'monkey';

        for ($i = 0; $i < 10; $i++) {
            $population->addIndividual(TextIndividual::generateRandomTextIndividual(15));
        }

        $evolution = new Evolution($population);
        $evolution->setGlobalFitnessGoal($goal);
        $evolution->setIndividualsPerGeneration(10);
        $evolution->setMaxGenerations(1000);
        $evolution->setGlobalMutationFactor(100);

        $output = '';

        for ($i = 0; $i < $evolution->getMaxGenerations(); ++$i) {
            if ($evolution->runGeneration() === false) {
                print '<p>Everyone is dead.</p>';
                break;
            }
        }

        $output .= $evolution->renderGenerations();

        return $this->view->render($response, 'demos.twig', [
            'title' => $title,
            'output' => $output
        ]);
    }

}