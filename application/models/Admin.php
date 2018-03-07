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
   
    public function getFaqByCod($codice)
    {
        return $this->getResource('Faq')->getFaqByCod($codice);
    }
      public function insertfaq($info)
    {
    	return $this->getResource('Faq')->insertfaq($info);
    }
    public function updateFaq($info)
    {
        return $this->getResource('Faq')->updateFaq($info);
    }
    public function deleteFaq($info)
    {
        return $this->getResource('Faq')->deleteFaq($info);
    }
      public function insertServizi($info)
    {
    	return $this->getResource('Tiposervizi')->insertServizi($info);
    }
     public function getServiziByTipo($codice)
    {
        return $this->getResource('Tiposervizi')->getServiziByTipo($codice);
    }
     public function updateServizi($info,$codice)
    {
        return $this->getResource('Tiposervizi')->updateServizi($info,$codice);
    }
    public function deleteServizi($info)
    {
        return $this->getResource('Tiposervizi')->deleteServizi($info);
    }
}