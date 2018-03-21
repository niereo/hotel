<?php

class Application_Form_Admin_Incassi_Selectanno extends App_Form_Abstract
{   
    protected $_utenteModel;
    protected $_staffModel;
    protected $_publicModel;
    
	public function init()
    {   
        $this->_publicModel = new Application_Model_Public();
        $this->_utenteModel = new Application_Model_Utente();
        $this->_staffModel = new Application_Model_Staff();
        
        $this->setMethod('post');
        $this->setName('selectanno');
        $this->setAction('');
        
        $annoiniziale = 2017;
        $oggi = new Zend_Date();
        $anno = $oggi->toArray();
        $anno = $anno['year'];
        	
        $anni= array();
        while ($anno >= $annoiniziale ) {
            $anni[$anno]=$anno;
            $anno--;
        }
        
        
        $this->addElement('select','anno',array(
            
            'label'    => 'Seleziona anno',
            'decorators' => $this->elementDecorators,
            'filters' => array('StringTrim'),
            'multiOptions' => $anni
        ));
        
        $camere=$this->_publicModel->getTipoCamere();
    	$sceltacamere = array();
         $sceltacamere['Qualsiasi']='Qualsiasi';
        foreach ($camere as $camera)
        {
            $sceltacamere[$camera->tipo]=$camera->tipo;
        }
            $this->addElement('select', 'camera', array(
            'label' => 'Filtra per Camera',
            'filters' => array('StringTrim'),
            'multiOptions' => $sceltacamere,
            'decorators' => $this->elementDecorators,
        ));
        
        $servizi=$this->_publicModel->getServizi();
    	$sceltaservizi = array();
             $sceltaservizi['Qualsiasi']='Qualsiasi';
             $sceltaservizi['Nessuno']='Nessuno';
        foreach ($servizi as $servizio)
        {
            $sceltaservizi[$servizio->tipo]=$servizio->tipo;
        }
             $this->addElement('select', 'servizi', array(
            'label' => 'Filtra per Servizio',
            'filters' => array('StringTrim'),
            'multiOptions' => $sceltaservizi,
            'decorators' => $this->elementDecorators,
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
