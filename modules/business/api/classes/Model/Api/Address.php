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
class Model_Api_Address extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = "";
	}
	
	public function getadddress($params)
	{ 
		if(!isset($params['grid_number'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Grid Number'),
				'field' => 'grid_number',
			));
		}
		if(!isset($params['box_number'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Box Number'),
				'field' => 'box_number',
			));
		}
		if(!isset($params['polygon_number'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Polygon Number'),
				'field' => 'polygon_number',
			));
		}
		
		if(!isset($params['table_prefix'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Table Prefix'),
				'field' => 'table_prefix',
			));
		}
		
		$json = array();
		if($params['table_prefix']) {
			$table=$params['table_prefix']."_buildings";
			if(App::model('location/city')->checkTableExists($table)){
				$sql = 'select gid,build_id,grid_id,test_code,st_x(st_centroid(geom)) as lng,st_y(st_centroid(geom)) as lat from '.$table.' where grid_id = \''.$params['grid_number'].'\' and build_id = \''.$params['box_number'].'\' and test_code = \''.$params['polygon_number'].'\''; 
				$select = DB::query(Database::SELECT,$sql)->execute(App::model('location/city')->getDbConfig());
				$json['mapdata']=false;
				if(count($select)>0){
					
					foreach($select as $se) {
						$json['mapdata'] = array('gid'=>$se['gid'],'grid_number'=>$se['grid_id'],'box_number'=>$se['build_id'],'polygon_number'=>$se['test_code'],'tableprefix'=>$params['table_prefix'],'longitude'=>$se['lng'],'latitude'=>$se['lat']);
					}
					$address=array();
					if(count($json['mapdata'])>0){
						$table1 = $params['table_prefix']."_address";
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
		return $json;

	}	
}	
