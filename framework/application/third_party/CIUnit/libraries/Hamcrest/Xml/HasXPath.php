<?php

/*
 Copyright (c) 2009 hamcrest.org
 */

require_once CIUPATH. 'libraries/Hamcrest/DiagnosingMatcher.php';
require_once CIUPATH. 'libraries/Hamcrest/Matcher.php';
require_once CIUPATH. 'libraries/Hamcrest/Core/IsEqual.php';

/**
 * Matches if XPath applied to XML/HTML/XHTML document either
 * evaluates to result matching the matcher or returns at least
 * one node, matching the matcher if present.
 */
class Hamcrest_Xml_HasXPath extends Hamcrest_DiagnosingMatcher
{

  /**
   * XPath to apply to the DOM.
   *
   * @var string
   */
  private $_xpath;

  /**
   * Optional matcher to apply to the XPath expression result
   * or the content of the returned nodes.
   *
   * @var Hamcrest_Matcher
   */
  private $_matcher;

  public function __construct($xpath, Hamcrest_Matcher $matcher=null)
  {
    $this->_xpath = $xpath;
    $this->_matcher = $matcher;
  }

  /**
   * Matches if the XPath matches against the DOM node and the matcher.
   *
   * @param string|DOMNode $actual
   * @param Hamcrest_Description $mismatchDescription
   * @return bool
   */
  protected function matchesWithDiagnosticDescription($actual,
      Hamcrest_Description $mismatchDescription)
  {
    if (is_string($actual))
    {
      $actual = $this->createDocument($actual);
    }
    elseif (!$actual instanceof DOMNode)
    {
      $mismatchDescription->appendText('was ')->appendValue($actual);
      return false;
    }
    $result = $this->evaluate($actual);
    if ($result instanceof DOMNodeList)
    {
      return $this->matchesContent($result, $mismatchDescription);
    }
    else
    {
      return $this->matchesExpression($result, $mismatchDescription);
    }
  }

  /**
   * Creates and returns a <code>DOMDocument</code> from the given
   * XML or HTML string.
   *
   * @param string $text
   * @return DOMDocument built from <code>$text</code>
   * @throws InvalidArgumentException if the document is not valid
   */
  protected function createDocument($text)
  {
    $document = new DOMDocument();
    if (preg_match('/^\s*<\?xml/', $text))
    {
      if (!@$document->loadXML($text))
      {
        throw new InvalidArgumentException(
            'Must pass a valid XML document');
      }
    }
    else
    {
      if (!@$document->loadHTML($text))
      {
        throw new InvalidArgumentException(
            'Must pass a valid HTML or XHTML document');
      }
    }
    return $document;
  }

  /**
   * Applies the configurd XPath to the DOM node and returns either
   * the result if it's an expression or the node list if it's a query.
   *
   * @param DOMNode $node context from which to issue query
   * @return mixed result of expression or DOMNodeList from query
   */
  protected function evaluate(DOMNode $node)
  {
    if ($node instanceof DOMDocument)
    {
      $xpathDocument = new DOMXPath($node);
      return $xpathDocument->evaluate($this->_xpath);
    }
    else
    {
      $xpathDocument = new DOMXPath($node->ownerDocument);
      return $xpathDocument->evaluate($this->_xpath, $node);
    }
  }

  /**
   * Matches if the list of nodes is not empty and the content of at least
   * one node matches the configured matcher, if supplied.
   *
   * @param DOMNodeList $nodes selected by the XPath query
   * @param Hamcrest_Description $mismatchDescription
   * @return bool
   */
  protected function matchesContent(DOMNodeList $nodes,
      Hamcrest_Description $mismatchDescription)
  {
    if ($nodes->length == 0)
    {
      $mismatchDescription->appendText('XPath returned no results');
    }
    elseif ($this->_matcher === null)
    {
      return true;
    }
    else
    {
      foreach ($nodes as $node)
      {
        if ($this->_matcher->matches($node->textContent))
        {
          return true;
        }
      }
      $content = array();
      foreach ($nodes as $node)
      {
        $content[] = $node->textContent;
      }
      $mismatchDescription->appendText('XPath returned ')
                          ->appendValue($content);
    }
    return false;
  }

  /**
   * Matches if the result of the XPath expression matches the configured
   * matcher or evaluates to <code>true</code> if there is none.
   *
   * @param mixed $result result of the XPath expression
   * @param Hamcrest_Description $mismatchDescription
   * @return bool
   */
  protected function matchesExpression($result,
      Hamcrest_Description $mismatchDescription)
  {
    if ($this->_matcher === null)
    {
      if ($result)
      {
        return true;
      }
      $mismatchDescription->appendText('XPath expression result was ')
                          ->appendValue($result);
    }
    else
    {
      if ($this->_matcher->matches($result))
      {
        return true;
      }
      $mismatchDescription->appendText('XPath expression result ');
      $this->_matcher->describeMismatch($result, $mismatchDescription);
    }
    return false;
  }

  public function describeTo(Hamcrest_Description $description)
  {
    $description->appendText('XML or HTML document with XPath "')
                ->appendText($this->_xpath)
                ->appendText('"');
    if ($this->_matcher !== null)
    {
      $description->appendText(' ');
      $this->_matcher->describeTo($description);
    }
  }

  /**
   * Wraps <code>$matcher</code> with {@link Hamcrest_Core_IsEqual)
   * if it's not a matcher and the XPath in <code>count()</code>
   * if it's an integer.
   */
  public static function hasXPath($xpath, $matcher=null)
  {
    if ($matcher === null || $matcher instanceof Hamcrest_Matcher)
    {
      return new self($xpath, $matcher);
    }
    elseif (is_int($matcher) && strpos($xpath, 'count(') !== 0)
    {
      $xpath = 'count(' . $xpath . ')';
    }
    return new self($xpath, Hamcrest_Core_IsEqual::equalTo($matcher));
  }

}
