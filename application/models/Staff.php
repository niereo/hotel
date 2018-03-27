<?php

class Application_Model_Staff extends App_Model_Abstract
{ 

	public function __construct()
    {
    }

     public function getClienti()
    {
    	return $this->getResource('Cliente')->getClienti();
    }
    public function getStaffByUser($info)
    {
    	return $this->getResource('Staff')->getStaffByUser($info);
    }
   
    public function updatePassByUser($info)
    {
	return $this->getResource('Utente')->updatePassByUser($info);
    }
     public function updateProfiloByUser($info)
    {
	return $this->getResource('Staff')->updateProfiloByUser($info);
    }
   public function getPrenotazioniByFiltri($user,$camere,$servizi)
    {
    	return $this->getResource('Prenotazionehotel')->getPrenotazioniByFiltri($user,$camere,$servizi);
    }
      public function getPrenotazioneByCodice($codice)
    {
    	return $this->getResource('Prenotazionehotel')->getPrenotazioneByCodice($codice);
    }
     public function getDisponibilitaByCamera($codice,$codpren=null)
     {
         return $this->getResource('Prenotazionehotel')->getDisponibilitaByCamera($codice,$codpren);
     }
}
