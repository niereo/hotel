<?php
class Application_Form_Staff_Malfsol_Insertsol extends App_Form_Abstract
{    
    public function init()
    {
        $this->setMethod('post');
        $this->setName('insertsol');
        $this->setAction('');
        $this->setAttrib('enctype', 'multipart/form-data');
		
		$cod_noexists2 = new Zend_Validate_Db_NoRecordExists(array('table'=>'soluzione', 'field'=>'Codice_Soluzione'));		
		$cod_noexists2->setMessage('%value% esiste già',Zend_Validate_Db_Abstract::ERROR_RECORD_FOUND);
			
		$this->addElement('Text', 'Codice_Soluzione', array(
            'label' => 'Nome Soluzione',
            'filters' => array('StringTrim'),
            'required' => true,
            'validators' => array($cod_noexists2, array('StringLength',true, array(1,40))),
            'decorators' => $this->elementDecorators,
        ));
		
		 $this->addElement('Textarea', 'Descrizione_Soluzione', array(
            'label' => 'Descrizione Soluzione',
        	'cols' => '40', 'rows' => '6',
            'required' => true,
 			'validators' => array(array('StringLength',true, array(1,255))),
            'decorators' => $this->elementDecorators,
        ));
				
        $this->addElement('Submit', 'insertsol', array(
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