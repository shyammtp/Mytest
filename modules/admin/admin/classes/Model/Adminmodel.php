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
class Model_Adminmodel extends Model_Entity_Abstract {
	
	protected $_customers = array(); 
    protected $_customer = array();
    protected $_insurancedashboard = array();
    protected $_clinicsdashboard = array();
    protected $_labsdashboard = array();
    protected $_hospitalsdashboard = array();
    protected $_pharmacydashboard = array();
    protected $_departments = array();
    protected $_optics = array();
    protected $_doctors = array();
    protected $_patients = array();
    protected $_banners = array();
    protected $_country = array();
    protected $_city = array();
    protected $_area = array();
    
    public function getCustomers()
    {
        if(!$this->_customers) {
            $this->_customers = DB::select('*')->from(array(App::model('user')->getTableName(),'main_table'))
                            ->as_object()
                            ->execute();
        }
        return $this->_customers;
    }
    
    public function getAllCustomers($time,$fromdate,$todate)
    {  						
		$date = date_create();
		date_timestamp_set($date, time());			
		switch ($time) {
					case 1:
						$from = date_format($date, 'Y-m-d 00:00:00');
						$to = date_format($date, 'Y-m-d 23:59:59');
					break;
					case 2:
						$previous_week = strtotime("-1 week +7 day");
						$start_week = strtotime("last sunday midnight",$previous_week);
						$end_week = strtotime("next saturday",$start_week);
						$from = date("Y-m-d",$start_week);
						$to = date("Y-m-d",$end_week);
					break;
					case 3:
						$from = date("Y-m-01 00:00:00");
						$to = date("Y-m-t 23:59:59");
					break;
					case 5:
						$from = urldecode($fromdate).' 00:00:00';
						$to = urldecode($todate).' 23:59:59';
					break;
					default :
						$from = date("Y-01-01 00:00:00");
						$to = date("Y-m-t 23:59:59");
			        break;
					 
		}		
        if(!$this->_customer) {
            $this->_customer = DB::select('*')->from(array(App::model('user')->getTableName(),'main_table'))
								->where('main_table.created_date', 'BETWEEN', array($from, $to))
                            ->as_object()
                            ->execute();
                            
        }
        return $this->_customer;
    }   
	
	public function getdepartments($time,$fromdate,$todate)
    {
		$date = date_create();
		date_timestamp_set($date, time());			
		switch ($time) {
					case 1:
						$from = date_format($date, 'Y-m-d 00:00:00');
						$to = date_format($date, 'Y-m-d 23:59:59');
					break;
					case 2:
						$previous_week = strtotime("-1 week +7 day");
						$start_week = strtotime("last sunday midnight",$previous_week);
						$end_week = strtotime("next saturday",$start_week);
						$from = date("Y-m-d",$start_week);
						$to = date("Y-m-d",$end_week);
					break;
					case 3:
						$from = date("Y-m-01 00:00:00");
						$to = date("Y-m-t 23:59:59");
					break;
					case 5:
						$from = urldecode($fromdate).' 00:00:00';
						$to = urldecode($todate).' 23:59:59';
					break;
					default :
						$from = date("Y-01-01 00:00:00");
						$to = date("Y-m-t 23:59:59");
					break;
					 
		}	
		 if(!$this->_departments) {
         $this->_departments = DB::select('department_id')->from(array(App::model('core/department')->getTableName(),'main_table'))
								->where('main_table.created_date', 'BETWEEN', array($from, $to))
                            ->as_object()
                            ->execute();
         }                              
        return $this->_departments;
	}
	
	public function getInsurance($time,$fromdate,$todate)
    {
		$date = date_create();
		date_timestamp_set($date, time());			
		switch ($time) {
					case 1:
						$from = date_format($date, 'Y-m-d 00:00:00');
						$to = date_format($date, 'Y-m-d 23:59:59');
					break;
					case 2:
						$previous_week = strtotime("-1 week +7 day");
						$start_week = strtotime("last sunday midnight",$previous_week);
						$end_week = strtotime("next saturday",$start_week);
						$from = date("Y-m-d",$start_week);
						$to = date("Y-m-d",$end_week);
					break;
					case 3:
						$from = date("Y-m-01 00:00:00");
						$to = date("Y-m-t 23:59:59");
					break;
					case 5:
						$from = urldecode($fromdate).' 00:00:00';
						$to = urldecode($todate).' 23:59:59';
					break;
					default :
						$from = date("Y-01-01 00:00:00");
						$to = date("Y-m-t 23:59:59");
					break;
					 
		}	
		 if(!$this->_insurancedashboard) {
         $this->_insurancedashboard = DB::select('insurance_id')->from(array(App::model('insurance')->getTableName(),'main_table'))
								->where('main_table.created_date', 'BETWEEN', array($from, $to))
                            ->as_object()
                            ->execute();
         }                              
        return $this->_insurancedashboard;
	}
	
