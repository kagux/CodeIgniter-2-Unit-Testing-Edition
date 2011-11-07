<?php
/**
 * @author: Boris Mikhaylov
 * Date: 29.10.11
 * Time: 17:21
 */

class MY_Controller extends CI_Controller{
    const EXISTING_METHOD_PARAM_OFFSET = 2;
    const INDEX_METHOD_PARAM_OFFSET = 1;
    
    /**
     * @var Twig
     */
    protected $view;

    /**
     * @var MY_Model
     */
    protected $model;

    /**
     * @var boolean
     */
    protected $isLocalIpRequest;
    
    /**
     * @var CI_Input
     */
    public $input;

    /**
     * @var Doctrine
     */
    public $doctrine;



    public function __construct(){
        parent::__construct();
        $this->load->library('twig');
        $this->view=$this->twig;
        $this->isLocalIpRequest=$this->isLocalIPRequest();
    }

    public function index(){
        show_404();
    }

    protected function redirectToPreviousPage(){
        redirect($_SERVER['HTTP_REFERER']);
    }

    protected function loadModel($modelName){
        $modelNameLowerCase = strtolower($modelName);
        $this->load->model($modelNameLowerCase);
        $this->model=$this->$modelNameLowerCase;
    }

    public function _setModel(MY_Model $model){
        $this->model=$model;
    }

    public function _getModel(){
        return $this->model;
    }

    public function _setView(Twig $view){
        $this->view =$view;
    }

    /**
     * This function is called by CodeIgniter instead of directly executing
     * methods defined by URI.
     * If requested method does not exist we execute "index" method with URI arguments.
     * If requested method exists we execute it as it should have been without remapping.
     * @param $method Controller method name requested by CodeIgniter
     * @return void
     */
    public function _remap($method){
        if (method_exists($this, $method))
            $this->executeMethod($method, $this->methodParams(self::EXISTING_METHOD_PARAM_OFFSET));
        else
            $this->executeMethod("index", $this->methodParams(self::INDEX_METHOD_PARAM_OFFSET));
    }

    public function methodParams($param_offset)
    {
        $params = array_slice($this->uri->rsegment_array(), $param_offset);
        return $params;
    }

    private function executeMethod($method, $params){
        call_user_func_array(array($this, $method), $params);
    }

    protected function isLocalIPRequest(){
        return isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] == '127.0.0.1';
    }


}
