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
    
}

