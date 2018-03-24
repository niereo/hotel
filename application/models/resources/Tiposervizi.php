<?php

class Application_Resource_Tiposervizi extends Zend_Db_Table_Abstract
{
    protected $_name    = 'tipo_servizio';
    protected $_primary  = 'tipo';
    protected $_rowClass = 'Application_Resource_Tiposervizi_Item';

	public function init()
    {
    }
       
    public function getServizi($paged=null)
    {
        $select=$this->select();
        if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(1)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
        return $this->fetchAll($paged);
    }
    public function RicercaServizi($parola,$paged=null)
    {
        $select=$this->select();
        $select=$select->orWhere('tipo LIKE ?',"%$parola%")->orWhere('descrizione LIKE ?',"%$parola%");
        if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(1)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
        return $this->fetchAll($paged);
    }
      public function insertServizi($info)
    {
        $this->insert($info);
    }
    public function getServiziByTipo($tipo)
    {
        $select=$this->select()->where('tipo = ?',$tipo);
        return $this->fetchRow($select);
    }
     public function updateServizi($info,$codice)
    {
        $where= array('tipo = ?' => $codice);
        return $this->update($info,$where);
    }
     public function deleteServizi($tipo)
    {
         $where= $this->getAdapter()->quoteInto('tipo = ?', $tipo);
	$this->delete($where);
    }
    
}

