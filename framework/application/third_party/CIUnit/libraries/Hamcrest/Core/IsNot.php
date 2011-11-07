<?php

/*
 Copyright (c) 2009 hamcrest.org
 */

require_once CIUPATH. 'libraries/Hamcrest/BaseMatcher.php';
require_once CIUPATH. 'libraries/Hamcrest/Matcher.php';
require_once CIUPATH. 'libraries/Hamcrest/Description.php';
require_once CIUPATH. 'libraries/Hamcrest/Core/IsEqual.php';

/**
 * Calculates the logical negation of a matcher.
 */
class Hamcrest_Core_IsNot extends Hamcrest_BaseMatcher
{
  
  private $_matcher;
  
  public function __construct(Hamcrest_Matcher $matcher)
  {
    $this->_matcher = $matcher;
  }
  
  public function matches($arg)
  {
    return !$this->_matcher->matches($arg);
  }
  
  public function describeTo(Hamcrest_Description $description)
  {
    $description->appendText('not ')->appendDescriptionOf($this->_matcher);
  }
  
  public static function not($value)
  {
    $matcher = ($value instanceof Hamcrest_Matcher)
      ? $value
      : Hamcrest_Core_IsEqual::equalTo($value)
      ;
    return new self($matcher);
  }
  
}
