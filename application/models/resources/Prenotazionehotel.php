<?php

class Application_Resource_Prenotazionehotel extends Zend_Db_Table_Abstract
{
    protected $_name    = 'prenotazione_hotel';
    protected $_primary  = 'cod_prenotazione';
    protected $_rowClass = 'Application_Resource_Prenotazionehotel_Item';

	public function init()
    {
    }
    public function getManutenzioni()
    {
        $oggi=new Zend_Date();
        $oggi=$oggi->toString('yyyy-MM-dd');
        $select=$this->select()->setIntegrityCheck(false)
                                ->from('prenotazione_hotel')
                                ->joinLeft('utente', 'prenotazione_hotel.username = utente.username')
                ->where('utente.ruolo = ?','admin')
                ->where('prenotazione_hotel.data_fine_pren >?', $oggi);
        return $this->fetchAll($select);
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
        $data=new Zend_Date();
        $di=$data->getYear();
        $anno=$data->getYear();
        $anno=$anno->setDay(31);
        $anno=$anno->setMonth(12);
        $datainizio=$di->toString('yyyy-MM-dd');
        //$datafine=$anno->toString('yyyy-MM-dd');
    
        $select=$this->select()->where('username = ?', $usrName)
                ->where('data_fine_pren >= ?',$datainizio)
                
                ->order($order);
         
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
     public function getDisponibilitaByCamera($codice)
    {
        $oggi=new Zend_Date();
        $oggi=$oggi->toString('yyyy-MM-dd');
        $select=$this->select()->where('codice_camera = ?', $codice)
                                ->where('data_fine_pren >= ?',$oggi );
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
    public function getIncassi($anno,$camera,$servizi) {
        
        $datainizio=new Zend_Date();
        $datainizio=$datainizio->setYear($anno);
        $datainizio=$datainizio->setDay(1);
        $datainizio=$datainizio->setMonth(1);
        
        $datafine = new Zend_Date();
        $datafine =$datafine->setYear($anno);
        $datafine =$datafine->setDay(31);
        $datafine =$datafine->setMonth(12);
        
        $datainizio=$datainizio->toString('yyyy-MM-dd');
        $datafine =$datafine->toString('yyyy-MM-dd');
        
        
        $select=$this->select();
        
       
        if($camera !== 'Qualsiasi')
        {
            $select=$select->where('tipo_camera = ?',$camera);
        }
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
            $select=$select->where('data_inizio_pren >= ?', $datainizio)
                               ->where('data_fine_pren <= ?', $datafine) ;
        
        return $this->fetchAll($select);
    }
    
    public function updatePrenotazione($info,$codice){
        $select='cod_prenotazione = ?'.$codice;
        
        $this->update($info, $select);
    }
}

