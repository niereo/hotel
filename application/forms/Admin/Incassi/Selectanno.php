<?php

class Application_Form_Admin_Incassi_Selectanno extends App_Form_Abstract
{   
    protected $_adminModel;
    
	public function init()
    {               
        $this->setMethod('post');
        $this->setName('selectanno');
        $this->setAction('');
        
        $this->_adminModel = new Application_Model_Admin();
        
        $prenotazioni = $this->_adminModel->getIncassi();	
        $anni= array();
        foreach ($prenotazioni as $pren) {
            $anno = new Zend_Date($pren->data_inizio_pren);
            $anno=$anno->toArray();
            $anno=$anno['year'];
            $anni[$anno]=$anno;
        }
        
        
        $this->addElemente('select','anno',array(
            
            'label'    => 'Seleziona anno',
            'decorators' => $this->buttonDecorators,
            'filters' => array('StringTrim'),
            'multiOptions' => $anni,
        ));
        
        $this->addElement('submit', 'conferma', array(
            'label'    => 'Conferma',
            'decorators' => $this->buttonDecorators,
        ));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table', 'class' => 'zend_form')),
        	array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }
}
