<?php
class Application_Form_Amministratore_Utente_Utente extends App_Form_Abstract
{
	protected $_amministratoreModel;  
    public function init()
    {
        $this->setMethod('post');
        $this->setName('nuovoprod');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
		
		$this->_amministratoreModel = new Application_Model_Amministratore();
		
		$cod_noexists = new Zend_Validate_Db_NoRecordExists(array('table'=>'utente', 'field'=>'Username'));
		
		$cod_noexists->setMessage('Username %value% non utilizzabile',Zend_Validate_Db_Abstract::ERROR_RECORD_FOUND);
		
		$this->addElement('Text', 'Username', array(
            'label' => 'Username',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array($cod_noexists, array('StringLength',true, array(1,10))),
            'decorators' => $this->elementDecorators,
        ));
				
		$this->addElement('Password', 'Password', array(
            'label' => 'Nuova Password',
            'filters' => array('StringTrim'),
            'validators' => array(array('StringLength',true, array(1,40))),
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));	
		
		$this->addElement('Password', 'Conferma_Password', array(
            'label' => 'Conferma Password',
            'filters' => array('StringTrim'),
            'validators' =>  array(array('identical', true, array('Password')),array('StringLength',true, array(1,40))),
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));	
		
		 $this->addElement('File', 'image', array(
        	'label' => 'Foto Utente',
            'destination' => APPLICATION_PATH . '/../public/images',
           	'validators' => array( 
        			array('Count', false, 1),
        			array('Size', false, 409600), // 400KB
        			array('Extension', false, array('jpg', 'gif'))),
            'decorators' => $this->fileDecorators,
        			));
					
		$this->addElement('Text', 'Cognome', array(
            'label' => 'Cognome',
            'filters' => array('StringTrim'),            
            'validators' => array(array('StringLength',true, array(1,40))),
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('Text', 'Nome', array(
            'label' => 'Nome',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array(array('StringLength',true, array(1,40))),
            'decorators' => $this->elementDecorators,
        ));	
		
		$ruoli = array();
		$ruolo = $this->_amministratoreModel->getRuoli();
		foreach($ruolo as $r)
		{
			$ruoli[ $r->Nome_Ruolo] = $r->Nome_Ruolo;
		}	
		$this->addElement('Select', 'N_Ruolo', array(
            'label' => 'Ruolo',
            'filters' => array('StringTrim'),
            'multioptions' => $ruoli,
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));
		
		$centri = array();
		$centro = $this->_amministratoreModel->getCentri();
		foreach($centro as $c)
		{
			$centri[ $c->Codice_Centro] = $c->Codice_Centro;
		}	
		$this->addElement('Select', 'Cod_Centro', array(
            'label' => 'Codice Centro',
            'filters' => array('StringTrim'),
            'multioptions' => $centri,
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));
				
        $this->addElement('Submit', 'userreg', array(
            'label' => 'Invia',
        	'decorators' => $this->buttonDecorators,
        ));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
        	array('Description', array('placement' => 'prepend', 'class' => 'formerror')),
            'Form'
        ));
    }
}