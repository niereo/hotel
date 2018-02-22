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
    
    
   
    
}

