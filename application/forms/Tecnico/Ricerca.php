<?php
class Application_Form_Tecnico_Ricerca extends App_Form_Abstract
{    
    public function init()
    {
        $this->setMethod('post');
        $this->setName('ricerca');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
		
		$this->addElement('Select', 'Quale_Elemento', array(
            'label' => 'Selezione elemento da ricercare',
            'filters' => array('StringTrim'),
            'required' => true,
            'multioptions' => array( 'Malfunzionamento' => 'Malfunzionamento',
									 'Prodotto' => 'Prodotto'),
            'decorators' => $this->elementDecorators,
        ));
		
		 $this->addElement('Select', 'Tipo_Ricerca', array(
            'label' => 'Tipo Ricerca',
            'required' => true,
            'multioptions' => array( 'Selezione' => 'Selezione',
									 'Testo' => 'Testo'),
            'decorators' => $this->elementDecorators,
        ));
				
        $this->addElement('Submit', 'ricercabtn', array(
            'label' => 'Ricerca',
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