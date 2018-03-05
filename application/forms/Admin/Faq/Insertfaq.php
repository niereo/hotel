<?php

class Application_Form_Admin_Faq_Insertfaq extends App_Form_Abstract
{
	public function init()
    {               
        $this->setMethod('post');
        $this->setName('insertfaq');
        $this->setAction('');
    	
        $this->addElement('textarea', 'domanda', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 400))
            ),
            'cols'=>50,
            'rows'=>15,
            'required'   => true,
            'label'      => 'Domanda',
            'decorators' => $this->elementDecorators,
            ));
        
       $this->addElement('textarea', 'risposta', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 400))
            ),
            'cols'=>50,
            'rows'=>15,
            'required'   => true,
            'label'      => 'Risposta',
            'decorators' => $this->elementDecorators,
            ));
       
        $this->addElement('submit', 'login', array(
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
