<?php

class Application_Resource_Cliente extends Zend_Db_Table_Abstract
{
    protected $_name    = 'cliente';
    protected $_primary  = 'username';
    protected $_rowClass = 'Application_Resource_Cliente_Item';

	public function init()
    {
    }
       
   
    
    public function insertCliente($info)
    {
        $this->insert($info);
    }
}

