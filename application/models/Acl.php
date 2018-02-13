<?php 

class Application_Model_Acl extends Zend_Acl
{
	public function __construct()
	{
		// ACL for default role
		$this->addRole(new Zend_Acl_Role('unregistered'))
			 ->add(new Zend_Acl_Resource('public'))
			 ->add(new Zend_Acl_Resource('error'))
			 ->add(new Zend_Acl_Resource('index'))
			 ->allow('unregistered', array('public','error','index'));
			 
		// ACL for user
		$this->addRole(new Zend_Acl_Role('Utente'), 'unregistered')
			 ->add(new Zend_Acl_Resource('utente'))
			 ->allow('Utente','utente');
				   
		// ACL for administrator
		$this->addRole(new Zend_Acl_Role('Admin'), 'Utente')
			 ->add(new Zend_Acl_Resource('admin'))
			 ->allow('Admin','admin');
	}
}