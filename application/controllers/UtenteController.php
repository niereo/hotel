<?php

class UtenteController extends Zend_Controller_Action
{	
    protected $_publicModel;
    protected $_utenteModel;
    protected $_staffModel;
    protected $_authService;
    protected $_redirector = null;
    protected $_formModificapassword;
    protected $_formModificaprofilo;
    protected $_formDataprenotazione;
    protected $_formSelezionaservizi;
    protected $_formRicercaservizi;
    protected $_formModificaprenotazione;
    
    public function init()
    {
		$this->_helper->layout->setLayout('layout_utente');
		$this->_authService = new Application_Service_Auth();
                $this->_publicModel = new Application_Model_Public();
                $this->_utenteModel = new Application_Model_Utente();
                $this->_staffModel = new Application_Model_Staff();
                $this->_redirector = $this->_helper->getHelper('Redirector');
                $this->_formDataprenotazione = new Application_Form_Utente_Prenotazioni_Dataprenotazione();
                $this->_formSelezionaservizi = new Application_Form_Utente_Prenotazioni_Selezionaservizi();
                $this->_formModificaprenotazione = new Application_Form_Utente_Prenotazioni_Updateprenotazione();
                
                $this->view->modificapassForm = $this->getModificapasswordForm();
                $this->view->modificaprofiloForm = $this->getModificaprofiloForm();
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
    
    //funzioni per effettuare una prenotazione
    public function listacamereAction(){
        
        $tipo=$this->_getParam('tipo');
        $camere=$this->_utenteModel->getCamereByTipo($tipo,array('prezzo_camera'));
        $this->view->camere=$camere;
    }
    public function disponibilitaAction(){
        $camera=$this->_getParam('camera');
        $prenotazioni=$this->_utenteModel->getPrenotazioniByCamera($camera);
        $pre= new ArrayObject();
        $counter=0;
        
        foreach ($prenotazioni as $prenotazione)
        {
            $dfp=new Zend_Date($prenotazione->data_fine_pren);
            $now=new Zend_Date();
            if(!($dfp->isEarlier($now)))
            {
                $pre[$counter]=$prenotazione;
                $counter++;
            }
            
            
        }
        $urlHelper = $this->_helper->getHelper('url');
	$this->_formDataprenotazione = new Application_Form_Utente_Prenotazioni_Dataprenotazione();
    	$this->_formDataprenotazione->setAction($urlHelper->url(array(
			'controller' => 'utente',
			'action' => 'sceltaservizi'),
			'default'
		));
        $info= array(
            'codice'=>$camera,
        );
        $this->_formDataprenotazione->populate($info);
	$this->view->dataprenotazioneForm=$this->_formDataprenotazione;
        $this->view->prenotazioni=$pre;
        $this->view->Camera=$camera;
    }


    public function sceltaserviziAction()
    {
        $request = $this->getRequest();
        $codice=$this->_getParam('codice');
        if (!$request->isPost()) {
            $this->_redirector->gotoSimple('disponibilita',
                                       'utente',
                                       null,
                                       array('camera' => $codice));
        }
        $form = $this->_formDataprenotazione;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->_redirector->gotoSimple('disponibilita',
                                       'utente',
                                       null,
                                       array('camera' => $codice));
        }
        if (!$this->getRequest()->isPost()) {
            $this->_redirector->gotoSimple('disponibilita',
                                       'utente',
                                       null,
                                       array('camera' => $codice));
        }
        $form=$this->_formDataprenotazione;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->_redirector->gotoSimple('disponibilita',
                                       'utente',
                                       null,
                                       array('camera' => $codice));
        }
       $dataarr = $this->getRequest()->getParam('data_inizio');
       $datapar = $this->getRequest()->getParam('data_fine');
       $cod = new Zend_Session_Namespace('codicecamera');
        
       $codice=$request->getParam('codice');
       $count=$this->_utenteModel->getDisponibilitacamera($codice, $dataarr, $datapar);
           if($count !== 0)
           {
              $form->setDescription('Attenzione: intervallo non valido.');
            return $this->_redirector->gotoSimple('disponibilita',
                                       'utente',
                                       null,
                                       array('camera' => $codice));
           }
       
       
        $codice=$this->_getParam('codice');
        
