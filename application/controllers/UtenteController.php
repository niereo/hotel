<?php

class UtenteController extends Zend_Controller_Action
{	
    public function init()
    {
		$this->_helper->layout->setLayout('layout_utente');
		$this->_authService = new Application_Service_Auth();
    }

    public function indexAction()
    {
        
    }  
    
    public function contattiAction()
    {
		
    }
        
    public function whereAction()
    {
		
    }
	
    public function chisiamoAction()
    {
		
    }
      public function faqAction()
    {
         $this->view->headTitle( 'Elenco delle F.A.Q.' );
        $faq = new Application_Resource_Faq();
        $fa = $faq->fetchAll();
        $this->view->faq = $fa;
    }

    public function logoutAction()
	{
		$this->_authService->clear();
		return $this->_helper->redirector('index','public');	
	}
    
}

