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
     public function insertStaff($info)
    {
    	return $this->getResource('Staff')->insertStaff($info);
    }
     public function getStaff()
    {
        return $this->getResource('Staff')->getStaff();
    }
    public function deleteStaff($info)
    {
        return $this->getResource('Staff')->deleteStaff($info);
    }
     public function getDipendenti()
    {
    	return $this->getResource('Staff')->getDipendenti();
    }
     public function deleteCliente($info)
    {
        return $this->getResource('Cliente')->deleteCliente($info);
    }
    public function deleteUtente($info)
    {
        return $this->getResource('Utente')->deleteUtente($info);
    }
     public function insertTipoCamera($info)
    {
    	return $this->getResource('Tipocamere')->insertTipoCamera($info);
    }
    public function getTipoCameraByTipo($tipo) 
    {    
        return $this->getResource('Tipocamere')->getTipoCameraByTipo($tipo);
    }
    public function updateTipoCamera($info,$codice)
    {    
        return $this->getResource('Tipocamere')->updateTipoCamera($info,$codice);
    }
    public function deleteTipoCamera($tipo) 
    {    
        return $this->getResource('Tipocamere')->deleteTipoCamera($tipo);
    }
     public function insertCamera($info)
    {
    	return $this->getResource('Camere')->insertCamera($info);
    }
}