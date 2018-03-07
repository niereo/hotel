<?php

class Application_Form_Utente_Prenotazioni_Selezionaservizi extends App_Form_Abstract
{
    
    
    protected $_publicModel;
	public function init()
    {               
          
        $this->setMethod('post');
        $this->setName('selezionaservizi');
        $this->setAction('');
        $this->_publicModel = new Application_Model_Public;
        
    	$this->addElement('hidden', 'codice', array(
           
            'decorators' => $this->elementDecorators,
            ));
        
        $this->addElement('hidden', 'datai', array(
           
            'decorators' => $this->elementDecorators,
            ));
        
        $this->addElement('hidden', 'dataf', array(
           
            'decorators' => $this->elementDecorators,
            ));
        
        
        
        $servizi=$this->_publicModel->getServizi();
        
            $this->addElement('radio', 'servizi', array(
            'label' => 'Vuoi selezionare un servizio aggiuntivo?',
            'filters' => array('StringTrim'),    
            'multiOptions' => array(
                        'SI' => 'SI',
                        'NO' => 'NO',
                        ),
                'value'=>'NO',
            
            'decorators' => $this->elementDecorators,
        ));
            
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
