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
class Model_Api_City extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = "";
	}
	
	public function getcity($params)
	{ 
		if(!isset($params['latitude'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing latitude'),
				'field' => 'latitude',
			));
		}
		if(!isset($params['longitude'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing longitude'),
				'field' => 'longitude',
			));
		}
		$json = array();
		if($params['latitude'] && $params['longitude']) {
			$sql = 'select city_pre, name_eng,gid,st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat from '.App::model('location/city')->getTableName(); 
			$select = DB::query(Database::SELECT,$sql)->execute(App::model('location/city')->getDbConfig());	

				
			if($select->count()) {
				foreach($select as $data){
				$city = array();
				$city['default'] = false;
					if($data['city_pre']) {
						$sql1 = 'select gid from '.App::model('location/city')->getTableName().' where st_contains(geom,st_setsrid(ST_makepoint('.$params['longitude'].', '.$params['latitude'].'),4326)) = true'; 
						$select1 = DB::query(Database::SELECT,$sql1)->execute(App::model('location/city')->getDbConfig());			
						if($select1->count()) {
							$gid=$select1->current();
							if($gid['gid']==$data['gid']){
								$city['default']=true;	
							}
						}
						$city['table'] = $data['city_pre']."_buildings";
						$city['table_prefix'] = $data['city_pre'];
						$city['city_name'] = $data['name_eng'];
						$city['city_id'] = $data['gid'];
						$city['lat'] = $data['lat'];
						$city['lng'] = $data['lng'];
						$json[]=$city;
					}
				}
				
			}
		}
		return $json;

	}	
	
	public function getLatLngs($cityid)
	{
		$select = DB::query(Database::SELECT,'select st_x(centroid) as lng, st_y(centroid) as lat, st_asgeojson(geom,6) as geojson from (select st_centroid(geom) as centroid, geom from city where gid = '.(int) $cityid.') as t')->cached(SMALL_RECORDS_DATABASE_CACHE_LIFETIME)->execute($this->getDbConfig())->current();
		return $select;
	}
}	
