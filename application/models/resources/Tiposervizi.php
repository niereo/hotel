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
}

