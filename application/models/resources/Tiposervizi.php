<?php

class Application_Resource_Tiposervizi extends Zend_Db_Table_Abstract
{
    protected $_name    = 'tipo_servizio';
    protected $_primary  = 'tipo';
    protected $_rowClass = 'Application_Resource_Tiposervizi_Item';

	public function init()
    {
    }
       
    public function getServizi()
    {
        return $this->fetchAll();
    }	
}

