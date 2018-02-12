<?php
class Application_Form_Amministratore_Faq_Sceglifaq extends App_Form_Abstract
{
	protected $_amministratoreModel;    
	protected $_publicoModel;
    public function init()
    {
        $this->setMethod('post');
        $this->setName('compprod');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
		
		$this->_amministratoreModel = new Application_Model_Amministratore();
		$this->_publicoModel = new Application_Model_Publico();
		

		
		$this->addElement('Select', 'Codice', array(
            'label' => 'FAQ',
            'multioptions' => array( '' => ''),
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('Textarea', 'Domanda', array(
            'label' => 'Domanda',
            'cols' => '40', 'rows' => '10',
            'filters' => array('StringTrim'),
            'validators' => array(array('StringLength',true, array(1,400))),
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));	
		
		$this->addElement('Textarea', 'Risposta', array(
            'label' => 'Risposta',
            'cols' => '40', 'rows' => '10',
            'filters' => array('StringTrim'),
            'validators' => array(array('StringLength',true, array(1,400))),
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));			
		
        $this->addElement('Submit', 'getfaq', array(
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