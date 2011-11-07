<?php
/**
 * @author: Boris Mikhaylov
 * Date: 04.11.11
 * Time: 18:29
 */

class SampleModelTest extends CIUnit_Model_TestCase{

    /**
     * @var My_Model
     */
    protected $model;

    public function before(){
/*        //load model and makes it accessible via $this->model
        $this->loadModel("ModelName");*/
    }

    public function test_SampleTest(){
/*        //save entity to in-memory DB
        $entity = new \entities\SomeEntity();
        $this->saveToDB($entity);

        //use entity manager to get entities from in-memory DB
        $entity = $this->entityManager->getRepository('\entities\SomeEntity')->find(1);

        //check entity state
        $actualEntityState = $this->entityManager->getUnitOfWork()->getEntityState($entity);
        $expectedEntityState = \Doctrine\ORM\UnitOfWork::STATE_MANAGED;
        $this->assertEquals($expectedEntityState,$actualEntityState);

        //execute methods
        $this->model->getSomething();*/


    }
}
