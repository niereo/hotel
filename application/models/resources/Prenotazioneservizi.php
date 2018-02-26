<?php

class Application_Resource_Prenotazioneservizi extends Zend_Db_Table_Abstract
{
    protected $_name    = 'prenotazione_servizi';
    protected $_primary  = 'id';
    protected $_rowClass = 'Application_Resource_Prenotazioneservizi_Item';

	public function init()
    {
    }
       
    public function getPrenotazioniByCodPrenot($codice)
    {
        $select=$this->select()->where('cod_prenotazione = ?', $codice);
        return $this->fetchAll($select);
    }	
    public function deletePrenotazioneServByCod($codice)
    {
        
        $where= $this->getAdapter()->quoteInto('cod_prenotazione = ?', $codice);
	$this->delete($where);
    }
      public function insertPrenotazioneservizi($info)
    {
        $this->insert($info);
    }
}

