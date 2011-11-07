<?php

/*
 Copyright (c) 2010 hamcrest.org
 */

require_once CIUPATH. 'libraries/Hamcrest/BaseMatcher.php';
require_once CIUPATH. 'libraries/Hamcrest/Description.php';

/**
 * Tests whether the value is an integer.
 */
class Hamcrest_Type_IsCallable extends Hamcrest_BaseMatcher
{

  public function matches($item)
  {
    return is_callable($item);
  }

  public function describeTo(Hamcrest_Description $description)
  {
    $description->appendText('function name, callback array, Closure, or callable object');
  }
  
  /**
   * Is the value an integer?
   */
  public static function callable()
  {
    return new self;
  }
  
}
