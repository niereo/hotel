<?php
class Application_Form_Staff_Malfsol_Insertsoltomalf extends App_Form_Abstract
{
	protected $_staffModel;
	protected $_tecnicoModel;
	    
    public function init()
    {
        $this->setMethod('post');
        $this->setName('insertsoltomalf');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');

				
 		$this->addElement('Hidden', 'Codice_Malfunzionamento');
		
		$n_sol=array();
		for($i=0; $i<=10; $i++)
		$n_sol[$i]=$i;	
		
		$this->addElement('Select', 'Numero_Soluzioni', array(
			'label' => 'Quante nuove soluzioni si vogliono descrivere per questo malfunzionamento? ',
			'multioptions' => $n_sol,
			'decorators' => $this->elementDecorators));
				
		
		$this->addElement('Multiselect', 'Soluzioni_EXIST', array(
			'label' => 'Soluzioni esistenti non assegnate al malfunzionamento scelto',
			'multioptions' => array(''=>''),
			'decorators' => $this->elementDecorators));			
		
        $this->addElement('Submit', 'inssoltomalf', array(
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