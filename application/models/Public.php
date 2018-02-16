<?php

class Application_Model_Public extends App_Model_Abstract
{ 

	public function __construct()
    {
    }


    public function getUtenteByName($info)
    {
    	return $this->getResource('Utente')->getUtenteByName($info);
    }
     public function getFaq()
    {
    	return $this->getResource('Faq')->getFaq();
    }
      public function getCamere()
    {
    	return $this->getResource('Tipocamere')->getCamere();
    }
       public function getServizi()
    {
    	return $this->getResource('Tiposervizi')->getServizi();
    }
        public function insertUtente($info)
    {
    	return $this->getResource('Utente')->insertUtente($info);
    }

}
