<?php

class AdminController extends Zend_Controller_Action
{	
    protected $_staffModel;
    protected $_utenteModel;
    protected $_publicModel;
    protected $_adminModel;
    protected $_authService;
    protected $_formModificapassword;
    protected $_formModificaprofilo;
    protected $_formListaprenotazioni;
    protected $_formInsertfaq;
    protected $_formUpdatefaq;
    protected $_formInsertservizi;
    protected $_formUpdateservizi;
    public function init()
    {
		$this->_helper->layout->setLayout('layout_admin');
		$this->_authService = new Application_Service_Auth();
                $this->_staffModel = new Application_Model_Staff();
                $this->_publicModel = new Application_Model_Public();
                $this->_utenteModel = new Application_Model_Utente();
                $this->_adminModel = new Application_Model_Admin();
                $this->view->modificapassForm = $this->getModificapasswordForm();
                $this->view->modificaprofiloForm = $this->getModificaprofiloForm();
                $this->view->listaprenotazioniForm = $this->getListaprenotazioniForm();
                $this->view->insertfaqForm = $this->getInsertfaqForm();
                $this->_formUpdatefaq = new Application_Form_Admin_Faq_Updatefaq();
                $this->view->insertserviziForm = $this->getInsertserviziForm();
                $this->_formUpdateservizi = new Application_Form_Admin_Servizi_Updateservizi();
                
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
   
    //funzioni per i servizi
      public function catalogoserviziAction()
    {
        $paged = $this->_getParam('page', 1);
	$servizi = $this->_publicModel->getServizi($paged);
        $this->view->servizi = $servizi;
    }
     public function insertserviziAction()
    {
        
    }
    public function inserisciserviziAction()
    {
              
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('insertservizi');
        }
        $form = $this->_formInsertservizi;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('insertservizi');
        }
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('insertservizi');
        }
        $form=$this->_formInsertservizi;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('insertservizi');
        }
        
        $info = $form->getValues();
        $this->_adminModel->insertServizi($info);
        $this->_helper->redirector('catalogoservizi');
    }
    
     private function getInsertserviziForm()
    {
    	$urlHelper = $this->_helper->getHelper('url');
		$this->_formInsertservizi = new Application_Form_Admin_Servizi_Insertservizi();
    	$this->_formInsertservizi->setAction($urlHelper->url(array(
			'controller' => 'admin',
			'action' => 'inserisciservizi'),
			'default'
		));
		return $this->_formInsertservizi;
    }   
     public function updateserviziAction()
    {
        $codice=$this->_getParam('tipo');
        $servizi=$this->_adminModel->getServiziByTipo($codice);
        $info=array(
            'tipovecchio'=>$servizi->tipo,
            'tipo'=>$servizi->tipo,
          'prezzo_servizio'=>$servizi->prezzo_servizio,
          'foto'=>$servizi->foto,
          'descrizione'=>$servizi->descrizione
        );
        $this->_formUpdateservizi = new Application_Form_Admin_Servizi_Updateservizi();
        $this->_formUpdateservizi->populate($info);
        $urlHelper = $this->_helper->getHelper('url');
	
    	$this->_formUpdateservizi->setAction($urlHelper->url(array(
			'controller' => 'admin',
			'action' => 'aggiornaservizi'),
			'default'
		));
       
        
        $this->view->updateserviziForm=$this->_formUpdateservizi;
       
    }
   
    public function aggiornaserviziAction()
	{        
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('catalogoservizi');
        }
        $form = $this->_formUpdateservizi;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('catalogoservizi');
        }
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('catalogoservizi');
        }
        $form=$this->_formUpdateservizi;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('catalogoservizi');
        }     
         $codice = $form->getValue('tipovecchio');
         $info=array(
             'tipo'=>$form->getValue('tipo'),
             'prezzo_servizio'=>$form->getValue('prezzo_servizio'),
             'foto'=>$form->getValue('foto'),
             'descrizione'=>$form->getValue('descrizione')
         );
         if($info['foto']==null)
         {
             $serv=$this->_adminModel->getServiziByTipo($codice);
             $foto=$serv->foto;
             $info['foto']=$foto;
         }
        $this->_adminModel->updateServizi($info,$codice);
        return $this->_helper->redirector('catalogoservizi');       
    }
     public function deleteserviziAction()
    {
        $codice=$this->_getParam('tipo');
        $this->_adminModel->deleteServizi($codice);
        $this->_helper->redirector('catalogoservizi');
    }
    //funzioni per le faq
   
    public function faqAction()
    {
         $this->view->headTitle( 'Elenco delle F.A.Q.' );
        $faq=$this->_publicModel->getFaq();
        $this->view->faq = $faq;
    }
    public function insertfaqAction()
    {
        
    }
    public function inseriscifaqAction()
    {
              
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('inseriscifaq');
        }
        $form = $this->_formInsertfaq;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('inseriscifaq');
        }
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('inseriscifaq');
        }
        $form=$this->_formInsertfaq;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('inseriscifaq');
        }
        $domanda=$this->getRequest()->getParam('domanda');
        $risposta=$this->getRequest()->getParam('risposta');
        $faq= array(
            'domanda'=>$domanda,
            'risposta'=>$risposta
        );
        $this->_adminModel->insertfaq($faq);
        $this->_helper->redirector('faq');
    }
    
     private function getInsertfaqForm()
    {
    	$urlHelper = $this->_helper->getHelper('url');
		$this->_formInsertfaq = new Application_Form_Admin_Faq_Insertfaq();
    	$this->_formInsertfaq->setAction($urlHelper->url(array(
			'controller' => 'admin',
			'action' => 'inseriscifaq'),
			'default'
		));
		return $this->_formInsertfaq;
    }   
    
     public function updatefaqAction()
    {
        $codice=$this->_getParam('id');
        $faq=$this->_adminModel->getFaqByCod($codice);
        $info=array(
            'id'=>$faq->id,
          'domanda'=>$faq->domanda,
          'risposta'=>$faq->risposta
        );
        $this->_formUpdatefaq = new Application_Form_Admin_Faq_Updatefaq();
        $this->_formUpdatefaq->populate($info);
        $urlHelper = $this->_helper->getHelper('url');
	
    	$this->_formUpdatefaq->setAction($urlHelper->url(array(
			'controller' => 'admin',
			'action' => 'aggiornafaq'),
			'default'
		));
       
        
        $this->view->updatefaqForm=$this->_formUpdatefaq;
       
    }
   
    public function aggiornafaqAction()
	{        
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('faq');
        }
        $form = $this->_formUpdatefaq;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('faq');
        }
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('faq');
        }
        $form=$this->_formUpdatefaq;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('faq');
        }     
        $id=$request->getParam('id');
        $domanda=$request->getParam('domanda');
        $risposta=$request->getParam('risposta');
        $info=array(
            'id'=> $id,
            'domanda' => $domanda,
            'risposta' => $risposta
        );
        $this->_adminModel->updateFaq($info);
        return $this->_helper->redirector('faq');       
    }
    public function deletefaqAction()
    {
        $codice=$this->_getParam('id');
        $this->_adminModel->deleteFaq($codice);
        $this->_helper->redirector('faq');
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
            'nominativo'=>$nominativo
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
            $form->setDescription('Attenzione:la data di inizio non puÃ² essere successiva a quella di fine.');
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

