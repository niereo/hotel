<?php

class Application_Form_Admin_Faq_Updatefaq extends App_Form_Abstract
{
	public function init()
    {               
       
    	
        $this->addElement('textarea', 'doamnda', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 400))
            ),
            'required'   => true,
            'value'     => $this->faq->domanda,
            'cols'      => 50,
            'rows'      => 15,
            'label'      => 'Domanda',
            'decorators' => $this->elementDecorators,
            ));
        
        $this->addElement('textarea', 'risposta', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', true, array(3, 400))
            ),
            'required'   => true,
            'value'     => $this->faq->risposta,
            'cols'      => 50,
            'rows'      => 15,
            'label'      => 'Risposta',
            'decorators' => $this->elementDecorators,
            ));

        $this->addElement('submit', 'login', array(
            'label'    => 'Aggiotna',
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
