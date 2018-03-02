<?php

class AdminController extends Zend_Controller_Action
{	
    protected $_staffModel;
    protected $_utenteModel;
    protected $_authService;
    protected $_formModificapassword;
    protected $_formModificaprofilo;
    protected $_formListaprenotazioni;
    public function init()
    {
		$this->_helper->layout->setLayout('layout_admin');
		$this->_authService = new Application_Service_Auth();
                $this->_staffModel = new Application_Model_Staff();
                $this->_utenteModel = new Application_Model_Utente();
                $this->view->modificapassForm = $this->getModificapasswordForm();
                $this->view->modificaprofiloForm = $this->getModificaprofiloForm();
                $this->view->listaprenotazioniForm = $this->getListaprenotazioniForm();
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
			'controller' => 'admin',
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
        $info=array('username'=>$user,'password'=>$pass,'ruolo'=>'admin');
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
			'controller' => 'admin',
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
     public function disponibilitaAction()
    {
        $camera=$this->_utenteModel->getCamere();
        $disponibilita=new ArrayObject();
        foreach ($camera as $cam)
        {
            $pren=$this->_staffModel->getDisponibilitaByCamera($cam->cod_camera);
            $disponibilita[$cam->cod_camera]=array(
                    'prenotazione'=>$pren,
                    'camera'=>$cam);
        }
      $this->view->disponibile=$disponibilita;  
    }
   public function filtraprenotazioniAction()
    {
        
    }
    public function dettagliprenAction()
    {
        $codice=$this->_getParam('codicepren');
        $prenotazione=$this->_staffModel->getPrenotazioneByCodice($codice);
        $servizi=$this->_utenteModel->getPrenotazioniByCodPrenot($codice);
        $nominativo=$this->_utenteModel->getClienteByUser($prenotazione->username);
        $camera=$this->_utenteModel->getTipoByCod($prenotazione->codice_camera);
        $this->view->dettagli=array(
            'prenotazione'=>$prenotazione,
            'servizi'=>$servizi,
            'nominativo'=>$nominativo,
            'camera'=>$camera
        );
    }
    public function listaprenotazioniAction()
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('filtraprenotazioni');
        }
        $form = $this->_formListaprenotazioni;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('filtraprenotazioni');
        }
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('filtraprenotazioni');
        }
        $form=$this->_formListaprenotazioni;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('filtraprenotazioni');
        } 
        $datain=$request->getParam('data_inizio');
        $datafin=$request->getParam('data_fine');
        $di=new Zend_Date();
        $df=new Zend_Date();
        if($datain == "")
        {
            $di=new Zend_Date('0001-01-01');
           
        }else $di= new Zend_Date($datain);
        if($datafin == "")
        {
            $df=new Zend_Date('9999-12-31');
        }else $df= new Zend_Date($datafin);   
        if($di->isLater($df))
        {
            $form->setDescription('Attenzione:la data di inizio non può essere successiva a quella di fine.');
            return $this->render('filtraprenotazioni');
        }
        
        $nominativo=$request->getParam('nominativo');
        $camera=$request->getParam('camera');
        $servizi=$request->getParam('servizi');
        $counter=0;
        $listaprenot=new ArrayObject();
        $prenotazioni=$this->_staffModel->getPrenotazioniByFiltri($nominativo,$camera,$servizi);
        $pre= new ArrayObject();
        $counter=0;
        
        foreach ($prenotazioni as $prenotazione)
        {
            $dip=new Zend_Date($prenotazione->data_inizio_pren);
            $dfp=new Zend_Date($prenotazione->data_fine_pren);
            
            if((!($dip->isEarlier($di)) && !($dip->isLater($df))) || (!($dfp->isEarlier($di)) && !($dfp->isLater($df))) || (!($dip->isLater($di)) && !($dfp->isEarlier($df))) )
            {
                $pre[$counter]=$prenotazione;
                $counter++;
            }
            
            
        }
        
        foreach ($pre as $pren)
        {
            $nome=$this->_utenteModel->getClienteByUser($pren->username);
            $cod=$pren->cod_prenotazione;
            $servizi=$this->_utenteModel->getPrenotazioniByCodPrenot($pren->cod_prenotazione);
            $listaprenot[$counter]=array(
                'prenotazione'=>$pren,
                'nominativo'=>$nome,
                'servizi'=>$servizi
            );
            $counter++;
        }

        $this->view->listapren=$listaprenot;
    }
     private function getListaprenotazioniForm()
    {
    	$urlHelper = $this->_helper->getHelper('url');
		$this->_formListaprenotazioni = new Application_Form_Staff_Prenotazioni_Listaprenotazioni();
    	$this->_formListaprenotazioni->setAction($urlHelper->url(array(
			'controller' => 'admin',
			'action' => 'listaprenotazioni'),
			'default'
		));
		return $this->_formListaprenotazioni;
    } 
    public function logoutAction()
	{
		$this->_authService->clear();
		return $this->_helper->redirector('index','public');	
	}
    
}

