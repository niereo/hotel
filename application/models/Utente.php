<?php

class Application_Model_Utente extends App_Model_Abstract
{ 

	public function __construct()
    {
    }


    public function getClienteByUser($info)
    {
    	return $this->getResource('Cliente')->getClienteByUser($info);
    }
   
    public function updatePassByUser($info)
    {
	return $this->getResource('Utente')->updatePassByUser($info);
    }
     public function updateProfiloByUser($info)
    {
	return $this->getResource('Cliente')->updateProfiloByUser($info);
    }
     public function getPrenotazioniByUser($info,$paged=null)
    {
    	return $this->getResource('Prenotazionehotel')->getPrenotazioniByUser($info,$paged);
    }
     public function deletePrenotazioneByCod($info)
    {
    	return $this->getResource('Prenotazionehotel')->deletePrenotazioneByCod($info);
    }
      public function getTipoByCod($info)
    {
    	return $this->getResource('Camere')->getTipoByCod($info);
    }
    
       public function getPrenotazioniByCodPrenot($info)
    {
    	return $this->getResource('Prenotazioneservizi')->getPrenotazioniByCodPrenot($info);
    }
     public function deletePrenotazioneServByCod($info)
    {
    	return $this->getResource('Prenotazioneservizi')->deletePrenotazioneServByCod($info);
    }
       public function getPrenotazioniByCamera($info)
    {
    	return $this->getResource('Prenotazionehotel')->getPrenotazioniByCamera($info);
    }
       public function getCamere()
    {
    	return $this->getResource('Camere')->getCamere();
    } 
        public function getCamereByTipo($info)
    {
    	return $this->getResource('Camere')->getCamereByTipo($info);
    } 
        public function insertPrenotazione($info)
    {
    	return $this->getResource('Prenotazionehotel')->insertPrenotazione($info);
    }
       public function getDisponibilitacamera($info,$dataar,$datapa)
    {
    	return $this->getResource('Prenotazionehotel')->getDisponibilitacamera($info,$dataar,$datapa);
    }
    
}
