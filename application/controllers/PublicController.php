<?php

class PublicController extends Zend_Controller_Action
{
	protected $_publicModel;
	
    public function init()
    {       	
       $this->_helper->layout->setLayout('layout_ospite');
    }
	

    public function indexAction()
    {
        // home del sito
    }
	
	public function contattiAction()
	{
		
	}
        public function whereAction()
	{
		
	}
	
	public function chisiamoAction()
	{
		
	}
	
	public function faqAction()
	{
		$paged = $this->_getParam('page', 1);
		return $this->_publicoModel->getFaq($paged);
	}
	
	public function loginAction()
	{
		
	}
}

