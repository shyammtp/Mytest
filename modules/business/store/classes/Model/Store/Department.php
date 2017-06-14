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
class Model_Store_Department extends Model_Core_Department {

    public function validate($data,$image)
    { 	
        $validate = Validation::factory($data);
        $validate->label('department_name',__('Department'))
                ->rule('department_name','not_empty'); 
                
        if(empty($data['department_id'])){
			//$validate->rule('department_name',array($this,'department_name_allready_exists'), array($data['department_name']));
		}        
        $department_id = '';
        if(isset($data['department_id'])) { 
           $department_id = $data['department_id'];
        }        
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }             
        return $this;
    }
    
    public function department_name_allready_exists($department_name)
	{ 
		$department_name = DB::select('*')->from(array($this->getTableName(),'main_table'))->where('department_name','=',$department_name)->execute();
		return count($department_name) < 1;
	}
	
    public function saveDepartment()
    {		
        $request = Request::current();
		$data = $request->post();
		if($this->hasData('post_data')) {
			$data = $this->getData('post_data');
		}
        App::dispatchEvent('Department_Save_Before',array('post'=> $data,'department' => $this));		 
        parent::save();
        App::dispatchEvent('Department_Save_After',array('post'=> $data,'department' => $this));
        return $this;
    }
    
    public function getDepartment($keyword = '')
    { 
		$arr = array();		
		$select = $this->getResource()->joinLanguageTable(); 		
		$select->getSelect()->select('lng_table.department_name','main_table.department_id');
		if($keyword) {
				$select->getSelect()->where('lng_table.department_name','like','%'.$keyword.'%');
		}
		$select->getSelect()->where('main_table.department_status' ,'=', 1)->limit(10);
		$department_name = $select->getAttributeValues();
		foreach($department_name as $dp){
			$arr[]=array('department_id'=>$dp->getDepartmentId(),'department_name'=>$dp->getDepartmentName());
		}
		return $arr;
    }
    
    public function importStoreData($file, $data, &$responses)
	{ 
		$errors = array();
		$spreadsheet = Spreadsheet::factory(array('filename' => 'uploads/import/'.$file,'csv_values' => array('delimiter' => ',', 'lineEnding' => "\r\n")), TRUE)->load()->read(); 
		foreach($spreadsheet as $key => $sheet) {
			$inserterror = false;
			if($key == 1) {
				continue;
			}
			$data = array();
			try {
				$department = App::model('store/department',false);
				$data['department_name'][1] = trim(Arr::get($sheet,'A',NULL));
				$data['department_name'][2] = trim(Arr::get($sheet,'B',NULL));
				$data['description'][1] = trim(Arr::get($sheet,'C',NULL));
				$data['description'][2] = trim(Arr::get($sheet,'D',NULL));
				$data['department_type'] = trim(Arr::get($sheet,'E',NULL));
				$data['show_frontend'] = trim(Arr::get($sheet,'F',NULL));
				$data['department_status'] = 1; 
				$department->addData($data);
				$department->importvalidate();
				$department->setCreatedDate(date("Y-m-d H:i:s"));
				$department->setUpdatedDate(date("Y-m-d H:i:s"));
				$department->setPostData($data); 
				$department->saveDepartment();
				$responses['success_rows'][] = $key;
			} catch(Validation_Exception $e) {
				print_r($e);exit;
				$inserterror = $e->array->errors('validation',true);
				$inserterror = implode(", ",$inserterror);
			} catch(Kohana_Exception $e) {
				print_r($e);exit;
				$inserterror = $e->getMessage();
			} catch(Exception $e) {
				print_r($e);exit;
				$inserterror = $e->getMessage();
			} 
			if($inserterror) {
				$errors[$key] = $inserterror;
			}   
		} 
		$responses['errors'] = $errors; 
	}
	
	public function importvalidate()
    {
		$data = $this->getData();
        $validate = Validation::factory($data);
        $validate->label('department_name',__('Department'))
                ->rule('department_name','language_not_empty'); 
        if(empty($data['department_id'])){
			//$validate->rule('department_name',array($this,'department_name_allready_exists'), array($data['department_name']));
		}
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }
        return $this;
    }
	 
}
