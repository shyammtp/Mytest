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
class Model_Api_Mapdata extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = "";
	}
		
	public function getmapdata($params)
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
		
		if(!isset($params['city_id'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing city_id'),
				'field' => 'city_id',
			));
		}
		
		$json['city'] = false;
		if($params['latitude'] && $params['longitude'] && $params['city_id']) {
			$sql = 'select city_pre, name_eng from '.App::model('location/city')->getTableName().' where gid = \''.$params['city_id'].'\' and st_contains(geom,st_setsrid(ST_makepoint('.$params['longitude'].', '.$params['latitude'].'),4326)) = true'; 
			$select = DB::query(Database::SELECT,$sql)->execute(App::model('location/city')->getDbConfig());			
			if($select->count()) {
				$json['city'] = $select->current();
				
			}
		}
		if(count($json['city'])>1){
			$table = '';
			$table_prefix='';
			if($json['city']['city_pre']) {
				$table = $json['city']['city_pre']."_buildings";
				$table_prefix = $json['city']['city_pre'];
			}
			if(App::model('location/city')->checkTableExists($table)){
				if($table) {
					$sql = 'select gid,build_id,grid_id,test_code from '.$table.' where st_contains(geom,st_setsrid(ST_makepoint('.$params['longitude'].', '.$params['latitude'].'),4326)) = true'; 
					$select = DB::query(Database::SELECT,$sql)->execute(App::model('location/city')->getDbConfig()); 
					$json['mapdata']=false;
					if(count($select)>0){
						foreach($select as $se) {
							$json['mapdata'] = array('gid'=>$se['gid'],'grid_number'=>$se['grid_id'],'box_number'=>$se['build_id'],'polygon_number'=>$se['test_code'],'tableprefix'=>$table_prefix);
						}
						$address=array();
						if(count($json['mapdata'])>0){
							$table1 = $json['city']['city_pre']."_address";
							$sql1 = 'select keyw_eng,keyw_arb,name_tbl,parent_id,city_id,tree_level_id from '.$table1.' where pkey_tbl = \''.$json['mapdata']['gid'].'\' and name_tbl= \''.$table.'\''; 
							$select1 = DB::query(Database::SELECT,$sql1)->execute(App::model('location/city')->getDbConfig()); 
							foreach($select1 as $se) {
								$address[] = array('adress_eng'=>$se['keyw_eng'],'adress_arb'=>$se['keyw_arb'],'name_tbl'=>$se['name_tbl'],'parent_id'=>$se['parent_id'],'city_id'=>$se['city_id'],'tree_level_id'=>$se['tree_level_id'],'tabel'=>$table1);
								
							}
						}
						$json['address']=$address;
						
					}
				}
			}
		}
		return $json;

	}	
}	
