<?php

class Application_Resource_Prenotazionehotel extends Zend_Db_Table_Abstract
{
    protected $_name    = 'prenotazione_hotel';
    protected $_primary  = 'cod_prenotazione';
    protected $_rowClass = 'Application_Resource_Prenotazionehotel_Item';

	public function init()
    {
    }
       
    public function getPrenotazioniByUser($usrName)
    {
        return $this->fetchAll($this->select()->where('username = ?', $usrName));
    }	
    public function deletePrenotazioneByCod($codice)
    {
        
        $where= $this->getAdapter()->quoteInto('cod_prenotazione = ?', $codice);
	$this->delete($where);
    }
}

