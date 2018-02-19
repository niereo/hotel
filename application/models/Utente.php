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
     public function getPrenotazioniByUser($info)
    {
    	return $this->getResource('Prenotazionehotel')->getPrenotazioniByUser($info);
    }
     public function deletePrenotazioneByCod($info)
    {
    	return $this->getResource('Prenotazionehotel')->deletePrenotazioneByCod($info);
    }

}
