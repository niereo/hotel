<?php
class Application_Form_Amministratore_Prodotto_Compprod extends App_Form_Abstract
{
	protected $_amministratoreModel;    
    public function init()
    {
        $this->setMethod('post');
        $this->setName('compprod');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
		
		$this->_amministratoreModel = new Application_Model_Amministratore();
		
		$this->addElement('Select', 'CPU', array(
            'label' => 'CPU',
            'filters' => array('StringTrim'),
            'multioptions' => array('' => ''),
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));
					
		$this->addElement('Select', 'HDD', array(
            'label' => 'HDD',
            'filters' => array('StringTrim'),
            'multioptions' => array('' => ''),
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('Select', 'RAM', array(
            'label' => 'RAM',
            'filters' => array('StringTrim'),
            'multioptions' => array('' => ''),
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('Select', 'SVI', array(
            'label' => 'Scheda Video Integrata',
            'filters' => array('StringTrim'),
            'multioptions' => array('' => ''),
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('Select', 'SVD', array(
            'label' => 'Scheda Video Dedicata',
            'filters' => array('StringTrim'),
            'multioptions' => array('' => ''),
        
            'decorators' => $this->elementDecorators,
        ));
		
		$this->addElement('Select', 'Schermo', array(
            'label' => 'Schermo',
            'filters' => array('StringTrim'),
            'multioptions' => array('' => ''),
            'required' => true,
            'decorators' => $this->elementDecorators,
        ));

		
        $this->addElement('Submit', 'insprodcomp', array(
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