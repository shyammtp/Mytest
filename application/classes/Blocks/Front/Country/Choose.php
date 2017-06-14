<?php defined('SYSPATH') OR die('No direct script access.'); 

class Blocks_Front_Country_Choose extends Blocks_Front_Abstract
{
	public function __construct()
	{
		$this->setTemplate('country/choose');
	} 
	
    public function getAvailableCountry()
    {
		$sql = 'select gid as country_id, (case when 2='.App::getCurrentLanguageId().' then name_arb else name_eng end) as country_name,  iso_code_short from '.App::model('location/country')->getTableName();
		$select = DB::query(Database::SELECT,$sql)->execute(App::model('location/country')->getDbConfig()); 
        foreach($select as $c) {
			$cities =  App::model('location/city')->getCitysByCountryCache($c['country_id']);
			$countries[$c['country_id']] = array_merge($c,array('cities' => $cities)); 
        } 
        return $countries;
    }
}
