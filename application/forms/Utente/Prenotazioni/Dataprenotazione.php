<?php

class Application_Form_Utente_Prenotazioni_Dataprenotazione extends App_Form_Abstract
{
    
    
    protected $_publicModel;
	public function init()
    {               
          
        $this->setMethod('post');
        $this->setName('dataprenotazione');
        $this->setAction('');
        $this->_publicModel = new Application_Model_Public();
        $tipi=$this->_publicModel->getTipoCamere();
    	$scelte = array();
        
        $scelte['Qualsiasi']='Qualsiasi';
        foreach ($tipi as $tipo)
        {
            $scelte[$tipo->tipo]=$tipo->tipo;
        }
      			
		$date = new Zend_Validate_Date(array('format' => 'yyyy-MM-dd'));$date->setMessage("Il campo Data di Nascita deve contenere caratteri numerici che rispettano il formato 'yyyy-MM-dd' ");
		
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
                
            $this->addElement('select', 'tipo', array(
            'label' => 'Filtra per Tipo',
            'filters' => array('StringTrim'),
            'multiOptions' => $scelte,
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
