<?php defined('SYSPATH') or die('No direct script access.');  
/*
    * @Front End Signup Controller
*/
class Controller_Api_Clinics extends Controller_Rest {
	
	protected $_rest;
	protected $_resourceIndex = 'clinics';
	protected $_needApikey = false;
    protected $_needUserToken = false;
    /**
	 * Initialize the example model.
	 */
	public function before()
	{ 				
		parent::before();
		$this->_rest = App::model('api/clinics');		
	}
	
	public function action_index()
	{
		$this->_rest->params = $this->_params;
		try
		{
			if($this->_params['type']==1){
				$this->rest_output($this->_rest->getDepartments());
			}elseif($this->_params['type']==2){
				$this->rest_output($this->_rest->getClinics());
			}elseif($this->_params['type']==3){
				$this->rest_output($this->_rest->getInsurances());
			}
		}
		catch (Kohana_HTTP_Exception $khe)
		{
			$this->_error($khe);
			return;
		}
		catch (Kohana_Exception $e)
		{
			$this->_error($e);
			throw $e;
			return;
		}
		
		catch (Exception $e)
		{
			$this->_error('An internal error has occurred', 500);
			throw $e;
		}
	}
} 
