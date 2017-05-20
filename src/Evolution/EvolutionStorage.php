<?php

namespace Hashbangcode\Wevolution\Evolution;

use Hashbangcode\Wevolution\Evolution\Population;

/**
 * Class EvolutionStorage.
 *
 * @package Hashbangcode\Wevolution\Evolution
 */
class EvolutionStorage extends Evolution
{
    /**
     * The filename of the database.
     *
     * @var string
     */
    protected $databaseName = 'sqlite:database.sqlite';

    /**
     * The database connection.
     *
     * @var resource
     */
    protected $database;

    /**
     * The evolution id.
     *
     * @var null
     */
    protected $evolutionId = null;

    /**
     * EvolutionStorage constructor.
     *
     * @param Population\Population|null $population
     *   The population object to get things running.
     * @param int $maxGenerations
     *   The maximum number of generations.
     * @param null $individualsPerGeneration
     *   The minimal number of individuals per generation.
     * @param bool $autoGeneratePopulation
     *   Whether to autopopulate the population.
     */
    public function __construct(Population\Population $population = null, $maxGenerations = null, $individualsPerGeneration = null, $autoGeneratePopulation = false)
    {
        parent::__construct($population, $maxGenerations, $individualsPerGeneration, $autoGeneratePopulation);
    }

    /**
     * Set up the database.
     *
     * @param string $databaseName
     *   The database name.
     */
    public function setupDatabase($databaseName)
    {
        $this->setDatabaseName($databaseName);

        $createDatabase = false;

        if (!file_exists(str_replace('sqlite:', '', $this->databaseName))) {
            $createDatabase = true;
        }

        $this->database = new \PDO($this->getDatabaseName(), '', '', array(\PDO::ATTR_PERSISTENT => false));

        if ($createDatabase == true) {
            $this->createDatabase();
        }

        $sql = "SELECT count(1) AS evolution_count FROM evolution WHERE evolution_id = :evolution_id";
        $stmt = $this->database->prepare($sql);

        $stmt->execute(
            array(
                'evolution_id' => $this->getEvolutionId()
            )
        );

        $evolution_count = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Get or create the evolution item
        if ($evolution_count['evolution_count'] == 0) {
            $this->createEvolution($this->getEvolutionId());
        } else {
            $evolution = $this->retrieveEvolution($this->getEvolutionId());
            $this->generation = (int)$evolution['current_generation'];
        }
    }

    /**
     * Get the database name.
     *
     * @return string
     *   The database name.
     */
    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    /**
     * Set the database name.
     *
     * @param string $databaseName
     *   The database name.
     */
    public function setDatabaseName($databaseName)
    {
        $this->databaseName = $databaseName;
    }

    /**
     * Create the database.
     */
    private function createDatabase()
    {
        $sql = 'DROP TABLE IF EXISTS "evolution";
CREATE TABLE "evolution" (
  "evolution_id" integer NOT NULL,
  "current_generation" integer NOT NULL
);

DROP TABLE IF EXISTS "individuals";
CREATE TABLE "individuals" (
  "individual_id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "evolution_id" integer NOT NULL,
  "population_id" integer NOT NULL,
  "individual" blob NOT NULL
);

DROP TABLE IF EXISTS "populations";
CREATE TABLE "populations" (
  "population_id" integer NOT NULL PRIMARY KEY,
  "evolution_id" integer NOT NULL,
  "max_fitness" real NULL,
  "min_fitness" real NULL
);';
        $this->database->exec($sql);
    }

    /**
     * Get the evolution id.
     *
     * @return int
     *   The evolution id.
     */
    public function getEvolutionId()
    {
        if (!is_null($this->evolutionId)) {
            return $this->evolutionId;
        }

        $sql = "SELECT MAX(evolution_id) + 1 AS max_evolution_id FROM evolution";
        $maxEvolutionId = $this->database->query($sql)->fetchColumn();

        if (is_null($maxEvolutionId)) {
            $maxEvolutionId = 1;
        }

        $this->evolutionId = $maxEvolutionId;
        return $this->evolutionId;
    }

    /**
     * Set the evolution id.
     *
     * @param int $evolutionId
     *   The evolution id.
     */
    public function setEvolutionId($evolutionId)
    {
        $this->evolutionId = $evolutionId;
    }

