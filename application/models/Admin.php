<?php

class Application_Model_Admin extends App_Model_Abstract
{ 

	public function __construct()
    {
    }


    public function getUtenteByName($info)
    {
    	return $this->getResource('Utente')->getUtenteByName($info);
    }
     public function insertfaq($info)
    {
    	return $this->getResource('Faq')->insertfaq($info);
    }

}