<?php

class Application_Form_Utente_Prenotazioni_Dataprenotazione extends App_Form_Abstract
{
    
    
    protected $_publicModel;
	public function init()
    {               
          
        $this->setMethod('post');
        $this->setName('dataprenotazione');
        $this->setAction('');
        
        
    	$this->addElement('hidden', 'codice', array(
           
            'decorators' => $this->elementDecorators,
            ));
        
        
      			
		$date = new Zend_Validate_Date(array('format' => 'yyyy-MM-dd'));
                $date->setMessage("Il campo deve contenere caratteri numerici che rispettano il formato 'yyyy-MM-dd' ");
		
		$this->addElement('text', 'data_inizio', array(
            'label' => 'Data Arrivo',
            'required' =>true,
	    'filters' => array('StringTrim'),
            'validators' => array($date),
            'decorators' => $this->elementDecorators,
        ));
                
                $this->addElement('text', 'data_fine', array(
            'label' => 'Data Partenza',
            'required' =>true,
	    'filters' => array('StringTrim'),
            'validators' => array($date),
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
