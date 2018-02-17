<?php

class Application_Form_Utente_Modificadati_Modificapassword extends App_Form_Abstract
{
    protected $_authService;
    protected $_notId;
	public function init()
    {               
        $this->_authService = new Application_Service_Auth();   
        $this->_notId = new Application_Service_Notidentical(); 
        $this->setMethod('post');
        $this->setName('modificapassword');
        $this->setAction('');
    	
         $oldpass=$this->_authService->authInfo('password');
         $confoldpass=new Zend_Validate_Identical($oldpass);$confoldpass->setMessage('La password inserita non coincide con la vecchia password');
         $this->addElement('password', 'oldpass', array(
            'validators' => array($confoldpass),
            'required'   => true,
            'label'      => 'Vecchia Password',
            'decorators' => $this->elementDecorators,
            ));
         
        $confnewpass2= new Zend_Validate_Identical_Notidentical;$confnewpass2->setMessage('La nuova password non può essere uguale alla vecchia'); 
        
        $this->addElement('password', 'newpassword', array(
            'validators' => array($confnewpass2,
                array('StringLength', true, array(3, 20))
            ),
            'required'   => true,
            'label'      => 'Nuova Password',
            'decorators' => $this->elementDecorators,
            ));
         $confnewpass=new Zend_Validate_Identical('newpassword');$confnewpass->setMessage('Le due password devono coincidere');
         
        $this->addElement('password', 'confnewpassword', array(
            'validators' => array($confnewpass,
                array('StringLength', true, array(3, 20))
            ),
            'required'   => true,
            'label'      => 'Conferma Nuova Password',
            'decorators' => $this->elementDecorators,
            ));

        $this->addElement('submit', 'login', array(
            'label'    => 'Login',
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
