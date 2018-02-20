<?php

class UtenteController extends Zend_Controller_Action
{	
    protected $_publicModel;
    protected $_utenteModel;
    protected $_authService;
    protected $_formModificapassword;
    protected $_formModificaprofilo;
    protected $_formDataprenotazione;
    
    public function init()
    {
		$this->_helper->layout->setLayout('layout_utente');
		$this->_authService = new Application_Service_Auth();
                $this->_publicModel = new Application_Model_Public();
                $this->_utenteModel = new Application_Model_Utente();
                $this->view->modificapassForm = $this->getModificapasswordForm();
                $this->view->modificaprofiloForm = $this->getModificaprofiloForm();
                $this->view->dataprenotazioneForm = $this->getDataprenotazioneForm();
                
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
    
    //funzioni per effettuare una prenotazione
    public function dataprenotazioneAction()
    {
		
    }
    
     private function getDataprenotazioneForm()
    {
    	$urlHelper = $this->_helper->getHelper('url');
		$this->_formDataprenotazione = new Application_Form_Utente_Prenotazioni_Dataprenotazione();
    	$this->_formDataprenotazione->setAction($urlHelper->url(array(
			'controller' => 'utente',
			'action' => 'index'),
			'default'
		));
		return $this->_formDataprenotazione;
    }   
    
    
    //funzioni per visulizzare la lista delle prenotazioni
    public function listaprenotazioniAction()
    {
        $info=$this->_authService->authInfo('username');
	$preno = $this->_utenteModel->getPrenotazioniByUser($info);
       
        $lista= new ArrayObject();
        $counter=0;
        foreach($preno as $pre)
        {$tipo=$this->_utenteModel->getTipoByCod($pre->codice_camera);
        
        $lista[$counter]= array('prenotazione'=> $pre,
            'tipo'=> $tipo);
        $counter=$counter +1;}        
        
        $this->view->lista = $lista;
        
        
    }
    
     public function deleteprenotazioneAction()
    {
        $codice=$this->_getParam('codice');
	$this->_utenteModel->deletePrenotazioneByCod($codice);     
        return $this->_helper->redirector('listaprenotazioni');
        
    }
    
    //funzioni per modificare la password
    public function modificapasswordAction()
    {
        
    }
    private function getModificapasswordForm()
    {
    	$urlHelper = $this->_helper->getHelper('url');
		$this->_formModificapassword = new Application_Form_Utente_Modificadati_Modificapassword();
    	$this->_formModificapassword->setAction($urlHelper->url(array(
			'controller' => 'utente',
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
        $info=array('username'=>$user,'password'=>$pass,'ruolo'=>'utente');
	$this->_utenteModel->updatePassByUser($info); 
        
        return $this->_helper->redirector('profilo');
               
            
    }
    
    //funzioni per modificare il profilo
    public function modificaprofiloAction()
    {
        
    }
    
    private function getModificaprofiloForm()
    {
    	$urlHelper = $this->_helper->getHelper('url');
		$this->_formModificaprofilo = new Application_Form_Utente_Modificadati_Modificaprofilo();
    	$this->_formModificaprofilo->setAction($urlHelper->url(array(
			'controller' => 'utente',
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
	$this->_utenteModel->updateProfiloByUser($info); 
        
        return $this->_helper->redirector('profilo');
               
            
	}
        
        
    
    public function profiloAction()
    {
        $user=$this->_authService->authInfo('username');
        $profilo = $this->_utenteModel->getClienteByUser($user);
        $this->view->profilo = $profilo;
    }
     public function faqAction()
    {
         
        $faq = $this->_publicModel->getFaq();
        $this->view->faq = $faq;
    }
    
    public function catalogocamereAction()
    {
	$catalogo = $this->_publicModel->getCamere();
        $this->view->catalogo = $catalogo;	
    }
    
    public function catalogoserviziAction()
    {
	$servizi = $this->_publicModel->getServizi();
        $this->view->servizi = $servizi;
    }

    public function logoutAction()
    {
		$this->_authService->clear();
		return $this->_helper->redirector('index','public');	
    }
    
}

