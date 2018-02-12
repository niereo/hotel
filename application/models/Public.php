<?php

class Application_Model_Public extends App_Model_Abstract
{ 

	public function __construct()
    {
    	
	}
	
	public function getFaq($paged=null)
	{
		return $this->getResource('Faq')->getFaq($paged);
	}
	
	
}