<?php

class Application_Resource_Faq extends Zend_Db_Table_Abstract
{
    protected $_name    = 'faq';
    protected $_primary  = 'id';
    protected $_rowClass = 'Application_Resource_Faq_Item';

	public function init()
    {
    }
       
    public function getFaq()
    {
        return $this->fetchAll();
    }	
     public function insertFaq($info)
    {
        $this->insert($info);
    }	
    public function getFaqByCod($codice)
    {
        $select=$this->select()->where('id = ?',$codice);
        return $this->fetchRow($select);
    }
    public function updateFaq($info)
    {
        $where= array('id = ?' => $info['id']);
        return $this->update($info,$where);
    }
    public function deleteFaq($id)
    {
         $where= $this->getAdapter()->quoteInto('id = ?', $id);
	$this->delete($where);
    }
}

