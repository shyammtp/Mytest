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
class Model_Admin_Advert_Label extends Model_Abstract {

    private $_languages = array();
    private $_advertLables = array();

    public function __construct()
    {
        $this->_table = 'adverts_info';
       // $this->_primaryKey = NULL;
        parent::__construct(); //this needs to be called mandatory after defining table and primary key
    } 

    public function getAdvertLabels($langid,$advertId = '')
    {
		
        if(!isset($this->_advertLables[$langid])) {
            $this->_advertLables[$langid] = array();
        }
        if(empty($this->_advertLables[$langid])) {
            $advertLabel = DB::select('*')->from($this->getTableName())->where('language_id','=',$langid)->execute($this->getDbConfig());
            $advertsL = array();
            foreach($advertLabel as $coul) {
                $advertsL[$coul['adverts_id']] = new Kohana_Core_Object($coul);
            }
            $this->_advertLables[$langid] = new Kohana_Core_Object($advertsL);
        }
        return $advertId && isset($this->_advertLables[$langid]) && isset($this->_advertLables[$langid][$advertId]) ?
                            $this->_advertLables[$langid][$advertId]
                            :new Kohana_Core_Object(array());
    }

}
