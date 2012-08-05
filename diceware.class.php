<?php
include './RandDotOrg.class.php';

class Diceware {
  private $rolls;
  private $tr;
  private $char_table, $special_table, $pos_table;

  private $char_str = '[["~","&","+",":","?","4"],["!","*","[",";","/","5"],["#","(","]","\"","0","6"],["$",")","\\","\'","1","7"],["%","-","{","<","2","8"],["^","=","}",">","3","9"]]';
  private $special_str = '[ ["!","@","#","$","%","^"], ["&","*","(",")","-","="], ["+","[","]","{","}","\\"], ["|","`",";",":","\'","\""], ["<",">","/","?",".",","], ["~","_","3","5","7","9"]]';
  private $pos_str = '[ ["1","1","1","1","1"], ["2","2","2","2","2"], ["0","3","3","3","3"], ["1","0","4","4","4"], ["2","*","0","5","5"], ["0","*","*","0","6"] ]';

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

  public function get_phrase($length) {
    $rolls = 5*$length;
    $input = $this->get_rolls($rolls);
    // loop and handle every 5 numbers
    // look up the word in the word list
    // add the word to an output array
    // get 4 more dice rolls
    // get the right word
    // get the right character
    // look up the new character
    // insert the character in the specified word
    // return the result
  }

  function __construct() {
    $this->tr = new RandDotOrg('diceware utilities - joe@desertflood.com');
    $this->rolls = array();
    $this->char_table = json_decode($this->char_str);
    $this->special_table = json_decode($this->special_str);
    $this->number_table = json_decode($this->num_str);
  }
}
?>
