<?php

class Application_Resource_Prenotazionehotel extends Zend_Db_Table_Abstract
{
    protected $_name    = 'prenotazione_hotel';
    protected $_primary  = 'cod_prenotazione';
    protected $_rowClass = 'Application_Resource_Prenotazionehotel_Item';

	public function init()
    {
    }
    public function getPrenotazioneByCodice($codice)
    {
        $select=$this->select()->where('cod_prenotazione = ?', $codice);
        return $this->fetchRow($select);
    }
    public function getPrenotazioniByFiltri($user,$camera,$servizi)
    {
       
        $select=$this->select();
         
        if($user !== 'Qualsiasi')
            {$select=$select->where('username = ?',$user);}
          if($camera !== 'Qualsiasi')
             {$select=$select->where('codice_camera = ?',$camera);}
          if($servizi == 'Qualsiasi')                      
             {
    }else if ($servizi == 'Nessuno')
        {
        $select=$select->where('richiesta_servizi = ?',false);
    }else             {
        $select=$select->setIntegrityCheck(false)
                                ->from('prenotazione_hotel')
                                ->joinLeft('prenotazione_servizi', 'prenotazione_hotel.cod_prenotazione = prenotazione_servizi.cod_prenotazione')
                ->where('prenotazione_servizi.tipo_servizio = ?',$servizi);
    }             
                return $this->fetchAll($select);
                                
    }
    public function getPrenotazioniByUser($usrName,$paged=null,$order=null)
    {
        $select=$this->select()->where('username = ?', $usrName)->order($order);
        
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
    
     public function getPrenotazioniByCamera($codice)
    {
        $select=$this->select()->where('codice_camera = ?', $codice);
        return $this->fetchAll($select);
    }	
     public function getDisponibilitacamera($codice,$dataarr,$datapart)
    {
        $select=$this->select()->where('codice_camera = ?', $codice)
                ->where('data_inizio_pren <= ?',$datapart)
                ->where('data_fine_pren >= ?',$dataarr);
        $righe=$this->fetchAll($select);
         return $righe->count();
         
    }
    
     public function insertPrenotazione($info)
    {
        $this->insert($info);
    }
      public function getCodprenotazioneByDati($codcam,$datain)
    {
        $select=$this->select()
                ->where('codice_camera = ?', $codcam)  
                ->where('data_inizio_pren = ?', $datain);
        return $this->fetchRow($select);
    }
}