	public function getClinics($time,$fromdate,$todate)
    {
		$date = date_create();
		date_timestamp_set($date, time());			
		switch ($time) {
					case 1:
						$from = date_format($date, 'Y-m-d 00:00:00');
						$to = date_format($date, 'Y-m-d 23:59:59');
					break;
					case 2:
						$previous_week = strtotime("-1 week +7 day");
						$start_week = strtotime("last sunday midnight",$previous_week);
						$end_week = strtotime("next saturday",$start_week);
						$from = date("Y-m-d",$start_week);
						$to = date("Y-m-d",$end_week);
					break;
					case 3:
						$from = date("Y-m-01 00:00:00");
						$to = date("Y-m-t 23:59:59");
					break;
					case 5:
						$from = urldecode($fromdate).' 00:00:00';
						$to = urldecode($todate).' 23:59:59';
					break;
					default :
						$from = date("Y-01-01 00:00:00");
						$to = date("Y-m-t 23:59:59");
					break;
					 
		}	
		 if(!$this->_clinicsdashboard) {
         $this->_clinicsdashboard = DB::select('clinic_id')->from(array(App::model('clinic')->getTableName(),'main_table'))
								->where('main_table.created_date', 'BETWEEN', array($from, $to))
								->where('main_table.type', '=',1)
                            ->as_object()
                            ->execute();
         }                              
        return $this->_clinicsdashboard;
	}
	
	
	public function getLabs($time,$fromdate,$todate)
    {
		$date = date_create();
		date_timestamp_set($date, time());			
		switch ($time) {
					case 1:
						$from = date_format($date, 'Y-m-d 00:00:00');
						$to = date_format($date, 'Y-m-d 23:59:59');
					break;
					case 2:
						$previous_week = strtotime("-1 week +7 day");
						$start_week = strtotime("last sunday midnight",$previous_week);
						$end_week = strtotime("next saturday",$start_week);
						$from = date("Y-m-d",$start_week);
						$to = date("Y-m-d",$end_week);
					break;
					case 3:
						$from = date("Y-m-01 00:00:00");
						$to = date("Y-m-t 23:59:59");
					break;
					case 5:
						$from = urldecode($fromdate).' 00:00:00';
						$to = urldecode($todate).' 23:59:59';
					break;
					default :
						$from = date("Y-01-01 00:00:00");
						$to = date("Y-m-t 23:59:59");
					break;
					 
		}	
		 if(!$this->_labsdashboard) {
         $this->_labsdashboard = DB::select('clinic_id')->from(array(App::model('clinic')->getTableName(),'main_table'))
								->where('main_table.created_date', 'BETWEEN', array($from, $to))
								->where('main_table.type', '=',3)
                            ->as_object()
                            ->execute();
         }                              
        return $this->_labsdashboard;
	}
	
	public function getHospitals($time,$fromdate,$todate)
    {
		$date = date_create();
		date_timestamp_set($date, time());			
		switch ($time) {
					case 1:
						$from = date_format($date, 'Y-m-d 00:00:00');
						$to = date_format($date, 'Y-m-d 23:59:59');
					break;
					case 2:
						$previous_week = strtotime("-1 week +7 day");
						$start_week = strtotime("last sunday midnight",$previous_week);
						$end_week = strtotime("next saturday",$start_week);
						$from = date("Y-m-d",$start_week);
						$to = date("Y-m-d",$end_week);
					break;
					case 3:
						$from = date("Y-m-01 00:00:00");
						$to = date("Y-m-t 23:59:59");
					break;
					case 5:
						$from = urldecode($fromdate).' 00:00:00';
						$to = urldecode($todate).' 23:59:59';
					break;
					default :
						$from = date("Y-01-01 00:00:00");
						$to = date("Y-m-t 23:59:59");
					break;
					 
		}	
		 if(!$this->_hospitalsdashboard) {
         $this->_hospitalsdashboard = DB::select('clinic_id')->from(array(App::model('clinic')->getTableName(),'main_table'))
								->where('main_table.created_date', 'BETWEEN', array($from, $to))
								->where('main_table.type', '=',2)
                            ->as_object()
                            ->execute();
         }                              
        return $this->_hospitalsdashboard;
	}
	
