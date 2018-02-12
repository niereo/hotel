<?php
class Application_Form_Staff_Malfsol_Insertmalf extends App_Form_Abstract
{
	protected $_staffModel;
	    
    public function init()
    {
        $this->setMethod('post');
        $this->setName('insertmalf');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
		
		$this->_staffModel=new Application_Model_Staff();
		
	$cod_noexists1 = new Zend_Validate_Db_NoRecordExists(array('table'=>'malfunzionamento', 'field'=>'Codice_Malfunzionamento'));		
	$cod_noexists1->setMessage(' Malfunzionamento %value% esiste già',Zend_Validate_Db_Abstract::ERROR_RECORD_FOUND);
			
 		$this->addElement('text', 'Codice_Malfunzionamento', array(
            'label' => 'Nome Malfunzionamento',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array($cod_noexists1, array('StringLength',true, array(1,40))),
            'decorators' => $this->elementDecorators,
        ));
		
		 $this->addElement('textarea', 'Descrizione_Malfunzionamento', array(
            'label' => 'Descrizione Malfunzionamento',
        	'cols' => '40', 'rows' => '6',
            'required' => true,
 			'validators' => array(array('StringLength',true, array(1,255))),
            'decorators' => $this->elementDecorators,
        ));
		
		$n_sol=array();
		for($i=0; $i<=10; $i++)
		$n_sol[$i]=$i;	
		
		$this->addElement('Select', 'Numero_Soluzioni', array(
			'label' => 'Quante nuove soluzioni si vogliono descrivere per questo malfunzionamento? ',
			'multioptions' => $n_sol,
			'decorators' => $this->elementDecorators));
		
		
		$soluzioni = array();
        $sol = $this->_staffModel->getSol();
        foreach ($sol as $s) {
        	$soluzioni[$s->Codice_Soluzione] = $s->Codice_Soluzione;       
        }	
		$this->addElement('Multiselect', 'Soluzioni_EXIST', array(
			'label' => 'Soluzioni già esistenti ',
			'multiOptions' => $soluzioni,
			'decorators' => $this->elementDecorators));			
		
        $this->addElement('Submit', 'insertmalf', array(
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