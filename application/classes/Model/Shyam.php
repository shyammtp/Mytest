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
class Model_Shyam extends Model_Abstract {
    
    public function __construct()
    {
        //$this->setData(array('helloshyam' => 'health','whatisthis' => 'whi'));
        
    }
    
    public function getMyDatas(Kohana_Core_Object $object)
    {
        print_r($object->getController());exit;
    }
}
