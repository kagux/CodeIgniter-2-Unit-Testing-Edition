<?php
/**
 * @author: Boris Mikhaylov
 * Date: 31.10.11
 * Time: 23:26
 */
 
class CIUnit_Controller_TestCase extends  CIUnit_TestCase{
    const HTTP_404_ERROR_TEXT = "HTTP/1.0 404 Not Found";

    public function tearDown(){
        $_POST=array();
        parent::tearDown();
    }

    protected function viewThatIsExpectedToShow($template, $templateData=FALSE){
        if ($templateData)  $viewTemplateDataConstraint = $this->equalTo($templateData);
        else                $viewTemplateDataConstraint = $this->anything();
        $view = $this->getMock("Twig", array("display"));
        $view->expects($this->once())
                ->method('display')
                ->with($this->equalTo($template), $viewTemplateDataConstraint);
        return $view;
    }

    protected function addPostInput($variable, $value){
       $_POST[$variable]=$value;
    }

    public function redirectHeader($location) {
        $expectedHeaders = array(
            "Location: $location",
            true
        );
        return $expectedHeaders;
    }



}
