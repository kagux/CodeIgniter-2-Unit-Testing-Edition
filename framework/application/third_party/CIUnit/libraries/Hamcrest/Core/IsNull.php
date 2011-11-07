<?php

/*
 Copyright (c) 2009 hamcrest.org
 */

require_once CIUPATH. 'libraries/Hamcrest/BaseMatcher.php';
require_once CIUPATH. 'libraries/Hamcrest/Description.php';
require_once CIUPATH. 'libraries/Hamcrest/Core/IsNot.php';

/**
 * Is the value null?
 */
class Hamcrest_Core_IsNull extends Hamcrest_BaseMatcher
{
  
  public function matches($item)
  {
    return is_null($item);
  }
  
  public function describeTo(Hamcrest_Description $description)
  {
    $description->appendText('null');
  }
  
  /**
   * Matches if value is null.
   */
  public static function nullValue()
  {
    return new self();
  }
  
  /**
   * Matches if value is not null.
   */
  public static function notNullValue()
  {
    return Hamcrest_Core_IsNot::not(new self());
  }
  
}
