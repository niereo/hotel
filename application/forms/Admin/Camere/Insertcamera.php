<?php

class Application_Form_Admin_Camere_Insertcamera extends App_Form_Abstract
{
    protected $_publicModel;
	public function init()
    {               
        $this->setMethod('post');
        $this->setName('insertcamera');
        $this->setAction('');
        
        
        
        $this->addElement('text', 'cod_camera', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(1, 20))
            ),
            'required'   => true,
            'label'      => 'Camera Numero',
            'decorators' => $this->elementDecorators,
            ));
        
        $this->addElement('hidden', 'tipo');
        
         
          $this->addElement('file', 'foto', array(
        	'label' => 'Immagine',
        	'destination' => APPLICATION_PATH . '/../public/images',
        	'validators' => array( 
        			array('Count', false, 1),
        			array('Size', false, 1024000),
        			array('Extension', false, array('jpg', 'gif'))),
            'decorators' => $this->fileDecorators,
        			));
          $this->addElement('text', 'prezzo_camera', array(
            'label' => 'Prezzo',
            'required' => true,
            'filters' => array('LocalizedToNormalized'),
            'validators' => array(array('Float', true, array('locale' => 'en_US'))),
            'decorators' => $this->elementDecorators,
        ));
       
       $this->addElement('radio', 'tv', array(
            'label' => 'TV',
            'filters' => array('StringTrim'),    
            'multiOptions' => array(
                        true => 'SI',
                        false => 'NO',
                        ),
                'value'=>'NO',
            
            'decorators' => $this->elementDecorators,
        ));
        
        $this->addElement('radio', 'internet', array(
            'label' => 'Internet',
            'filters' => array('StringTrim'),    
            'multiOptions' => array(
                        true => 'SI',
                        false => 'NO',
                        ),
                'value'=>'NO',
            
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
