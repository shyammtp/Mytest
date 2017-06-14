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
class Model_Clinic_Attribute extends Model_Abstract {
     
    protected $_clinicids;
    public function __construct()
    {
        $this->_table = 'clinic_attribute_value';
        $this->_primaryKey = 'value_id'; 
        parent::__construct(); //this needs to be called mandatory after defining table and primary key
        //$this->collectEntity(); 
    }
    
    public function getSelect()
    {
        $clinicids = $this->getParent()->getAllIds(); 
        if(empty($clinicids)) {
           $clinicids = array(0); 
        }
        if(!$this->_clinicids) {
            $this->_clinicids = DB::select()->select_array($this->loadColumns())->from(array($this->getTableName(),'main_table'))->where('clinic_id','in',$clinicids);
        }
        return $this->_clinicids;
    }
}