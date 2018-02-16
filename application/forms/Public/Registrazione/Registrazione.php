<?php
class Application_Form_Public_Registrazione_Registrazione extends App_Form_Abstract
{
	protected $_adminModel;
	    
    public function init()
    {
        $this->setMethod('post');
        $this->setName('registrazione');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
		
		$this->_adminModel = new Application_Model_Admin();
		
		$cod_noexists = new Zend_Validate_Db_NoRecordExists(array('table'=>'utente', 'field'=>'username'));
		
		$cod_noexists->setMessage('%value% esiste già, usare un altro codice',Zend_Validate_Db_Abstract::ERROR_RECORD_FOUND);
		
$this->addElement('text', 'username', array(
            'label' => 'Username',
            'filters' => array('StringTrim'),
           	'required' => true,
            'validators' => array($cod_noexists),
            'decorators' => $this->elementDecorators,
        ));
			
 $this->addElement('text', 'cognome', array(
            'label' => 'Cognome',
            'required' =>true,
            'filters' => array('StringTrim'),
            'validators' => array(array('StringLength',true, array(1,25))),
            'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('text', 'nome', array(
            'label' => 'Nome',
            'required' =>true,
            'filters' => array('StringTrim'),
            'validators' => array(array('StringLength',true, array(1,25))),
            'decorators' => $this->elementDecorators,
        ));

//questa va dentro account
 $this->addElement('password', 'password', array(
            'label' => 'Password',
            'required' =>true,
            'filters' => array('StringTrim'),
            'validators' => array(array('StringLength',true, array(1,20))),
            'decorators' => $this->elementDecorators,
        ));
 
  $this->addElement('select', 'genere', array(
            'label' => 'Genere',
            'filters' => array('StringTrim'),
            'multiOptions' => array(
			'M' => 'M',
			'F' => 'F'),
            'decorators' => $this->elementDecorators,
        ));
					
		$date = new Zend_Validate_Date(array('format' => 'dd MM yyyy'));$date->setMessage("Il campo Data di Nascita deve contenere caratteri numerici che rispettano il formato 'dd MM yyyy' ");
		
		$this->addElement('text', 'data_nascita', array(
            'label' => 'Data di Nascita',
            'required' =>true,
			'filters' => array('StringTrim'),
            'validators' => array($date),
            'decorators' => $this->elementDecorators,
        ));
                
                
                
                 $this->addElement('text', 'citta', array(
            'label' => 'Città',
            'required' =>true,
            'filters' => array('StringTrim'),
            'validators' => array(array('StringLength',true, array(1,25))),
            'decorators' => $this->elementDecorators,
        ));
                 
                  $this->addElement('text', 'indirizzo', array(
            'label' => 'Indirizzo',
            'required' =>true,
            
            'validators' => array(array('StringLength',true, array(1,25))),
            'decorators' => $this->elementDecorators,
        ));
	$tel = new Zend_Validate_Digits();$tel->setMessage("Il campo Numero di Telefono deve contenere solo numeri");	
        $this->addElement('text', 'numero_telefono', array(
            'label' => 'Numero di Telefono',
            'required' =>true,
            
            'validators' => array($tel,array('StringLength',true, array(1,10))),
            'decorators' => $this->elementDecorators,
        ));
        
         $email = new Zend_Validate_EmailAddress();
		
		$this->addElement('text', 'email', array(
            'label' => 'Email',
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