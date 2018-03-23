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
    protected $_formInsertutente;
    protected $_formUpdateutente;
    protected $_formInserttipo;
    protected $_formUpdatetipo;
    protected $_formInsertcamera;
    protected $_formUpdatecamera;
    protected $_formSelectanno;
    
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
                $this->view->insertipicamereForm = $this->getInserttipocameraForm();
                $this->view->selectannoForm = $this->getSelectannoForm();
                $this->view->insertutenteForm = $this->getInsertUtenteForm();
                $this->_formUpdateservizi = new Application_Form_Admin_Servizi_Updateservizi();
                $this->_formInsertcamera = new Application_Form_Admin_Camere_Insertcamera();
                $this->_formUpdatecamera = new Application_Form_Admin_Camere_Updatecamera();
                $this->_formUpdateutente = new Application_Form_Admin_Utenti_Updateutente();
                $this->_formUpdatetipo = new Application_Form_Admin_Camere_Updatetipo();
                
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
     public function catalogocamereAction()
    {
	$catalogo = $this->_publicModel->getTipoCamere();
        $this->view->catalogo = $catalogo;	
    }
    
    public function listacamereAction(){
        
        $tipo=$this->_getParam('tipo');
        $camere=$this->_utenteModel->getCamereByTipo($tipo);
        $this->view->camere=$camere;
        $this->view->tipo=$tipo;
    }
    //funzioni di inserimeto nuovo tipo camera
    public function inserttipocamereAction()
    {
       
    }
    public function inseriscitipocamereAction()
    {
              
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('inserttipocamere');
        }
        $form = $this->_formInserttipo;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('insertservizi');
        }
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('inserttipocamere');
        }
        $form=$this->_formInserttipo;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('inserttipocamere');
        }
        
        $info = $form->getValues();
        $this->_adminModel->insertTipoCamera($info);
        $this->_helper->redirector('catalogocamere');
    }
    
     private function getInserttipocameraForm()
    {
    	$urlHelper = $this->_helper->getHelper('url');
		$this->_formInserttipo = new Application_Form_Admin_Camere_Inserttipo();
    	$this->_formInserttipo->setAction($urlHelper->url(array(
			'controller' => 'admin',
			'action' => 'inseriscitipocamere'),
			'default'
		));
		return $this->_formInserttipo;
    }
    //modifica tipi camere
     public function updatetipicamereAction()
    {
        $codice=$this->_getParam('tipo');
        $tipo=$this->_adminModel->getTipoCameraByTipo($codice);
        $info=array(
            'tipovecchio'=>$tipo->tipo,
            'tipo'=>$tipo->tipo,
          'foto'=>$tipo->foto,
          'descrizione'=>$tipo->descrizione
        );
        $this->_formUpdatetipo = new Application_Form_Admin_Camere_Updatetipo();
        $this->_formUpdatetipo->populate($info);
        $urlHelper = $this->_helper->getHelper('url');
	
    	$this->_formUpdatetipo->setAction($urlHelper->url(array(
			'controller' => 'admin',
			'action' => 'aggiornatipicamere'),
			'default'
		));
       
        
        $this->view->updatetipicamereForm=$this->_formUpdatetipo;
       
    }
   
    public function aggiornatipicamereAction()
	{        
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('catalogocamere');
        }
        $form = $this->_formUpdatetipo;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('catalogocamere');
        }
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('catalogocamere');
        }
        $form=$this->_formUpdatetipo;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('catalogocamere');
        }     
         $codice = $form->getValue('tipovecchio');
         $info=array(
             'tipo'=>$form->getValue('tipo'),
             'foto'=>$form->getValue('foto'),
             'descrizione'=>$form->getValue('descrizione')
         );
         if($info['foto']==null)
         {
             $camera=$this->_adminModel->getTipoCameraByTipo($codice);
             $foto=$camera->foto;
             $info['foto']=$foto;
         }
        $this->_adminModel->updateTipoCamera($info,$codice);
        return $this->_helper->redirector('catalogocamere');       
    }
    //cancellazione tipi camere
     public function deletetipicamereAction()
    {
        $codice=$this->_getParam('tipo');
        $this->_adminModel->deleteTipoCamera($codice);
        $this->_adminModel->deleteCamereByTipo($codice);
        $this->_helper->redirector('catalogocamere');
    }
    //funzioni per inserimento di una nuova camera
    
    public function insertcameraAction()
    {
        $tipo=$this->_getParam('tipo');
        
        $urlHelper = $this->_helper->getHelper('url');
	$this->_formInsertcamera = new Application_Form_Admin_Camere_Insertcamera();
        $this->_formInsertcamera->populate(array(
            'tipo'  =>  $tipo
                                ));
    	$this->_formInsertcamera->setAction($urlHelper->url(array(
			'controller' => 'admin',
			'action' => 'inseriscicamera'),
			'default'
		));
        
       $this->view->insertcameraForm=$this->_formInsertcamera;
    }
    public function inseriscicameraAction()
    {
              
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('insertcamera');
        }
        $form = $this->_formInsertcamera;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('insertservizi');
        }
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('insertcamera');
        }
        $form=$this->_formInsertcamera;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('insertcamera');
        }
        
        $info = $form->getValues();
        $this->_adminModel->insertCamera($info);
        $this->_helper->redirector('catalogocamere');
    }
    //funzioni per la modifica di una camera
    public function updatecameraAction()
    {
        $codice=$this->_getParam('camera');
        $camera = $this->_utenteModel->getCamereByCodice($codice);
        
        $info=array(
          'cod_camera'     => $camera->cod_camera,
          'tipo'           =>$camera->tipo,
          'foto'          =>$camera->foto,
          'prezzo_camera'   =>$camera->prezzo_camera,
          'tv'              =>$camera->tv,
          'internet'        =>$camera->internet
        );
        $this->_formUpdatecamera = new Application_Form_Admin_Camere_Updatecamera();
        $this->_formUpdatecamera->populate($info);
        $urlHelper = $this->_helper->getHelper('url');
	
    	$this->_formUpdatecamera->setAction($urlHelper->url(array(
			'controller' => 'admin',
			'action' => 'aggiornacamera'),
			'default'
		));
       
        
        $this->view->updatecameraForm=$this->_formUpdatecamera;
        
       
    }
   
    public function aggiornacameraAction()
	{        
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('catalogocamere');
        }
        $form = $this->_formUpdatecamera;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('catalogocamere');
        }
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('catalogocamere');
        }
        $form=$this->_formUpdatecamera;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('catalogocamere');
        }     
  
         $info= array(
             'cod_camera'       => $request->getParam('cod_camera'),
             'tipo'             => $request->getParam('tipo'),
             'foto'             => $request->getParam('foto'),
             'prezzo_camera'    => $request->getParam('prezzo_camera'),
             'tv'               => $request->getParam('tv'),
             'internet'         => $request->getParam('internet')
         );
                 
         
         if($info['foto']==null)
         {
             $camera=$this->_utenteModel->getCamereByCodice($info['cod_camera']);
             $foto=$camera->foto;
             $info['foto']=$foto;
         }
         
        $this->_adminModel->updateCamera($info);
        return $this->_helper->redirector('catalogocamere');       
    }
    //funzioni per la cancellazione di una camera
    public function deletecameraAction() 
    {
      $camera = $this->_getParam('camera');
      $this->_adminModel->deleteCamera($camera);
      $this->_helper->redirector('catalogocamere');
    } 
    //funzioni inserimento nuovo utente
     public function insertutenteAction()
    {
        
    }
    
    	private function getInsertUtenteForm()
    {
    	$urlHelper = $this->_helper->getHelper('url');
		$this->_formInsertutente = new Application_Form_Admin_Utenti_Insertutente();
    	$this->_formInsertutente->setAction($urlHelper->url(array(
			'controller' => 'admin',
			'action' => 'inserisciutente'),
			'default'
		));
		return $this->_formInsertutente;
    }   
    
    public function inserisciutenteAction()
	{        
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('insertutente');
        }
        $form = $this->_formInsertutente;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('insertutente');
        }
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('insertutente');
        }
  $form=$this->_formInsertutente;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('insertutente');
        } 

    $username = $this->getRequest()->getParam('username');
    $ruolo = $this->getRequest()->getParam('ruolo');
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
      'ruolo' => $ruolo);
     if($ruolo == 'utente')
     {$this->_publicModel->insertCliente($cli);}
        else {$this->_adminModel->insertStaff($cli);}
    $this->_publicModel->insertUtente($info);
        return $this->_helper->redirector('index');
	}
   //funzioni modifica e cancella utente
       public function listastaffAction()
       {
           $staff=$this->_adminModel->getDipendenti();
           $this->view->staff =$staff;
       }
        public function listaclientiAction()
       {
           $clienti=$this->_staffModel->getClienti();
           $this->view->clienti =$clienti;
       }
       
        public function updateutenteAction()
    {
        $user=$this->_getParam('username');
        $account=$this->_utenteModel->getUtenteByName($user);
        if($account->ruolo == 'utente')
        {$utente=$this->_utenteModel->getClienteByUser($user);}
        else {
            $utente=$this->_staffModel->getStaffByUser($user);
        }
        
        $info=array(
            'ruolo'=>$account->ruolo,
            'username'=>$user,
            'cognome'=>$utente->cognome,
          'nome'=>$utente->nome,
          'genere'=>$utente->genere,
          'data_nascita'=>$utente->data_nascita,
            'citta'=>$utente->citta,
            'indirizzo'=>$utente->indirizzo,
            'numero_telefono'=>$utente->numero_telefono,
            'email'=>$utente->email
        );
        $this->_formUpdateutente = new Application_Form_Admin_Utenti_Updateutente();
        $this->_formUpdateutente->populate($info);
        $urlHelper = $this->_helper->getHelper('url');
	
    	$this->_formUpdateutente->setAction($urlHelper->url(array(
			'controller' => 'admin',
			'action' => 'aggiornautente'),
			'default'
		));
       
        
        $this->view->updateutenteForm=$this->_formUpdateutente;
       
    }
   
    public function aggiornautenteAction()
	{        
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('updateutente');
        }
        $form = $this->_formUpdateutente;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('updateutente');
        }
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('updateutente');
        }
        $form=$this->_formUpdateutente;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('updateutente');
        }     
         $ruolo = $form->getValue('ruolo');
          $info=array(
              'username'=>$form->getValue('username'),
            'cognome'=>$form->getValue('cognome'),
          'nome'=>$form->getValue('nome'),
          'genere'=>$form->getValue('genere'),
          'data_nascita'=>$form->getValue('data_nascita'),
            'citta'=>$form->getValue('citta'),
            'indirizzo'=>$form->getValue('indirizzo'),
            'numero_telefono'=>$form->getValue('numero_telefono'),
            'email'=>$form->getValue('email')
        );
          if($ruolo == 'utente')
          {$this->_utenteModel->updateProfiloByUser($info);
          return $this->_helper->redirector('listaclienti');
          }
          else 
          {$this->_staffModel->updateProfiloByUser($info); 
          return $this->_helper->redirector('listastaff');
          }
               
    }
         public function cancellaclienteAction()
    {
        $user=$this->_getParam('username');
        $this->_adminModel->deleteCliente($user);
        $this->_adminModel->deleteUtente($user);
        $this->_helper->redirector('listaclienti');
    }
        public function cancellastaffAction()
    {
        $user=$this->_getParam('username');
        $this->_adminModel->deleteStaff($user);
        $this->_adminModel->deleteUtente($user);
        $this->_helper->redirector('listastaff');
    }
        
    //funzioni per i servizi
      public function catalogoserviziAction()
    {
        $paged = $this->_getParam('page', 1);
	$servizi = $this->_publicModel->getServizi($paged);
        $this->view->servizi = $servizi;
    }
    //inserimento servizi
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
    //modifica servizi
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
    //cancellazione servizi
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
        $camera=$this->_utenteModel->getCamere(array('prezzo_camera'));
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
   
    public function annoincassiAction() {
        
    }
    
    private function getSelectannoform()
    {
    	$urlHelper = $this->_helper->getHelper('url');
    $this->_formSelectanno = new Application_Form_Admin_Incassi_Selectanno();
    	$this->_formSelectanno->setAction($urlHelper->url(array(
			'controller' => 'admin',
			'action' => 'incassi'),
			'default'
		));
		return $this->_formSelectanno;
    } 
    
    public function incassiAction()
    {
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('annoincassi');
        }
        $form = $this->_formSelectanno;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('annoincassi');
        }
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('annoincassi');
        }
        $form=$this->_formSelectanno;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('annoincassi');
        }
        $anno = $request->getParam('anno');
        $camera = $request->getParam('camera');
        $servizi = $request->getParam('servizi');
        $prenotazioni=$this->_adminModel->getIncassi($anno,$camera,$servizi);
        
        $anno = array(
            1       => array(
                'valore'    =>  0,
                'mese'      =>  'Gennaio'
            ),
            2       => array(
                'valore'    =>  0,
                'mese'      =>  'Febbraio'
            ),
            3       => array(
                'valore'    =>  0,
                'mese'      =>  'Marzo'
            ),
            4       => array(
                'valore'    =>  0,
                'mese'      =>  'Aprile'
            ),
            5       => array(
                'valore'    =>  0,
                'mese'      =>  'Maggio'
            ),
            6       => array(
                'valore'    =>  0,
                'mese'      =>  'Giugno'
            ),
            7       => array(
                'valore'    =>  0,
                'mese'      =>  'Luglio'
            ),
            8       => array(
                'valore'    =>  0,
                'mese'      =>  'Agosto'
            ),
            9       => array(
                'valore'    =>  0,
                'mese'      =>  'Settembre'
            ),
            10      => array(
                'valore'    =>  0,
                'mese'      =>  'Ottobre'
            ),
            11      => array(
                'valore'    =>  0,
                'mese'      =>  'Novembre'
            ),
            12      => array(
                'valore'    =>  0,
                'mese'      =>  'Dicembre'
            )
        );
        $totale=0;
        $dataarrivo;
        foreach($prenotazioni as $pren){
           $totale=$totale+$pren->prezzo_totale;
           $data = $pren->data_inizio_pren;
           $datazend = new Zend_Date($data);
           $dataarray = $datazend->toArray();
           $mese =$dataarray['month'];
                   
           $anno[$mese]['valore']=$anno[$mese]['valore']+$pren->prezzo_totale;  
           
        }
       
        $this->view->totale = $totale;
        $this->view->incassi =  $anno;
         $this->view->roba= $prenotazioni;
    }


    public function logoutAction()
	{
		$this->_authService->clear();
		return $this->_helper->redirector('index','public');	
	}
    
}

