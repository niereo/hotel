<?php
class Application_Form_Staff_Scelta_Quale extends App_Form_Abstract
{
    public function init()
    {
        $this->setMethod('post');
        $this->setName('quale');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
				
 		$this->addElement('Select', 'Codice_Scelta', array(
            'label' => 'Seleziona Malfunzionamento',
            'multiOptions' => array( '' => ''),
            'filters' => array('StringTrim'),
            'decorators' => $this->elementDecorators,
        ));

        $this->addElement('Submit', 'quale', array(
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