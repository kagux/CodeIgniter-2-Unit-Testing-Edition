<?php

/*
 Copyright (c) 2009 hamcrest.org
 */

require_once CIUPATH. 'libraries/Hamcrest/TypeSafeMatcher.php';
require_once CIUPATH. 'libraries/Hamcrest/Description.php';

class Hamcrest_Number_OrderingComparison extends Hamcrest_TypeSafeMatcher
{
  
  private $_value;
  private $_minCompare;
  private $_maxCompare;
  
  public function __construct($value, $minCompare, $maxCompare)
  {
    parent::__construct(self::TYPE_NUMERIC);
    
    $this->_value = $value;
    $this->_minCompare = $minCompare;
    $this->_maxCompare = $maxCompare;
  }
  
  protected function matchesSafely($other)
  {
    $compare = $this->_compare($this->_value, $other);
    return ($this->_minCompare <= $compare) && ($compare <= $this->_maxCompare);
  }
  
  protected function describeMismatchSafely($item,
    Hamcrest_Description $mismatchDescription)
  {
    $mismatchDescription
      ->appendValue($item)->appendText(' was ')
      ->appendText($this->_comparison($this->_compare($this->_value, $item)))
      ->appendText(' ')->appendValue($this->_value)
      ;
  }
  
  public function describeTo(Hamcrest_Description $description)
  {
    $description->appendText('a value ')
      ->appendText($this->_comparison($this->_minCompare))
      ;
    if ($this->_minCompare != $this->_maxCompare)
    {
      $description->appendText(' or ')
        ->appendText($this->_comparison($this->_maxCompare))
        ;
    }
    $description->appendText(' ')->appendValue($this->_value);
  }
  
  /**
   * The value is not > $value, nor < $value.
   */
  public static function comparesEqualTo($value)
  {
    return new self($value, 0, 0);
  }
  
  /**
   * The value is > $value.
   */
  public static function greaterThan($value)
  {
    return new self($value, -1, -1);
  }
  
  /**
   * The value is >= $value.
   */
  public static function greaterThanOrEqualTo($value)
  {
    return new self($value, -1, 0);
  }
  
  /**
   * The value is < $value.
   */
  public static function lessThan($value)
  {
    return new self($value, 1, 1);
  }
  
  /**
   * The value is <= $value.
   */
  public static function lessThanOrEqualTo($value)
  {
    return new self($value, 0, 1);
  }
  
  // -- Private Methods
  
  private function _compare($left, $right)
  {
    $a = $left;
    $b = $right;
    
    if ($a < $b)
    {
      return -1;
    }
    elseif ($a == $b)
    {
      return 0;
    }
    else
    {
      return 1;
    }
  }
  
  private function _comparison($compare)
  {
    if ($compare > 0)
    {
      return 'less than';
    }
    elseif ($compare == 0)
    {
      return 'equal to ';
    }
    else
    {
      return 'greater than';
    }
  }
  
}
