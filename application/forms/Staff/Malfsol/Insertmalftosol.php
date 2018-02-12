<?php
class Application_Form_Staff_Malfsol_Insertmalftosol extends App_Form_Abstract
{
	protected $_staffModel;
	protected $_tecnicoModel;
	    
    public function init()
    {
        $this->setMethod('post');
        $this->setName('insertmalfosol');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

				
 		$this->addElement('Hidden', 'Codice_Soluzione');
		
		$n_sol=array();
		for($i=0; $i<=10; $i++)
		$n_sol[$i]=$i;					
		
		$this->addElement('Multiselect', 'Malfunzionamenti_EXIST', array(
			'label' => 'Malfunzionamenti registrati non appartenenti già alla soluzione selezionata',
			'multioptions' => array(''=>''),
			'decorators' => $this->elementDecorators));			
		
        $this->addElement('Submit', 'insmalftosol', array(
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