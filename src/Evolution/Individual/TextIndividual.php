<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

use Hashbangcode\Wevolution\Type\Text\Text;

/**
 * Class TextIndividual
 * @package Hashbangcode\Wevolution\Evolution\Individual
 */
class TextIndividual extends Individual {

  protected $textLength = 10;

  protected $fitnessGoal;

  /**
   * TextIndividual constructor.
   * @param $text
   */
  public function __construct($text) {
    $this->object = new Text($text);
  }

  /**
   * @return \Hashbangcode\Wevolution\Evolution\Individual\TextIndividual
   */
  public static function generateRandomText($textLength = 7) {
    $text = "";
    $charArray = array_merge(range('a', 'z'), range('A', 'Z'), [' ']);
    for ($i = 0; $i < $textLength; $i++) {
      $randItem = array_rand($charArray);
      $text .= $charArray[$randItem];
    }
    return new TextIndividual($text);
  }

  /**
   *
   */
  public function mutateProperties() {
    $this->mutateText($this->getMutationFactor());
    return $this;
  }

  /**
   * @return mixed
   */
  public function getFitness() {

    $text = str_split($this->getObject()->getText());
    $goal = str_split($this->getFitnessGoal());

    $score = 0;

    // Count the number of characters that are the same as our goal text.
    foreach ($text as $index => $character) {
      if (isset($goal[$index]) && $goal[$index] == $character) {
        $score = $score + 1;
      }
    }

    return $score;
  }

  /**
   * @return mixed
   */
  public function getFitnessGoal() {
    return $this->fitnessGoal;
  }

  /**
   * @param mixed $fitnessGoal
   */
  public function setFitnessGoal($fitnessGoal) {
    $this->fitnessGoal = $fitnessGoal;
  }

  /**
   * @param $renderType
   * @return mixed
   */
  public function render($renderType = 'cli') {
    switch ($renderType) {
      case 'html':
        return $this->object->render() . '<br>';
      case 'cli':
      default:
        return $this->object->render() . ' ';
    }
  }

  /**
   *
   */
  public function mutateText() {

    $text = $this->getObject()->getText();
    $goal = $this->getFitnessGoal();

    $text_length = strlen($text);
    $goal_length = strlen($goal);

    $random = mt_rand(0, 1000) / 1000;
    if ($random < 0.0001 && $text_length != $goal_length) {

      $operators = array('add', 'subtract');

      switch ($operators[array_rand($operators)]) {
        case 'add':
          // Add a random letter.
          $this->getObject()->setText($text . $this->getRandomLetter());
          break;
        case 'subtract':
          // Remove a random letter.
          $letter_position = mt_rand(0, strlen($text) - 1);
          $text_array = str_split($this->getObject()->getText());
          unset($text_array[$letter_position]);
          $this->getObject()->setText(implode('', $text_array));
          break;
      }
    }
    else {

      // Ger a random letter from the current string.
      $letter_position = mt_rand(0, strlen($text) - 1);

      $text = str_split($text);
      $letter = $text[$letter_position];

      $goal = str_split($goal);
      if (isset($goal[$letter_position]) && $goal[$letter_position] == $letter) {
        return;
      }

      if ($letter == 'z') {
        $newletter = 'A';
      }
      elseif ($letter == 'Z') {
        $newletter = ' ';
      }
      elseif ($letter == ' ') {
        $newletter = 'a';
      }
      else {
        $newletter = chr(ord($letter) + 1);
      }

      // Swap it for a random letter.
      $text[$letter_position] = $newletter;

      $text = implode('', $text);

      $this->getObject()->setText($text);
    }
  }

  /**
   * @return mixed
   */
  public function getRandomLetter() {
    $charArray = array_merge(range('a', 'z'), range('A', 'Z'));
    $charArray[] = ' ';
    $randItem = array_rand($charArray);
    return $charArray[$randItem];
  }
}