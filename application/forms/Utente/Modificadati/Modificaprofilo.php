<?php

class Application_Form_Utente_Modificadati_Modificaprofilo extends App_Form_Abstract
{
    protected $_authService;
    protected $_notId;
    protected $_utenteModel;
	public function init()
    {               
        $this->_authService = new Application_Service_Auth();   
        $this->setMethod('post');
        $this->setName('modificaprofilo');
        $this->setAction('');
        $this->_utenteModel = new Application_Model_Utente;
        $user = $this->_authService->authInfo('username');
        $cliente = $this->_utenteModel->getClienteByUser($user);
    	
        
        $this->addElement('text', 'cognome', array(
            'label' => 'Cognome',
            'value' => $cliente->cognome,
            'required' =>true, 
            'filters' => array('StringTrim'),
            'validators' => array(array('StringLength',true, array(1,25))),
            'decorators' => $this->elementDecorators,
        ));
       
        
        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'value' => $cliente->nome,
            'required' =>true,
            'filters' => array('StringTrim'),
            'validators' => array(array('StringLength',true, array(1,25))),
            'decorators' => $this->elementDecorators,
        ));


        $this->addElement('select', 'genere', array(
            'label' => 'Genere',
            'value' => $cliente->genere,
            'filters' => array('StringTrim'),
            'multiOptions' => array(
			'M' => 'M',
			'F' => 'F'),
            
            'decorators' => $this->elementDecorators,
        ));
					
		$date = new Zend_Validate_Date(array('format' => 'yyyy-MM-dd'));$date->setMessage("Il campo Data di Nascita deve contenere caratteri numerici che rispettano il formato 'yyyy-MM-dd' ");
		
		$this->addElement('text', 'data_nascita', array(
            'label' => 'Data di Nascita',
            'value' => $cliente->data_nascita,
            'required' =>true,
			'filters' => array('StringTrim'),
            'validators' => array($date),
            'decorators' => $this->elementDecorators,
        ));
                
                
                
                 $this->addElement('text', 'citta', array(
            'label' => 'Città',
            'value' => $cliente->citta,         
            'required' =>true,
            'filters' => array('StringTrim'),
            'validators' => array(array('StringLength',true, array(1,25))),
            'decorators' => $this->elementDecorators,
        ));
                 
                  $this->addElement('text', 'indirizzo', array(
            'label' => 'Indirizzo',
            'value' => $cliente->indirizzo,
            'required' =>true,
            'validators' => array(array('StringLength',true, array(1,25))),
            'decorators' => $this->elementDecorators,
        ));
	$tel = new Zend_Validate_Digits();$tel->setMessage("Il campo Numero di Telefono deve contenere solo numeri");	
        $this->addElement('text', 'numero_telefono', array(
            'label' => 'Numero di Telefono',
            'value' => $cliente->numero_telefono,
            'required' =>true,
            'validators' => array($tel,array('StringLength',true, array(1,10))),
            'decorators' => $this->elementDecorators,
        ));
        
         $email = new Zend_Validate_EmailAddress();
		
		$this->addElement('text', 'email', array(
            'label' => 'Email',
            'value' => $cliente->email,
            'required' =>true,
	    'filters' => array('StringTrim'),
            'validators' => array($email),
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
