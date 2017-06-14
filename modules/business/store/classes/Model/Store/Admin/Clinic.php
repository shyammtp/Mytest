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
class Model_Admin_Clinic extends Model_Clinic {

    public function __construct()
    { 
        parent::__construct(); //this needs to be called mandatory after defining table and primary key
    }
    
    
	
	public function importData($file, $data, &$responses)
	{ 
		$errors = array(); 
		$spreadsheet = Spreadsheet::factory(array('filename' => '../uploads/import/'.$file,'csv_values' => array('delimiter' => ';', 'lineEnding' => "\r\n")), TRUE)->load()->read(); 
		foreach($spreadsheet as $key => $sheet) {
			$inserterror = false;
			if($key == 1) {
				continue;
			}
			$data = array();
			try {
				$TYPE = strtoupper(trim(Arr::get($sheet,'A',NULL)));
				if($TYPE == 'CLINIC'){
					$type = 1;
				}elseif($TYPE == 'HOSPITAL'){
					$type = 2;
				}elseif($TYPE == 'LABS'){
					$type = 3;
				}elseif($TYPE == 'PHARMACY'){
					$type = 4;
				}elseif($TYPE == 'OPTICS'){
					$type = 5;
				}
				$medical = App::model('clinic',false);
				$data['clinic_name'][1] = trim(Arr::get($sheet,'B',NULL));
				$data['clinic_name'][2] = trim(Arr::get($sheet,'C',NULL));
				$data['sub_text'][1] = trim(Arr::get($sheet,'D',NULL));
				$data['sub_text'][2] = trim(Arr::get($sheet,'E',NULL));
				$data['type'] = $type;
				$data['address'] = trim(Arr::get($sheet,'F',NULL));
				$data['about'] = trim(Arr::get($sheet,'G',NULL));
				$data['deparment_id'] = trim(Arr::get($sheet,'H',NULL));
				$data['insurance'] = trim(Arr::get($sheet,'I',NULL));
				$doctor_id_str = trim(Arr::get($sheet,'J',NULL)); 
				$doctor_id_arr = explode(",",$doctor_id_str);
				$data['doctor_id'] = trim(Arr::get($sheet,'J',NULL));
				$data['phone'] = trim(Arr::get($sheet,'K',NULL));
				$data['facilities'] = trim(Arr::get($sheet,'L',NULL));
				$data['services'] = trim(Arr::get($sheet,'M',NULL));
				$data['clinic_status'] = 1;
				$medical->addData($data);
				//$medical->importvalidate();
				$medical->setCreatedDate(date("Y-m-d H:i:s"));
				$medical->setUpdatedDate(date("Y-m-d H:i:s"));
				$medical->setPostData($data);
				$medical->saveClinic();
				$responses['success_rows'][] = $key;
			} catch(Validation_Exception $e) {
				$inserterror = $e->array->errors('validation',true);
				$inserterror = implode(", ",$inserterror);
			} catch(Kohana_Exception $e) {
				$inserterror = $e->getMessage();
			} catch(Exception $e) {
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
        $validate->label('clinic_name',__(':place_name name',array(':place_name' => App::registry('place_name'))))
                ->rule('clinic_name','language_not_empty'); 
                
        if(empty($data['clinic_id'])){
			//$validate->rule('clinic_name',array($this,'clinic_name_allready_exists'), array($data['clinic_name']));
		} 
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }
        return $this;
    }
    
}
