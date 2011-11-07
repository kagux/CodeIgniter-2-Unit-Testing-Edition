<?php

/*
 Copyright (c) 2009 hamcrest.org
 */

require_once CIUPATH. 'libraries/Hamcrest/FeatureMatcher.php';
require_once CIUPATH. 'libraries/Hamcrest/Matcher.php';
require_once CIUPATH. 'libraries/Hamcrest/Core/IsEqual.php';
require_once CIUPATH. 'libraries/Hamcrest/Core/DescribedAs.php';

/**
 * Matches if array size satisfies a nested matcher.
 */
class Hamcrest_Array_IsArrayWithSize extends Hamcrest_FeatureMatcher
{
  
  public function __construct(Hamcrest_Matcher $sizeMatcher)
  {
    parent::__construct(self::TYPE_ARRAY, null, $sizeMatcher, 'an array with size', 'array size');
  }
  
  protected function featureValueOf($array)
  {
    return count($array);
  }
  
  /**
   * Does array size satisfy a given matcher?
   * 
   * @hamcrest(factory)
   */
  public static function arrayWithSize($size)
  {
    $matcher = ($size instanceof Hamcrest_Matcher)
      ? $size
      : Hamcrest_Core_IsEqual::equalTo($size)
      ;
    return new self($matcher);
  }
  
  /**
   * Matches an empty array.
   * 
   * @hamcrest(factory)
   */
  public static function emptyArray()
  {
    $isEmpty = self::arrayWithSize(0);
    return Hamcrest_Core_DescribedAs::describedAs('an empty array', $isEmpty);
  }
  
}
