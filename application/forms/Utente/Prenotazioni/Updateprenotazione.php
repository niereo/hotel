<?php

class Application_Form_Utente_Prenotazioni_Updateprenotazione extends App_Form_Abstract
{
    
    
    protected $_publicModel;
	public function init()
    {               
          
        $this->setMethod('post');
        $this->setName('updateprenotazione');
        $this->setAction('');
        $this->_publicModel = new Application_Model_Public;
        
    	$this->addElement('hidden', 'codice');
        
        
      	$date = new Zend_Validate_Date(array('format' => 'yyyy-MM-dd'));
        $date->setMessage("Il campo deve contenere caratteri numerici che rispettano il formato 'yyyy-MM-dd' ");
		
		$this->addElement('text', 'data_inizio_pren', array(
            'label' => 'Data Arrivo',
            'required' =>true,
	    'filters' => array('StringTrim'),
            'validators' => array($date),
            'decorators' => $this->elementDecorators,
        ));
                
                $this->addElement('text', 'data_fine_pren', array(
            'label' => 'Data Partenza',
            'required' =>true,
	    'filters' => array('StringTrim'),
            'validators' => array($date),
            'decorators' => $this->elementDecorators,
        ));
           
        
        
        $servizi=$this->_publicModel->getServizi();
                    
        foreach ($servizi as $serv)
        {
  
            $this->addElement('checkbox',$serv->tipo, array(
            'label' => $serv->tipo,
            'filters' => array('StringTrim'),
            'decorators' => $this->elementDecorators,
        )); 
           
        }
			
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
