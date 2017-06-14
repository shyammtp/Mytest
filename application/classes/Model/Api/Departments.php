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
class Model_Api_Departments extends Model_RestAPI {
	 
	public function getDepartments()
	{
		$deptartments = array();
		switch(Arr::get($this->params,'for')) {
			case 'doctor':				
				$depts = App::model('core/department')->getDoctorDepartments();
				foreach($depts as $d) {
					$s = $d->getData();
					$s['icon'] = $d->getIcon();
					$deptartments[] = $s;
				}
			break;
			case 'labs':				
				$depts = App::model('core/department')->getLabsDepartments();
				foreach($depts as $d) {
					$s = $d->getData();
					$s['icon'] = $d->getIcon();
					$deptartments[] = $s;
				}
			break;
			case 'insurance':				
				$depts = App::model("insurance")->getInsurances();
				foreach($depts as $d) {
					$s = $d->getData();
					$s['logo'] = $d->getLogo();
					$deptartments[] = $s;
				}
			break;
		} 
		return array('list' => $deptartments);
	}
}	
