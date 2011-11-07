<?php

/*
 Copyright (c) 2010 hamcrest.org
 */

require_once CIUPATH. 'libraries/Hamcrest/BaseMatcher.php';
require_once CIUPATH. 'libraries/Hamcrest/Description.php';

/**
 * Tests whether the value has a built-in type.
 */
class Hamcrest_Core_IsTypeOf extends Hamcrest_BaseMatcher
{
  
  private $_theType;
  
  /**
   * Creates a new instance of IsTypeOf
   *
   * @param string $theType
   *   The predicate evaluates to true for values with this built-in type.
   */
  public function __construct($theType)
  {
    $this->_theType = strtolower($theType);
  }
  
  public function matches($item)
  {
    return strtolower(gettype($item)) == $this->_theType;
  }
  
  public function describeTo(Hamcrest_Description $description)
  {
    $description->appendText(self::getTypeDescription($this->_theType));
  }

  public function describeMismatch($item, Hamcrest_Description $description)
  {
    if ($item === null)
    {
      $description->appendText('was null');
    }
    else
    {
      $description->appendText('was ')
                  ->appendText(self::getTypeDescription(
                               strtolower(gettype($item))))
                  ->appendText(' ')
                  ->appendValue($item)
                  ;
    }
  }

  public static function getTypeDescription($type)
  {
    if ($type == 'null')
    {
      return 'null';
    }
    return (strpos('aeiou', substr($type, 0, 1)) === false ? 'a ' : 'an ')
        . $type;
  }
  
  /**
   * Is the value a particular built-in type?
   */
  public static function typeOf($theType)
  {
    return new self($theType);
  }
  
}
