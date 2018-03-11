<?php

class Application_Resource_Tipocamere extends Zend_Db_Table_Abstract
{
    protected $_name    = 'tipo_camere';
    protected $_primary  = 'tipo';
    protected $_rowClass = 'Application_Resource_Tipocamere_Item';

	public function init()
    {
    }
       
    public function getTipoCamere()
    {
        return $this->fetchAll();
    }	
    
    public function insertTipoCamera($info)
    {
        $this->insert($info);
    }
     public function getTipoCameraByTipo($tipo)
    {
        $select=$this->select()->where('tipo = ?',$tipo);
        return $this->fetchRow($select);
    }
     public function updateTipoCamera($info,$codice)
    {
        $where= array('tipo = ?' => $codice);
        return $this->update($info,$where);
    }
     public function deleteTipoCamera($tipo)
    {
         $where= $this->getAdapter()->quoteInto('tipo = ?', $tipo);
	$this->delete($where);
    }
}

