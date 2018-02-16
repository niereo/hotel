<?php

class PublicController extends Zend_Controller_Action
{
	
	protected $_authService;
	protected $_formLogin;
        protected $_formRegistrazione;
	
    public function init()
    {
	$this->_helper->layout->setLayout('layout_ospite');
        $this->_authService = new Application_Service_Auth();
        $this->view->loginForm = $this->getLoginForm();
        $this->view->registrazioneForm = $this->getRegistrazioneForm();
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
         
        $faq = new Application_Resource_Faq();
        $fa = $faq->fetchAll();
        $this->view->faq = $fa;
    }
    
    public function catalogocamereAction()
    {
	$catalogo = new Application_Resource_Tipocamere();
        $cat = $catalogo->fetchAll();
        $this->view->catalogo = $cat;	
    }
    
    public function catalogoserviziAction()
    {
	$servizi = new Application_Resource_Tiposervizi();
        $ser = $servizi->fetchAll();
        $this->view->servizi = $ser;
    }
    
    public function registrazioneAction()
    {
        
    }
    
    	private function getRegistrazioneForm()
    {
    	$urlHelper = $this->_helper->getHelper('url');
		$this->_formRegistrazione = new Application_Form_Public_Registrazione_Registrazione();
    	$this->_formRegistrazione->setAction($urlHelper->url(array(
			'controller' => 'public',
			'action' => 'index'),
			'default'
		));
		return $this->_formRegistrazione;
    }   	
 	
    public function viewstaticAction () {
    	$page = $this->_getParam('staticPage');
    	$this->render($page);
    }
    
    public function loginAction()
    {}

    public function authenticateAction()
	{        
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('login');
        }
        $form = $this->_formLogin;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('login');
        }
        if (false === $this->_authService->authenticate($form->getValues())) {
            $form->setDescription('Autenticazione fallita. Riprova');
            return $this->render('login');
        }
        return $this->_helper->redirector('index', $this->_authService->getIdentity()->ruolo);
	}

	// Validazione AJAX
	public function validateloginAction() 
    {
        $this->_helper->getHelper('layout')->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();

        $loginform = new Application_Form_Public_Auth_Login();
        $response = $loginform->processAjax($_POST); 
        if ($response !== null) {
        	$this->getResponse()->setHeader('Content-type','application/json')->setBody($response);        	
        }
    }
	
	private function getLoginForm()
    {
    	$urlHelper = $this->_helper->getHelper('url');
		$this->_formLogin = new Application_Form_Public_Auth_Login();
    	$this->_formLogin->setAction($urlHelper->url(array(
			'controller' => 'public',
			'action' => 'authenticate'),
			'default'
		));
		return $this->_formLogin;
    }   	
}

