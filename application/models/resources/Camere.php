<?php

class Application_Resource_Camere extends Zend_Db_Table_Abstract
{
    protected $_name    = 'camere';
    protected $_primary  = 'cod_camera';
    protected $_rowClass = 'Application_Resource_Camere_Item';

	public function init()
    {
    }
       
    public function getTipoByCod($codice)
    {
        return $this->fetchRow($this->select()->where('cod_camera = ?', $codice));
    }	
    
     public function getCamere($order=null)
    {
        return $this->fetchAll($where=null,$order);
    }
    
     public function getCamereByTipo($tipo,$order=null)
    {
        return $this->fetchAll($this->select()->where('tipo = ?', $tipo)->order($order));
    }
     public function getCamereByCodice($codice)
    {
        return $this->fetchRow($this->select()->where('cod_camera = ?', $codice));
    }
      public function insertCamera($info)
    {
        $this->insert($info);
    }
     public function updateCamera($info)
    {
	$where= array('cod_camera = ?' => $info['cod_camera']);
	$this->update($info,$where);
    }
    public function deleteCamera($camera)
    {
         $where= $this->getAdapter()->quoteInto('cod_camera = ?', $camera);
	$this->delete($where);
    }
     public function deleteCamereByTipo($tipo)
    {
         $where= $this->getAdapter()->quoteInto('tipo = ?', $tipo);
	$this->delete($where);
    }
}

