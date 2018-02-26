<?php

class Application_Model_Staff extends App_Model_Abstract
{ 

	public function __construct()
    {
    }


    public function getStaffByUser($info)
    {
    	return $this->getResource('Staff')->getStaffByUser($info);
    }
   
    public function updatePassByUser($info)
    {
	return $this->getResource('Utente')->updatePassByUser($info);
    }
     public function updateProfiloByUser($info)
    {
	return $this->getResource('Staff')->updateProfiloByUser($info);
    }
   
    
}