    $urlHelper = $this->_helper->getHelper('url');
		$this->_formSelezionaservizi = new Application_Form_Utente_Prenotazioni_Selezionaservizi();
    	$this->_formSelezionaservizi->setAction($urlHelper->url(array(
			'controller' => 'utente',
			'action' => 'confermaprenotazione'),
			'default'
		));
        $info= array(
            'codice'=> $request->getParam('codice'),
            'datai' => $dataarr,
            'dataf' => $datapar,
        );
                $this->_formSelezionaservizi->populate($info);
                $this->view->selezionaserviziForm=$this->_formSelezionaservizi;
        
    }
    
    
     public function confermaprenotazioneAction()
	{        
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('catalogocamere');
        }
        $form = $this->_formSelezionaservizi;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('catalogocamere');
        }
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('catalogocamere');
        }
        $form=$this->_formSelezionaservizi;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('catalogocamere');
        }  
       
         $serv = new Zend_Session_Namespace('richiestaservizi');
        $servizi = $this->_publicModel->getServizi();
        $servizisel=new ArrayObject();
        
        $rs=false;
        foreach ($servizi as $serv)
        {
         $nospace= str_replace(' ','', $serv->tipo);
         $servizisel[$serv->tipo]=array('valore'=>$request->getParam($nospace),
                 'tiposervizio'=>$serv );
         if($request->getParam($nospace)){
             $rs=true;
         }
        }
        
         $serv = new Zend_Session_Namespace('richiestaservizi');
         $serv->richiestaservizi = $rs;
        
        $codice=$request->getParam('codice');
        $dataarr=$request->getParam('datai');
        $datapar=$request->getParam('dataf');
        $prenotazione = new Zend_Session_Namespace('data_arrivo');
       $prenotazione = new Zend_Session_Namespace('data_partenza');
       $prenotazione = new Zend_Session_Namespace('giorni');
        $cod=new Zend_Session_Namespace('codicecamera');
        $cod->codicecamera=$codice;
       $prenotazione->data_arrivo=$dataarr;
       $prenotazione->data_partenza=$datapar;
       $daar=new Zend_Date($dataarr);
       $dapa=new Zend_Date($datapar);
       $secondi=$dapa->getTimestamp()-$daar->getTimestamp();
       $giorni=(($secondi/3600)/24)+1;
       $prenotazione->giorni=$giorni;
      
        $camera=$this->_utenteModel->getTipoByCod($codice);
        $listaservizi=new Zend_Session_Namespace('listaservizi');
        $listaservizi->listaservizi=$servizisel;
        $this->view->camera=$camera;
        
    }
    
    public function prenotaAction()
    {
        $user=$this->_authService->authInfo('username');
        
        $oggi=new Zend_Date();
        $datstr=$oggi->toString('yyyy-MM-dd');
        $codice=new Zend_Session_Namespace('codicecamera');
        $prezzo=new Zend_Session_Namespace('costo');
        $listaservizi=new Zend_Session_Namespace('listaservizi');
        $cod=$codice->codicecamera;
        
        $darrivo=$this->getRequest()->getParam('dataarrivo');
        $dpartenza=$this->getRequest()->getParam('datapartenza');
        
         $serv = new Zend_Session_Namespace('richiestaservizi');
         $richiesta=$serv->richiestaservizi;
        
        
        $costo=$prezzo->costo;
        $camera=$this->_utenteModel->getCamereByCodice($cod);
        $giorniname = new Zend_Session_Namespace('giorni');
        $giorni = $giorniname->giorni;
        
       
        
        $info=array(
            'username'=>$user,
            'codice_camera'=>$camera->cod_camera,
            'tipo_camera'=>$camera->tipo,
            'tv'   => $camera->tv,
            'internet' => $camera->internet,
            'data_prenotazione'=>$datstr,
            'data_inizio_pren'=>$darrivo,
            'data_fine_pren'=>$dpartenza,
            'richiesta_servizi'=>$richiesta,
            'prezzo_totale'=>$costo
            );
       $this->_utenteModel->insertPrenotazione($info);
        $codpren=$this->_utenteModel->getCodprenotazioneByDati($cod,$darrivo);
        
        foreach ($listaservizi->listaservizi as $serv)
        {
            $totaleserv = ($serv['tiposervizio']->prezzo_servizio)*$giorni;
            if($serv['valore']== true)
            {
                
                
                $prenserv=array(
                    'cod_prenotazione'=>$codpren->cod_prenotazione,
                    'tipo_servizio'=>$serv['tiposervizio']->tipo,
                    'prezzo'=> $totaleserv
                );
                   $this->_utenteModel->insertPrenotazioneservizi($prenserv);
            }
        }
        
        
        
        
        return $this->_helper->redirector('listaprenotazioni');
    }
    
    
    //funzioni per visulizzare la lista delle prenotazioni
    public function stampaprenotazioneAction()
    {
        $codice=$this->_getParam('codice');
        $pren=$this->_staffModel->getPrenotazioneByCodice($codice);
        $nominativo=$this->_utenteModel->getClienteByUser($pren->username);
        $servizi=$this->_utenteModel->getPrenotazioniByCodPrenot($pren->cod_prenotazione);
        
        $this->view->prenotazione =$pren;
        $this->view->nominativo =$nominativo;
        $this->view->servizi =$servizi;
       
        $this->_helper->layout()->disableLayout();
    }
    public function listaprenotazioniAction()
    {
        $info=$this->_authService->authInfo('username');
        $paged = $this->_getParam('page', 1);
	$preno = $this->_utenteModel->getPrenotazioniByUser($info,$paged,$order=array('data_prenotazione DESC'));
       
        $lista= new ArrayObject();
        $counter=0;
        foreach($preno as $pre)
        {
        
        $servizi=$this->_utenteModel->getPrenotazioniByCodPrenot($pre->cod_prenotazione);
        
        $lista[$counter]= array('prenotazione'=> $pre,
            'servizi'=>$servizi);
        $counter=$counter +1;}        
        
        $this->view->lista = $lista;
        $this->view->prenotazioni = $preno;
        
        
    }
    
     public function deleteprenotazioneAction()
    {
        $codice=$this->_getParam('codice');
        $this->_utenteModel->deletePrenotazioneServByCod($codice);
	$this->_utenteModel->deletePrenotazioneByCod($codice);  
        
        return $this->_helper->redirector('listaprenotazioni');
        
    }
    
    public function modificaprenotazioneAction() {
        $codice=$this->_getParam('codice');
        $prenotazione= $this->_staffModel->getPrenotazioneByCodice($codice);
        $servizi=$this->_utenteModel->getPrenotazioniByCodPrenot($codice);
        $info=array(
            'cod_prenotazione'=>$codice,
            'data_inizio_pren'=>$prenotazione->data_inizio_pren,
            'data_fine_pren'=>$prenotazione->data_fine_pren
        );
        foreach ($servizi as $serv){
            $info[$serv->tipo_servizio]=true;
        }
        $this->_formModificaprenotazione = new Application_Form_Utente_Prenotazioni_Updateprenotazione();
        $this->_formModificaprenotazione->populate($info);
        $urlHelper = $this->_helper->getHelper('url');
	
    	$this->_formModificaprenotazione->setAction($urlHelper->url(array(
			'controller' => 'utente',
			'action' => 'aggiornaprenotazione'),
			'default'
		));
       
        $prenotazioni= $this->_utenteModel->getPrenotazioniByCamera($prenotazione->codice_camera);
        $this->view->prenotazioni = $prenotazioni;
        $this->view->modificaprenotazioneForm=$this->_formModificaprenotazione;
       
    }
    public function aggiornaprenotazioneAction(){
        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('listaprenotazioni');
        }
        $form = $this->_formModificaprenotazione;
        if (!$form->isValid($request->getPost())) {
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
        	return $this->render('listaprenotazioni');
        }
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('listaprenotazioni');
        }
        $form=$this->_formModificaprenotazione;
        if (!$form->isValid($_POST)) { 
            $form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
            return $this->render('listaprenotazioni');
        }  
        $codice = $request->getParam('codice');
        $dataarr = $request->getParam('data_inizio_pren');
        $datapar = $request->getParam('data_fine_pren');
        $disponibilita = $this->_utenteModel->getDisponibilitacamera($codice, $dataarr, $datapar);
        if($disponibilitaponibilita !==0){
            return $this->_redirector->gotoSimple('modificaprenotazione',
                                       'utente',
                                       null,
                                       array('codice' => $codice));
        }
        
        $daar=new Zend_Date($dataarr);
        $dapa=new Zend_Date($datapar);
        $secondi=$dapa->getTimestamp()-$daar->getTimestamp();
        $giorni=(($secondi/3600)/24)+1;
        
        //cancello tutte le prenotazioni dei servizi
        $this->_utenteModel->deletePrenotazioneServByCod($codice);
        //inizializzo il prezzo totale a 0
        $prezzototale = 0;
        
        $servizi = $this->_publicModel->getServizi();
        $richiestaservizi=false;
        //controllo le checkbox una alla volta e in caso
        //aggiungo una prenotazione
        foreach ($servizi as $serv) {
            $valore = $request->getParam($serv->tipo);
            
            if($valore==true){
                $prezzo = $giorni*($serv->prezzo_servizio);
                $ser= array( 
                    'cod_prenotazione'  =>$codice,
                    'tipo_servizio'     =>$serv->tipo,
                    'prezzo'            =>$prezzo
                );
                $totale=$totale+$prezzo;
                $this->_utenteModel->insertPrenotazioneservizi($ser);
                $richiestaservizi=true;
            }
        }
       
        $user = $this->_authService->authInfo('username');
        
        $prenotazione = $this->_staffModel->getPrenotazioneByCodice($codice); 
         $camera= $this->_utenteModel->getCamereByCodice($prenotazione->codice_camera);
         //calcolo il nuovo costo della stanza
         $prezzocamera=$giorni*($camera->prezzo_camera);
         //calcolo il prezzo totale
         $prezzototale=$prezzototale+$prezzocamera;
        $info = array(
                'username' => $user,
                'codice_camera' => $prenotazione->codice_camera,
                'tipo_camera' => $prenotazione->tipo_camera,
                'tv' => $prenotazione->tv,
                'internet' => $prenotazione->internet,
                'data_prenotazione' => $prenotazione->data_prenotazione,
                'data_inizio_pren' => $dataarr,
                'data_fine_pren' => $datapar,
                'richiesta_servizi' => $richiestaservizi,
                'prezzo_totale' => $prezzototale
                
                );
       
        $this->_utenteModel->updatePrenotazione($info,$codice);
        
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
	$catalogo = $this->_publicModel->getTipoCamere();
        $this->view->catalogo = $catalogo;	
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
			'controller' => 'utente',
			'action' => 'ricercaservizi'),
			'default'
		));
		return $this->_formRicercaservizi;
    }

    public function logoutAction()
    {
		$this->_authService->clear();
		return $this->_helper->redirector('index','public');	
    }
    
}

