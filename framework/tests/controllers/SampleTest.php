<?php
/**
 * @author: Boris Mikhaylov
 * Date: 02.11.11
 * Time: 14:34
 */

use \Mockery;

class SampleControllerTest extends CIUnit_Controller_TestCase{


    /**
     * Use this function to set up test environment before each test
     * @return void
     */
    public function before(){
    }

    public function test_sampleTest(){
/*        // default CUI_Controller controller
        $this->CI;

        //load custom controller
        $controller = set_controller("SampleController");

        //execute controller
        $controller->index();

        //verify view
        $templateData=null;
        $view=$this->viewThatIsExpectedToShow("template name", $templateData);
        $controller->_setView($view);

        //verify headers
        $expectedHeader=$this->redirectHeader('http://google.com');
        $this->assertContains($expectedHeader, headers());

        //add post input data
        $this->addPostInput("variable","value");
    */
    }
}
