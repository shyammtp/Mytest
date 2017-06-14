<?php defined('SYSPATH') OR die('No direct script access.');
/*
    * @Front End Place Contacts Model
*/
class Model_Placecontacts extends Model_Core_Place_Contacts {

	public function __construct()
    {
        parent::__construct(); 
    }
    
    public function emailExists($email,$placeid) {
		$select = DB::select('contact_id','place_id','request_status')->from($this->getTableName())->where('user_email','=', $email)
					->and_where('place_id','=', $placeid)
					->execute()
					->as_array();
		$results = array();			
		foreach($select as $result) {
			$results['contact_id'] = $result['contact_id'];
			$results['place_id'] = $result['place_id'];
			$results['request_status'] = $result['request_status'];
		}			
		return $results;
	}
    
}
