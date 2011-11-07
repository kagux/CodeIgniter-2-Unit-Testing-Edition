<?php
/**
 * @author: Boris Mikhaylov
 * Date: 04.11.11
 * Time: 17:47
 */

use \Doctrine\ORM\EntityManager;
class CIUnit_Model_TestCase extends CIUnit_TestCase{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var MY_Model
     */
    protected $model;
    
    public function setUp(){
        parent::setUp();
        $this->entityManager = $this->CI->doctrine->em;
        $this->resetDB();
    }

    private function resetDB(){
        $schemaTool = new Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $classes = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($classes);
        $schemaTool->createSchema($classes);
    }

    protected function saveToDB($entity){
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    protected function loadModel($modelName){
        $this->CI->load->model($modelName, "m");
        $this->model=$this->CI->m;
    }

}
