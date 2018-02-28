<?php

class Application_Form_Staff_Prenotazioni_Listaprenotazioni extends App_Form_Abstract
{
    
    
    protected $_utenteModel;
    protected $_staffModel;
    protected $_publicModel;
	public function init()
    {               
          
        $this->setMethod('post');
        $this->setName('listaprenotazioni');
        $this->setAction('');
        $this->_publicModel = new Application_Model_Public();
        $this->_utenteModel = new Application_Model_Utente();
        $this->_staffModel = new Application_Model_Staff();
             
        $camere=$this->_utenteModel->getCamere();
    	$sceltacamere = array();
         $sceltacamere['Qualsiasi']='Qualsiasi';
        foreach ($camere as $camera)
        {
            $sceltacamere[$camera->cod_camera]=$camera->cod_camera;
        }
            $this->addElement('select', 'camera', array(
            'label' => 'Filtra per Camera',
            'filters' => array('StringTrim'),
            'multiOptions' => $sceltacamere,
            'decorators' => $this->elementDecorators,
        ));
             $nominativi=$this->_staffModel->getClienti();
        $sceltanome = array();
        
        $sceltanome['Qualsiasi']='Qualsiasi';
        foreach ($nominativi as $nominativo)
        {
            $sceltanome[$nominativo->username]=$nominativo->cognome.' '.$nominativo->nome;
        }
            $this->addElement('select', 'nominativo', array(
            'label' => 'Filtra per Nominativo',
            'filters' => array('StringTrim'),
            'multiOptions' => $sceltanome,
            'decorators' => $this->elementDecorators,
        ));
            $servizi=$this->_publicModel->getServizi();
    	$sceltaservizi = array();
             $sceltaservizi['Qualsiasi']='Qualsiasi';
             $sceltaservizi['Nessuno']='Nessuno';
        foreach ($servizi as $servizio)
        {
            $sceltaservizi[$servizio->tipo]=$servizio->tipo;
        }
             $this->addElement('select', 'servizi', array(
            'label' => 'Filtra per Servizio',
            'filters' => array('StringTrim'),
            'multiOptions' => $sceltaservizi,
            'decorators' => $this->elementDecorators,
        ));
             
             		
		$date = new Zend_Validate_Date(array('format' => 'yyyy-MM-dd'));$date->setMessage("Il campo deve contenere caratteri numerici che rispettano il formato 'yyyy-MM-dd' ");
		
		$this->addElement('text', 'data_inizio', array(
            'label' => 'DAL',
            
	    'filters' => array('StringTrim'),
            'validators' => array($date),
            'decorators' => $this->elementDecorators,
        ));
                
                $this->addElement('text', 'data_fine', array(
            'label' => 'AL',
            
	    'filters' => array('StringTrim'),
            'validators' => array($date),
            'decorators' => $this->elementDecorators,
        ));
			
        $this->addElement('submit', 'insert', array(
            'label' => 'Conferma',
        	'decorators' => $this->buttonDecorators,
        ));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
        	array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
        
    }
}
