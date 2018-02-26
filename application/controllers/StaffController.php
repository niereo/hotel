<?php

class StaffController extends Zend_Controller_Action
{	
    protected $_staffModel;
    protected $_authService;
    protected $_formModificapassword;
    protected $_formModificaprofilo;
    public function init()
    {
		$this->_helper->layout->setLayout('layout_staff');
		$this->_authService = new Application_Service_Auth();
                $this->_staffModel = new Application_Model_Staff();
                $this->view->modificapassForm = $this->getModificapasswordForm();
                $this->view->modificaprofiloForm = $this->getModificaprofiloForm();
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
     //funzioni per modificare la password
    public function modificapasswordAction()
    {
        
    }
    private function getModificapasswordForm()
    {
    	$urlHelper = $this->_helper->getHelper('url');
		$this->_formModificapassword = new Application_Form_Staff_Modificadati_Modificapassword();
    	$this->_formModificapassword->setAction($urlHelper->url(array(
			'controller' => 'staff',
			'action' => 'modificapass'),
			'default'
		));
		return $this->_formModificapassword;
    }   
     public function modificapassAction()
	{        
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('modificapassword');
        }
        $form = $this->_formModificapassword;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('modificapassword');
        }
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('modificapassword');
        }
        $form=$this->_formModificapassword;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('modificapassword');
        }     
        $pass = $this->getRequest()->getParam('newpassword');
        
        $user=$this->_authService->authInfo('username');
        $info=array('username'=>$user,'password'=>$pass,'ruolo'=>'staff');
	$this->_staffModel->updatePassByUser($info); 
        
        return $this->_helper->redirector('profilo');
               
            
    }
    
    //funzioni per modificare il profilo
    public function modificaprofiloAction()
    {
        
    }
    
    private function getModificaprofiloForm()
    {
    	$urlHelper = $this->_helper->getHelper('url');
		$this->_formModificaprofilo = new Application_Form_Staff_Modificadati_Modificaprofilo();
    	$this->_formModificaprofilo->setAction($urlHelper->url(array(
			'controller' => 'staff',
			'action' => 'modificaprof'),
			'default'
		));
		return $this->_formModificaprofilo;
    }   
     public function modificaprofAction()
	{        
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('modificaprofilo');
        }
        $form = $this->_formModificaprofilo;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('modificaprofilo');
        }
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('modificaprofilo');
        }
        $form=$this->_formModificaprofilo;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('modificaprofilo');
        }  
        $user=$this->_authService->authInfo('username');
        $nome = $this->getRequest()->getParam('nome');
        $cognome = $this->getRequest()->getParam('cognome');
        $genere = $this->getRequest()->getParam('genere');
        $data = $this->getRequest()->getParam('data_nascita');
        $citta = $this->getRequest()->getParam('citta');
        $indirizzo = $this->getRequest()->getParam('indirizzo');
        $tel = $this->getRequest()->getParam('numero_telefono');
        $email = $this->getRequest()->getParam('email');
         
        $info=array('username'=> $user,
            'nome'=> $nome,
            'cognome'=> $cognome,
            'genere'=> $genere,
            'data_nascita'=> $data,
            'citta'=> $citta,
            'indirizzo'=> $indirizzo,
            'numero_telefono'=> $tel,
            'email'=> $email);
	$this->_staffModel->updateProfiloByUser($info); 
        
        return $this->_helper->redirector('profilo');
               
            
	}
        
        
    
    public function profiloAction()
    {
        $user=$this->_authService->authInfo('username');
        $profilo = $this->_staffModel->getStaffByUser($user);
        $this->view->profilo = $profilo;
    }

    public function logoutAction()
	{
		$this->_authService->clear();
		return $this->_helper->redirector('index','public');	
	}
    
}