    /**
     * Create the evolution setup.
     *
     * @param int $evolution_id
     *   The evolution ID to create.
     */
    private function createEvolution($evolution_id)
    {
        $sql = "INSERT INTO evolution(evolution_id, current_generation) VALUES(:evolution_id, 1)";
        $query = $this->database->prepare($sql);
        $query->execute(array('evolution_id' => $evolution_id));
    }

    /**
     * Get the evolution setup.
     *
     * @param int $evolution_id
     *   The evolution setup.
     *
     * @return array
     *   The evolution setup.
     */
    private function retrieveEvolution($evolution_id)
    {
        $sql = "SELECT * FROM evolution WHERE evolution_id = :evolution_id";

        $stmt = $this->database->prepare($sql);

        if ($stmt == false) {
            return false;
        }

        $stmt->execute(
            array(
                'evolution_id' => $evolution_id
            )
        );

        $evolution = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $evolution;
    }

    /**
     * {@inheritdoc}
     */
    public function runGeneration($kill = true)
    {
        parent::runGeneration($kill);

        // Increment generation in database.
        $sql = 'UPDATE evolution SET current_generation = :current_generation WHERE evolution_id = :evolution_id';
        $query = $this->database->prepare($sql);
        $query->execute(
            array(
                'current_generation' => $this->getGeneration(),
                'evolution_id' => $this->getEvolutionId(),
            )
        );

        // Save the current generation to a database.
        $this->storeGeneration($this->getCurrentPopulation());
    }

    /**
     * Store the generation.
     *
     * @param Population\Population $population
     *   Store the population object in the database.
     */
    public function storeGeneration($population)
    {
        $sql = 'INSERT INTO populations(population_id, evolution_id) VALUES (:population_id, :evolution_id)';
        $query = $this->database->prepare($sql);
        $query->execute(
            array(
                'population_id' => $this->getGeneration(),
                'evolution_id' => $this->getEvolutionId(),
            )
        );

        foreach ($population->getIndividuals() as $individual) {
            $serializedIndividual = serialize($individual);

            $sql = 'INSERT INTO individuals(evolution_id, population_id, individual) ';
            $sql .= 'VALUES (:evolution_id, :population_id, :individual)';
            $query = $this->database->prepare($sql);

            $query->execute(
                array(
                    'population_id' => $this->getGeneration(),
                    'evolution_id' => $this->getEvolutionId(),
                    'individual' => $serializedIndividual,
                )
            );
        }
    }

    /**
     * Set the population.
     *
     * This also stores the population.
     *
     * @param Population\Population $population
     *   The population.
     */
    public function setPopulation($population)
    {
        $this->population = $population;

        $this->storeGeneration($this->population);
    }

    /**
     * Load a population from the database into the Evolution object.
     */
    public function loadPopulation()
    {
        $sql = "SELECT * FROM individuals WHERE evolution_id = :evolution_id AND population_id = :population_id";

        $stmt = $this->database->prepare($sql);

        if ($stmt == false) {
            return false;
        }

        $stmt->execute(
            array(
                'evolution_id' => $this->getEvolutionId(),
                'population_id' => $this->getGeneration(),
            )
        );
        $population_data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($population_data as $key => $individual_data) {
            $individual = unserialize($individual_data['individual']);

            $this->population->addIndividual($individual);
        }
    }

    /**
     * Render the generations.
     *
     * @return string
     *   The rendered generations.
     */
    public function renderGenerations($printStats = false)
    {
        $output = '';

        foreach ($this->previousGenerations as $generation_number => $population) {
            $output .= $population->render() . PHP_EOL . '<br>';
            if ($printStats === true) {
                $stats = $population->getStatistics();
                $output .= 'MIN: ' . print_r($stats['min']->render(), true) . '<br>';
                $output .= 'MAX: ' . print_r($stats['max']->render(), true) . '<br>';
            }
        }
        return $output;
    }

    /**
     * Utility function to cleare out the database.
     */
    public function clearDatabase()
    {
        $tables = [
            'evolution',
            'individuals',
            'populations',
        ];

        foreach ($tables as $table) {
            $sql = 'DELETE FROM ' . $table;
            $this->database->exec($sql);
        }
    }
}
