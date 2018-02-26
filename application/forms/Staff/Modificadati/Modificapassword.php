<?php

class Application_Form_Staff_Modificadati_Modificapassword extends App_Form_Abstract
{
    protected $_utenteModel;
    protected $_authService;
	public function init()
    {               
        $this->_authService = new Application_Service_Auth();
        $this->_utenteModel = new Application_Model_Utente();   
        $this->setMethod('post');
        $this->setName('modificapassword');
        $this->setAction('');
    	 $user=$this->_authService->authInfo('username');
         $oldpass=$this->_utenteModel->getPasswordByUser($user);
         $confoldpass=new Zend_Validate_Identical($oldpass);
         $this->addElement('password', 'oldpass', array(
            'validators' => $confoldpass,
            'required'   => true,
            'label'      => 'Vecchia Password',
            'decorators' => $this->elementDecorators,
            ));
         
        
        $this->addElement('password', 'newpassword', array(
            'validators' => array(
                array('StringLength', true, array(4, 20))
            ),
            'required'   => true,
            'label'      => 'Nuova Password',
            'decorators' => $this->elementDecorators,
            ));
        
        
        $confnewpass=new Zend_Validate_Identical('newpassword');
        $confnewpass->setMessage('Le due password devono coincidere');
         
        $this->addElement('password', 'confnewpassword', array(
            'validators' => array($confnewpass,
            ),
            'required'   => true,
            'label'      => 'Conferma Nuova Password',
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
