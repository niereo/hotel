<?php

class Application_Model_Utente extends App_Model_Abstract
{ 

	public function __construct()
    {
    }

     public function RicercaServizi($parola,$paged=null)
    {
    	return $this->getResource('Tiposervizi')->RicercaServizi($parola,$paged);
    }
    public function getClienteByUser($info)
    {
    	return $this->getResource('Cliente')->getClienteByUser($info);
    }
     public function getUtenteByName($info)
    {
    	return $this->getResource('Utente')->getUtenteByName($info);
    }
   
    public function updatePassByUser($info)
    {
	return $this->getResource('Utente')->updatePassByUser($info);
    }
     public function updateProfiloByUser($info)
    {
	return $this->getResource('Cliente')->updateProfiloByUser($info);
    }
     public function getPrenotazioniByUser($info,$paged=null,$order=null)
    {
    	return $this->getResource('Prenotazionehotel')->getPrenotazioniByUser($info,$paged,$order);
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
       public function getCamere($order=null)
    {
    	return $this->getResource('Camere')->getCamere($order);
    } 
        public function getCamereByTipo($info,$order=null)
    {
    	return $this->getResource('Camere')->getCamereByTipo($info,$order);
    } 
      public function getCamereByCodice($info)
    {
    	return $this->getResource('Camere')->getCamereByCodice($info);
    } 
        public function insertPrenotazione($info)
    {
    	return $this->getResource('Prenotazionehotel')->insertPrenotazione($info);
    }
       public function getDisponibilitacamera($info,$dataar,$datapa,$codpren=null)
    {
    	return $this->getResource('Prenotazionehotel')->getDisponibilitacamera($info,$dataar,$datapa,$codpren);
    }
    public function updatePrenotazione($info,$codice){
        return $this->getResource('Prenotazionehotel')->updatePrenotazione($info,$codice);
    }
       public function getCodprenotazioneByDati($info,$data)
    {
    	return $this->getResource('Prenotazionehotel')->getCodprenotazioneByDati($info,$data);
    }
         public function insertPrenotazioneservizi($info)
    {
    	return $this->getResource('Prenotazioneservizi')->insertPrenotazioneservizi($info);
    }
    
}
