<?php
class Application_Form_Amministratore_Prodotto_Info extends App_Form_Abstract
{
    public function init()
    {
        $this->setMethod('post');
        $this->setName('infoprod');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
		
		$cod_noexists = new Zend_Validate_Db_NoRecordExists(array('table'=>'prodotto', 'field'=>'Codice_Prodotto'));
		
		$cod_noexists->setMessage('%value% esiste già',Zend_Validate_Db_Abstract::ERROR_RECORD_FOUND);	
		$this->addElement('Multiselect', 'Tipi', array(
            'label' => 'Tipi',
            'filters' => array('StringTrim'),
            'multiOptions' => array(' ' => ' '),
            'required' => true,
            'registerInArrayValidator' => false,
            'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('Hidden', 'Prodotto_Scelto');
		
		$this->addElement('Text', 'Codice_Prodotto', array(
            'label' => 'Codice Prodotto',
            'filters' => array('StringTrim'),
            'validators' => array($cod_noexists,array('StringLength',true, array(1,40))),
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));	
		
		 $this->addElement('File', 'image', array(
        	'label' => 'Immagine',
        	'destination' => APPLICATION_PATH . '/../public/images',
           	'validators' => array( 
        			array('Count', false, 1),
        			array('Size', false, 409600), //400KB
        			array('Extension', false, array('jpg', 'gif'))),
            'decorators' => $this->fileDecorators,
        			));
					
		$this->addElement('Text', 'Produttore', array(
            'label' => 'Produttore',
            'filters' => array('StringTrim'),
            'validators' => array(array('StringLength',true, array(1,40))),
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('Text', 'Modello', array(
            'label' => 'Modello',
            'filters' => array('StringTrim'),
            'validators' => array(array('StringLength',true, array(1,40))),
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('Textarea', 'Buon_Uso', array(
            'label' => 'Buon Uso',
            'filters' => array('StringTrim'),
            'validators' => array(array('StringLength',true, array(1,255))),
            'cols' => '40', 'rows' => '6',
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('Textarea', 'Mod_Installazione', array(
            'label' => 'Modalità di installazione',
            'filters' => array('StringTrim'), 
            'validators' => array(array('StringLength',true, array(1,255))),  
            'cols' => '40', 'rows' => '6',
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));
		
        $this->addElement('Submit', 'newinfoprod', array(
            'label' => 'Passa alle componenti',
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