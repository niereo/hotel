<?php

class Application_Form_Admin_Camere_Updatecamera  extends App_Form_Abstract
{
    protected $_publicModel;
	public function init()
    {               
        $this->setMethod('post');
        $this->setName('updatecamera');
        $this->setAction('');
          
        $this->_publicModel= new Application_Model_Public();
        $tipi=$this->_publicModel->getTipoCamere();
        
        $scelte=  array();
        foreach ($tipi as $tipo) {
            $scelte[$tipo->tipo]=$tipo->tipo;
        }
    	
        $this->addElement('hidden', 'cod_camera');
        
       $this->addElement('select', 'tipo', array(
            'label' => 'Internet',
            'filters' => array('StringTrim'),    
            'multiOptions' => $scelte,           
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
            'label'    => 'Modifica',
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
