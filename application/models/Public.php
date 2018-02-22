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
      public function getTipoCamere()
    {
    	return $this->getResource('Tipocamere')->getTipoCamere();
    }
       public function getServizi()
    {
    	return $this->getResource('Tiposervizi')->getServizi();
    }
        public function insertUtente($info)
    {
    	return $this->getResource('Utente')->insertUtente($info);
    }
    
         public function insertCliente($info)
    {
    	return $this->getResource('Cliente')->insertCliente($info);
    }

}
