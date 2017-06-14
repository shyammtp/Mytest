<?php defined('SYSPATH') OR die('No direct script access.');

class Model_Admin_Advert_Info extends Model_Abstract {

    public function __construct()
    {
        $this->_table = 'adverts_info';
        $this->_primaryKey = NULL;
        parent::__construct(); //this needs to be called mandatory after defining table and primary key
    }
	
}
