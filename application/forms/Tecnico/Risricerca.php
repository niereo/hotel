<?php
class Application_Form_Tecnico_Risricerca extends App_Form_Abstract
{    
    public function init()
    {
        $this->setMethod('post');
        $this->setName('risricerca');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
		
		
		$this->addElement('Select', 'Sel_Ricerca_Uno', array(
            'label' => 'Sel_Ricerca_Uno',
            'filters' => array('StringTrim'),
            'required' => true,
            'multioptions' => array( 'a' => 'a'),
            'decorators' => $this->elementDecorators,
        ));		
		
		$this->addElement('Select', 'Sel_Ricerca_Due', array(
            'label' => 'Sel_Ricerca_Due',
            'filters' => array('StringTrim'),
            'required' => true,
            'multioptions' => array( 'b' => 'b'),
            'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('Text', 'Testo_Ricerca', array(
            'label' => 'Testo ricerca',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,40))),
            'decorators' => $this->elementDecorators,
        ));
				
        $this->addElement('Submit', 'risricbtn', array(
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