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
class Model_Api_Griddata extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = "";
	}
	
	
	 public function getgriddata($params)
	{ 
		if(!isset($params['tabel_prefix'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Tabel Prefix'),
				'field' => 'tabel_prefix',
			));
		}
		$json = array();
		if((isset($params['term']) && $params['term']) && $params['tabel_prefix']) {
			$gridno = $params['term'];
			$tabel=$params['tabel_prefix']."_buildings";
			if(App::model('location/city')->checkTableExists($tabel)){
				$sql = 'select distinct(grid_id) from '.$tabel.' where grid_id ilike \'%'.$gridno.'%\' limit 10'; 
				$select = DB::query(Database::SELECT,$sql)->execute(App::model('location/city')->getDbConfig()); 
				$griddata=array();
				if(count($select)>0){
					foreach($select as $se) {
						$griddata[]=$se['grid_id']; 
					}
				}	
				$json['grid_numbers']=$griddata;
		     }
		
		}	
		if((isset($params['grid_number']) && $params['grid_number']) && $params['tabel_prefix']) {
			$gridno = $params['grid_number'];
			$tabel=$params['tabel_prefix']."_buildings";
				if(App::model('location/city')->checkTableExists($tabel)){
					$sql = 'select build_id,grid_id,test_code from '.$tabel.' where grid_id ='."'".$gridno."'".' limit 10'; 
					$select = DB::query(Database::SELECT,$sql)->execute(App::model('location/city')->getDbConfig()); 
					if(count($select)>0){
						$griddata=array();
						foreach($select as $se) {
							$griddata['box_numbers']=$se['test_code']; 
							$griddata['polygon_numbers']=$se['build_id']; 
							$json[]=$griddata;
						}
					}		
				}
		}
		return $json;
	}	
}	
