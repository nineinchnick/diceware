<?php
include './RandDotOrg.class.php';

class Diceware {
  private $rolls;
  private $tr;
  private $char_table, $special_table, $pos_table;
  private $word_list;

  private $char_str = '[["~","&","+",":","?","4"],["!","*","[",";","/","5"],["#","(","]","\"","0","6"],["$",")","\\\\","\'","1","7"],["%","-","{","<","2","8"],["^","=","}",">","3","9"]]';
  private $special_str = '[ ["!","@","#","$","%","^"], ["&","*","(",")","-","="], ["+","[","]","{","}","\\\\"], ["|","`",";",":","\'","\""], ["<",">","/","?",".",","], ["~","_","3","5","7","9"]]';
  private $pos_str = '[ ["1","2","0","1","2","0"], ["1","2","3","0","*","*"], ["1","2","3","4","0","*"], ["1","2","3","4","5","0"], ["1","2","3","4","5","6"]]';

  private function get_rolls($num) {
    // can we fulfill the request?
    if($num > count($this->rolls)) {
      // if not, get more dice rolls
      // make sure we get at least as many rolls as we need. Otherwise,
      // use 90 (if it's bigger), to save on API calls
      $req = (90 > $num) ? 90 : $num;
      $this->rolls = $this->tr->get_integers($req, 1, 6, 10);
    }
    // peel off the requested number of rolls and return them
    return array_splice($this->rolls,0,$num);
  }

  public function get_number($count) {
    $result = array();
    for($i=0; $i<$count; $i++) {
      $res = 0;
      do {
        $first_dice = $this->get_rolls(1);
      } while ($first_dice[0]==6);
      $second_dice = $this->get_rolls(1);
      $first_dice = $first_dice[0];
      $second_dice = $second_dice[0];
      if($second_dice%2) {
        $res = $first_dice;
      } else {
        $res = 5+$first_dice;
        if($res==10) {
          $res = 0;
        }
      }
      $result[$i] = $res;
    }
    return $result;
  }

  public function get_phrase($length,$extra) {
    $rolls = 5*$length;
    $input = $this->get_rolls($rolls);
    $output = array();
    $wordn = "";
    
    if($extra) {
      // pick a word
      do {
        $roll = $this->get_rolls(1);
        $wordn = $roll[0];
      } while ($wordn>$length);
      $wordn = $wordn-1;
      $rollc = $this->get_rolls(2);
      $char = array($this->char_table[$rollc[0]-1][$rollc[1]-1]);
    }

    // loop and handle every 5 numbers
    for($i=0; $i<$length; $i++) {
      // get 5 numbers and convert them to a string
      $dice = $this->get_rolls(5);
      $num = implode("",$dice);
      // look up the word in the word list
      $word = $this->word_list[$num];
      // get the right word
      if($extra&&($i==$wordn)) {
        do {
          $roll = $this->get_rolls(1);
          $roll = $roll[0];
          // get the right character
          $pos = $this->pos_table[strlen($word)][$roll-1];
        } while ($pos=="*");
        // insert the character in the specified word
        $str = str_split($word);
        array_splice($str,$pos,0,$char);
        $word = implode("",$str);
      }
      // add the word to an output array
      array_push($output,$word);
    }
    // return the result
    return $output;
  }

  public function get_character() {
    $rolls = $this->get_rolls(2);
    return $this->special_table[$rolls[0]][$rolls[1]];
  }

  function __construct() {
    $this->tr = new RandDotOrg('diceware utilities - joe@desertflood.com');
    $this->rolls = array();
    $this->char_table = json_decode($this->char_str);
    $this->special_table = json_decode($this->special_str);
    $this->pos_table = json_decode($this->pos_str);
    $this->word_list = json_decode(file_get_contents("diceware.wordlist.json"),true);
  }
}
?>
