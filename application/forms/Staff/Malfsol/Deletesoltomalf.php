<?php
class Application_Form_Staff_Malfsol_Deletesoltomalf extends App_Form_Abstract
{
	protected $_staffModel;
	protected $_tecnicoModel;
	    
    public function init()
    {
        $this->setMethod('post');
        $this->setName('deletesoltomalf');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

				
 		$this->addElement('Hidden', 'Codice_Malfunzionamento');
		
		$this->addElement('Multiselect', 'Soluzioni_EXIST', array(
			'label' => 'Soluzioni assegnate al malfunzionamento scelto',
			'multioptions' => array(''=>''),
			'decorators' => $this->elementDecorators));			
		
        $this->addElement('Submit', 'delsoltomalf', array(
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