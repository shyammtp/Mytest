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
class Model_Clinic_Gallery extends Model_Abstract {

    public function __construct()
    {
        $this->_table = 'clinic_gallery';
        $this->_primaryKey = NULL;
        parent::__construct(); //this needs to be called mandatory after defining table and primary key
    }
    
    public function getGalleryImages($clinic_id)
    {
        if(!$this->_gallery) {
            $select = DB::select('*')->from($this->getTableName())
                        ->where('clinic_id','=',$clinic_id);
            $this->_gallery = $select->execute($this->getDbConfig())->as_array();
        }
        return $this->_gallery;
     
    }

}