	public function getPharmacys($time,$fromdate,$todate)
    {
		$date = date_create();
		date_timestamp_set($date, time());			
		switch ($time) {
					case 1:
						$from = date_format($date, 'Y-m-d 00:00:00');
						$to = date_format($date, 'Y-m-d 23:59:59');
					break;
					case 2:
						$previous_week = strtotime("-1 week +7 day");
						$start_week = strtotime("last sunday midnight",$previous_week);
						$end_week = strtotime("next saturday",$start_week);
						$from = date("Y-m-d",$start_week);
						$to = date("Y-m-d",$end_week);
					break;
					case 3:
						$from = date("Y-m-01 00:00:00");
						$to = date("Y-m-t 23:59:59");
					break;
					case 5:
						$from = urldecode($fromdate).' 00:00:00';
						$to = urldecode($todate).' 23:59:59';
					break;
					default :
						$from = date("Y-01-01 00:00:00");
						$to = date("Y-m-t 23:59:59");
					break;
					 
		}	
		 if(!$this->_pharmacydashboard) {
         $this->_pharmacydashboard = DB::select('clinic_id')->from(array(App::model('clinic')->getTableName(),'main_table'))
								->where('main_table.created_date', 'BETWEEN', array($from, $to))
								->where('main_table.type', '=',4)
                            ->as_object()
                            ->execute();
         }                              
        return $this->_pharmacydashboard;
	}
	
	public function getOptics($time,$fromdate,$todate)
    {
		$date = date_create();
		date_timestamp_set($date, time());			
		switch ($time) {
					case 1:
						$from = date_format($date, 'Y-m-d 00:00:00');
						$to = date_format($date, 'Y-m-d 23:59:59');
					break;
					case 2:
						$previous_week = strtotime("-1 week +7 day");
						$start_week = strtotime("last sunday midnight",$previous_week);
						$end_week = strtotime("next saturday",$start_week);
						$from = date("Y-m-d",$start_week);
						$to = date("Y-m-d",$end_week);
					break;
					case 3:
						$from = date("Y-m-01 00:00:00");
						$to = date("Y-m-t 23:59:59");
					break;
					case 5:
						$from = urldecode($fromdate).' 00:00:00';
						$to = urldecode($todate).' 23:59:59';
					break;
					default :
						$from = date("Y-01-01 00:00:00");
						$to = date("Y-m-t 23:59:59");
					break;
					 
		}	
		 if(!$this->_optics) {
         $this->_optics = DB::select('clinic_id')->from(array(App::model('clinic')->getTableName(),'main_table'))
								->where('main_table.created_date', 'BETWEEN', array($from, $to))
								->where('main_table.type', '=',5)
                            ->as_object()
                            ->execute();
         }                              
        return $this->_optics;
	}
	
	public function getDoctors()
    {
        if(!$this->_doctors) {
            $this->_doctors = DB::select('user_id')->from(array(App::model('user')->getTableName(),'main_table'))
							->where('main_table.user_type', '=',1)
                            ->as_object()
                            ->execute();
        }
        return $this->_doctors;
    }
    
    public function getPatients()
    {
        if(!$this->_patients) {
            $this->_patients = DB::select('user_id')->from(array(App::model('user')->getTableName(),'main_table'))
							->where('main_table.user_type', '=',2)
                            ->as_object()
                            ->execute();
        }
        return $this->_patients;
    }
    
    
    public function getBanners()
    {
        if(!$this->_banners) {
            $this->_banners = DB::select('banner_setting_id')->from(array(App::model('core/banner')->getTableName(),'main_table'))
                            ->as_object()
                            ->execute();
        }
        return $this->_banners;
    }
    
    public function getCountry()
    {
        if(!$this->_country) {
            $this->_country = DB::select('country_id')->from(array(App::model('directory/country')->getTableName(),'main_table'))
                            ->as_object()
                            ->execute();
        }
        return $this->_country;
    }
    
    
    public function getCity()
    {
        if(!$this->_city) {
            $this->_city = DB::select('city_id')->from(array(App::model('directory/city')->getTableName(),'main_table'))
                            ->as_object()
                            ->execute();
        }
        return $this->_city;
    }
    
    
    public function getArea()
    {
        if(!$this->_area) {
            $this->_area = DB::select('area_id')->from(array(App::model('core/area')->getTableName(),'main_table'))
                            ->as_object()
                            ->execute();
        }
        return $this->_area;
    }
}
