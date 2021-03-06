<?php

class PublicController extends Zend_Controller_Action
{
	
	protected $_authService;
	protected $_formLogin;
        protected $_formRegistrazione;
        protected $_publicModel;
        protected $_utenteModel;
        protected $_formRicercaservizi;
	
    public function init()
    {
	$this->_helper->layout->setLayout('layout_ospite');
        $this->_authService = new Application_Service_Auth();
        $this->view->loginForm = $this->getLoginForm();
        $this->view->registrazioneForm = $this->getRegistrazioneForm();
        $this->_publicModel = new Application_Model_Public();
        $this->_utenteModel = new Application_Model_Utente();
        $this->view->ricercaserviziForm = $this->getRicercaserviziForm();
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
         
        $faq = $this->_publicModel->getFaq();
        $this->view->faq = $faq;
    }
    
    public function catalogocamereAction()
    {
	$catalogo = $this->_publicModel->getTipoCamere();
        $this->view->catalogo = $catalogo;	
    }
    
    public function listacamereAction(){
        
        $tipo=$this->_getParam('tipo');
        $camere=$this->_utenteModel->getCamereByTipo($tipo);
        $this->view->camere=$camere;
    }
    
    public function catalogoserviziAction()
    {
        $paged = $this->_getParam('page', 1);
	$servizi = $this->_publicModel->getServizi($paged);
        $this->view->servizi = $servizi;
    }
    public function ricercaserviziAction()
    {
         $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('catalogoservizi');
        }
        $form = $this->_formRicercaservizi;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('catalogoservizi');
        }
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('catalogoservizi');
        }
        $form=$this->_formRicercaservizi;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('catalogoservizi');
        }
        $parola=$this->getRequest()->getParam('parola');
        $paged = $this->_getParam('page', 1);
	$servizi = $this->_utenteModel->RicercaServizi($parola,$paged);
        $this->view->servizi = $servizi;
    }
     private function getRicercaserviziForm()
    {
    	$urlHelper = $this->_helper->getHelper('url');
		$this->_formRicercaservizi = new Application_Form_Utente_Servizi_Ricercaservizi();
    	$this->_formRicercaservizi->setAction($urlHelper->url(array(
			'controller' => 'public',
			'action' => 'ricercaservizi'),
			'default'
		));
		return $this->_formRicercaservizi;
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
			'action' => 'registra'),
			'default'
		));
		return $this->_formRegistrazione;
    }   
    
    public function registraAction()
	{        
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('registrazione');
        }
        $form = $this->_formRegistrazione;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('registrazione');
        }
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('registrazione');
        }
  $form=$this->_formRegistrazione;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('registrazione');
        } 

    $username = $this->getRequest()->getParam('username');
    $password = $this->getRequest()->getParam('password');
    $cognome = $this->getRequest()->getParam('cognome'); 
     $nome = $this->getRequest()->getParam('nome'); 
     $data = $this->getRequest()->getParam('data_nascita'); 
     $cell = $this->getRequest()->getParam('numero_telefono');
      $gen = $this->getRequest()->getParam('genere');
      $cit = $this->getRequest()->getParam('citta');
      $ind = $this->getRequest()->getParam('indirizzo');
      $email = $this->getRequest()->getParam('email');
   
  $cli=array('username' => $username,
     'cognome' => $cognome,
     'nome' => $nome,
     'data_nascita' => $data,
     'numero_telefono' => $cell,
     'genere' => $gen,
     'citta' => $cit,
     'indirizzo' => $ind,
     'email' => $email);
  $info=array('username' => $username,
      'password' => $password,
      'ruolo' => 'utente');
     
  $this->_publicModel->insertUtente($info);
  $this->_publicModel->insertCliente($cli);
   
        return $this->_helper->redirector('index');
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

