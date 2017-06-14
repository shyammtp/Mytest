<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Database Model base class.
 *
 * @package    Kohana/Database
 * @category   Models
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Model_Clinic_Attribute_Static extends Model_Abstract {
     
    public function __construct()
    {
        $this->_table = 'clinic_attribute_value_static';
        $this->_primaryKey = 'value_id'; 
        parent::__construct(); //this needs to be called mandatory after defining table and primary key
        //$this->collectEntity(); 
    }
    
    public function getSelect()
    {
        $userIds = $this->getParent()->getAllIds(); 
        if(empty($userIds)) {
           $userIds = array(0); 
        }
        return  DB::select()->from(array($this->getTableName(),'main_table'))->where('clinic_id','in',$userIds);
    }
}