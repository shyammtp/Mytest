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
class Model_Api_Categorylist extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = App::model('requirements');
	}
	
	public function get($params)
	{ 
		$resultant = $this->_model->getCategoryList();	 		
		return array('details' => $resultant,'total_rows' => count($resultant));
	}
	
}	
