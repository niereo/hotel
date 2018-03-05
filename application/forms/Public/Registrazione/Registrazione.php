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
		
		$cod_noexists->setMessage('%value% esiste già, usare un altro username',Zend_Validate_Db_Abstract::ERROR_RECORD_FOUND);
		
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


        $lung=new Zend_Validate_StringLength(4,20); $lung->setMessage('La password deve essere almeno di 8 caratteri e non più grande di 20');
 $this->addElement('password', 'password', array(
            'label' => 'Password',
            'required' =>true,
            'filters' => array('StringTrim'),
            'validators' => array($lung),
            'decorators' => $this->elementDecorators,
        ));
 $pass=new Zend_Validate_Identical('password');$pass->setMessage("Le due password devono coincidere");
 
  $this->addElement('password', 'confpass', array(
            'label' => 'Conferma Password',
            'required' =>true,
            'filters' => array('StringTrim'),
            'validators' => array($pass),
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
					
		$date = new Zend_Validate_Date(array('format' => 'yyyy-MM-dd'));$date->setMessage("Il campo deve contenere una data valida che rispetta il formato 'yyyy-MM-dd' ");
		
                
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