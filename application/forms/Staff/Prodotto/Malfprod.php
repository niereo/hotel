<?php
class Application_Form_Staff_Prodotto_Malfprod extends App_Form_Abstract
{    
    public function init()
    {
        $this->setMethod('post');
        $this->setName('malfprod');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
		
			
		$this->addElement('Multiselect', 'Codice_Malfunzionamento', array(
            'label' => 'Elenco Malfunzionamenti',
            'filters' => array('StringTrim'),
            'multioptions' => array('' => ''),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,40))),
            'decorators' => $this->elementDecorators,
        ));
		
				
        $this->addElement('Submit', 'malfprod', array(
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