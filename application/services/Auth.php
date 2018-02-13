<?php

class Application_Service_Auth
{
    protected $_adminModel;
    protected $_auth;

    public function __construct()
    {
        $this->_adminModel = new Application_Model_Admin();
    }
    
    public function authenticate($credentials)
    {
        $adapter = $this->getAuthAdapter($credentials);
        $auth    = $this->getAuth();
        $result  = $auth->authenticate($adapter);

        if (!$result->isValid()) {
            return false;
        }
        $user = $this->_adminModel->getUserByName($credentials['Username']);
        $auth->getStorage()->write($user);
        return true;
    }
    
    public function getAuth()
    {
        if (null === $this->_auth) {
            $this->_auth = Zend_Auth::getInstance();
        }
        return $this->_auth;
    }
   
    public function getIdentity()
    {
        $auth = $this->getAuth();
        if ($auth->hasIdentity()) {
            return $auth->getIdentity();
        }
        return false;
    }
    
    public function clear()
    {
        $this->getAuth()->clearIdentity();
    }
    
    public function getAuthAdapter($values)
    {
		$authAdapter = new Zend_Auth_Adapter_DbTable(
			Zend_Db_Table_Abstract::getDefaultAdapter(),
			'utente',
			'Username',
			'Password'
		);
		$authAdapter->setIdentity($values['Username']);
		$authAdapter->setCredential($values['Password']);
        return $authAdapter;
    }
	
	public function authInfo ($info = null)
    {
        if (null === $this->_authService) {
            $this->_authService = new Application_Service_Auth();
        }
        if (null === $info) {
            return $this;
        }
        if (false === $this->isLoggedIn()) {
            return null;
        }
        return $this->_authService->getIdentity()->$info;
    }

	public function isLoggedIn()
    {
        return $this->_authService->getAuth()->hasIdentity();
    }
}
