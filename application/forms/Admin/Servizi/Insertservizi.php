<?php

class Application_Form_Admin_Servizi_Insertservizi extends App_Form_Abstract
{
	public function init()
    {               
        $this->setMethod('post');
        $this->setName('insertservizi');
        $this->setAction('');
    	
        $this->addElement('text', 'tipo', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(1, 20))
            ),
            'required'   => true,
            'label'      => 'Tipo di servizio',
            'decorators' => $this->elementDecorators,
            ));
         $this->addElement('text', 'prezzo_servizio', array(
            'label' => 'Prezzo',
            'required' => true,
            'filters' => array('LocalizedToNormalized'),
            'validators' => array(array('Float', true, array('locale' => 'en_US'))),
            'decorators' => $this->elementDecorators,
        ));
          $this->addElement('file', 'foto', array(
        	'label' => 'Immagine',
        	'destination' => APPLICATION_PATH . '/../public/images',
        	'validators' => array( 
        			array('Count', false, 1),
        			array('Size', false, 1024000),
        			array('Extension', false, array('jpg', 'gif'))),
            'decorators' => $this->fileDecorators,
        			));
       $this->addElement('textarea', 'descrizione', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(1, 400))
            ),
            'cols'=>50,
            'rows'=>15,
            'required'   => true,
            'label'      => 'Descrizione',
            'decorators' => $this->elementDecorators,
            ));
       
        $this->addElement('submit', 'inserisci', array(
            'label'    => 'Inserisci',
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
