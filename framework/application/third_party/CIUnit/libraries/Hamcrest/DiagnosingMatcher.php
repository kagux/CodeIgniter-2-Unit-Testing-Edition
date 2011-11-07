<?php

/*
 Copyright (c) 2009 hamcrest.org
 */

require_once CIUPATH. 'libraries/Hamcrest/BaseMatcher.php';
require_once CIUPATH. 'libraries/Hamcrest/Description.php';
require_once CIUPATH. 'libraries/Hamcrest/NullDescription.php';

/**
 * Official documentation for this class is missing.
 */
abstract class Hamcrest_DiagnosingMatcher extends Hamcrest_BaseMatcher
{
  
  final public function matches($item)
  {
    return $this->matchesWithDiagnosticDescription(
      $item, new Hamcrest_NullDescription()
    );
  }
  
  public function describeMismatch($item,
    Hamcrest_Description $mismatchDescription)
  {
    $this->matchesWithDiagnosticDescription($item, $mismatchDescription);
  }
  
  abstract protected function matchesWithDiagnosticDescription($item,
    Hamcrest_Description $mismatchDescription);
  
}
