<?php

class Application_Resource_Staff extends Zend_Db_Table_Abstract
{
    protected $_name    = 'staff';
    protected $_primary  = 'username';
    protected $_rowClass = 'Application_Resource_Staff_Item';

	public function init()
    {
    }
       
   
    
   
   public function getStaffByUser($usrName)
    {
        return $this->fetchRow($this->select()->where('username = ?', $usrName));
    }
    public function updateProfiloByUser($info)
    {
        $where= array('username = ?' => $info['username']);
	$this->update($info,$where);
        
    }	
    
}

