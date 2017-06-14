<?php defined('SYSPATH') or die('No direct script access.');  
/*
    * @Front End Signup Controller
*/
class Controller_Api_Myprofile extends Controller_Rest {
	
	protected $_rest;
	protected $_resourceIndex = 'myprofile';
	protected $_needApikey = false;
    protected $_needUserToken = false;
    /**
	 * Initialize the example model.
	 */
	public function before()
	{ 			
		parent::before();
		$this->_rest = App::model('api/userdetails');		
	}
	
	public function action_index()
	{
		
		$this->_rest->params = $this->_params;
		try
		{
			if(isset($this->_params['id'])){
				$this->rest_output($this->_rest->getProfiles($this->_params));
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
			return;
		}
		
		catch (Exception $e)
		{
			$this->_error('An internal error has occurred', 500);
			throw $e;
		}
	}
	
	public function action_update()
	{ 
		try
		{ 
			if(isset($this->_params['id'])) {
				$this->rest_output($this->_rest->updateProfile($this->_params));	
			}			
		}
		catch (Kohana_HTTP_Exception $khe)
		{
			$this->_error($khe);            
			return;
		}
		catch (Kohana_Exception $e)
		{
			$this->_error('An internal error has occurred', 500);
			throw $e;
		}
	}
} 
