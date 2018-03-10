<?php
class Application_Form_Admin_Utenti_Updateutente extends App_Form_Abstract
{
	protected $_adminModel;
	    
    public function init()
    {
        $this->setMethod('post');
        $this->setName('updateutente');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
		
		
$this->addElement('hidden', 'ruolo', array(
            
            'decorators' => $this->elementDecorators,
        ));
$this->addElement('hidden', 'username', array(
            
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
			
        $this->addElement('submit', 'modifica', array(
            'label' => 'Modifica',
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