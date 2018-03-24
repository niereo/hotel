<?php

class Application_Form_Utente_Servizi_Ricercaservizi extends App_Form_Abstract
{
    
    
    protected $_publicModel;
	public function init()
    {               
          
        $this->setMethod('post');
        $this->setName('ricercaservizi');
        $this->setAction('');
        
        
    	
        $this->addElement('text', 'parola', array(

        ));
                
			
        $this->addElement('submit', 'insert', array(
        'label' => 'Ricerca',
        ));
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
        	array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }
}
