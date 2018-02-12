<?php

class Application_Resource_Faq extends Zend_Db_Table_Abstract
{

    protected $_name = 'faq';
 	protected $_primary  = 'id_faq';
    protected $_rowClass = 'Application_Resource_Faq_Item';

	public function getFaq($paged=null)
	{
		$select=$this->select()
		->from('faq');
		if (null !== $paged) {
			$adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(4)
		          	  ->setCurrentPageNumber((int) $paged);
			return $paginator;
		}
		return $this->fetchAll($select);
	}
	
	
}

