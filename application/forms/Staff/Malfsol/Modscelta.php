<?php
class Application_Form_Staff_Malfsol_Modscelta extends App_Form_Abstract
{
	    
		protected $_tecnicoModel;
    public function init()
    {
        $this->setMethod('post');
        $this->setName('modscelta');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
		
		$this->_tecnicoModel=new Application_Model_Tecnico();
			
 		$this->addElement('Hidden', 'Codice_Scelta');
		
		$this->addElement('Text', 'New_Cod_Scelta', array(
            'label' => 'Nome Malfunzionamento',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,40))),
            'decorators' => $this->elementDecorators,
        ));
		
		 $this->addElement('Textarea', 'Descrizione_Scelta', array(
            'label' => 'Descrizione Malfunzionamento',
        	'cols' => '40', 'rows' => '6',
            'required' => true,
 			'validators' => array(array('StringLength',true, array(1,255))),
            'decorators' => $this->elementDecorators,
        ));
		
	
        $this->addElement('Submit', 'modscelta', array(
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