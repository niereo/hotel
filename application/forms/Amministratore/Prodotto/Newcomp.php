<?php
class Application_Form_Amministratore_Prodotto_Newcomp extends App_Form_Abstract
{
	protected $_amministratoreModel;    
    public function init()
    {
        $this->setMethod('post');
        $this->setName('compprod');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
		
		
		$cod_noexists = new Zend_Validate_Db_NoRecordExists(array('table'=>'componenti', 'field'=>'Codice_Componente'));
		
		$cod_noexists->setMessage('%value% esiste già',Zend_Validate_Db_Abstract::ERROR_RECORD_FOUND);
		
		
		$this->_amministratoreModel = new Application_Model_Amministratore();
		
		
		$this->addElement('Hidden', 'Cod_Tipo');
		
		$this->addElement('Text', 'Codice_Componente', array(
            'label' => 'Codice Componente',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array($cod_noexists, array('StringLength',true, array(1,30))),
            'decorators' => $this->elementDecorators,
        ));	
				
		$this->addElement('Text', 'Produttore', array(
            'label' => 'Produttore',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,40))),
            'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('Text', 'Modello', array(
            'label' => 'Modello',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,40))),
            'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('Text', 'Memoria', array(
            'label' => 'Memoria [GB]',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array('Float'),
            'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('Text', 'RPM', array(
            'label' => 'RPM',
            'filters' => array('StringTrim'),
            'validators' => array('Float'),
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('Text', 'Frequenza', array(
            'label' => 'Frequenza [GHz]',
            'filters' => array('StringTrim'),
            'validators' => array('Float'),
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));

		$this->addElement('Text', 'Tipo_Schermo', array(
            'label' => 'Tipo Schermo',
            'filters' => array('StringTrim'),
            'validators' => array(array('StringLength',true, array(1,40))),
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('Text', 'Grandezza_Schermo', array(
            'label' => 'Grandezza Schermo [pollici]',
            'filters' => array('StringTrim'),
            'validators' => array('Float'),
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));
		
		
        $this->addElement('Submit', 'inscomp', array(
            'label' => 'Invia',
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