<?php

use Doctrine\ORM\EntityManager;

class MY_Model extends CI_Model{
    /**
     * @var Doctrine\ORM\EntityManager;
     */
    protected $entityManager;

    public function __construct(){
        parent::__construct();
        $this->entityManager=$this->doctrine->em;
    }

    public function setEntityManager(Doctrine\ORM\EntityManager $em){
        $this->entityManager=$em;
    }

    /**
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager(){
        return $this->entityManager;
    }

    protected function isObjectFound($object){
        return !is_null($object);
    }

}

 
