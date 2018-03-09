<?php

class Application_Resource_Staff extends Zend_Db_Table_Abstract
{
    protected $_name    = 'staff';
    protected $_primary  = 'username';
    protected $_rowClass = 'Application_Resource_Staff_Item';

	public function init()
    {
    }
       
   
    public function insertStaff($info)
    {
        $this->insert($info);
    }
    public function getStaff()
    {
        return $this->fetchAll();
    }
     public function deleteStaff($user)
    {
         $where= $this->getAdapter()->quoteInto('username = ?', $user);
	$this->delete($where);
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

