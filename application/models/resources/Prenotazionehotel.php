<?php

class Application_Resource_Prenotazionehotel extends Zend_Db_Table_Abstract
{
    protected $_name    = 'prenotazione_hotel';
    protected $_primary  = 'cod_prenotazione';
    protected $_rowClass = 'Application_Resource_Prenotazionehotel_Item';

	public function init()
    {
    }
       
    public function getPrenotazioniByUser($usrName,$paged=null)
    {
        $select=$this->select()->where('username = ?', $usrName);
        
		if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(1)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
        return $this->fetchAll($select);
    }	
    public function deletePrenotazioneByCod($codice)
    {
        
        $where= $this->getAdapter()->quoteInto('cod_prenotazione = ?', $codice);
	$this->delete($where);
    }
}

