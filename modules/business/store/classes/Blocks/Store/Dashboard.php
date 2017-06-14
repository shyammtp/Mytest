<?php defined('SYSPATH') or die('No direct script access.');

class Blocks_Store_Dashboard extends Blocks_Store_Abstract {
	
	protected $_clinics;
	protected $_labs;
	protected $_hospitals;
	protected $_pharmacy;
	protected $_optics;
	protected $_doctors;
	
	public function __construct()
    { 
		 parent::__construct();
	}
	
	protected function _getClinics($type='')
    {  
		 
		
    }
    
    protected function _getDoctors()
    {  
		 
    }

}
