<?php defined('SYSPATH') or die('No direct script access.');  
/*
    * @Front End Signup Controller
*/
class Controller_Api_Registermobile extends Controller_Rest {
	
	protected $_rest;
	protected $_resourceIndex = 'registermobile';
	protected $_needApikey = false;
    protected $_needUserToken = false;
    /**
	 * Initialize the example model.
	 */
	public function before()
	{ 				
		parent::before();
		$this->_rest = App::model('api/registermobile');		
	}
	
	/**
	 * Handle POST requests.
	 */
	public function action_create()
	{
		$this->_rest->params = $this->_params;
		try
		{ 
			$this->rest_output( $this->_rest->addActivity());
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
	
	/**
	 * Handle DELETE requests.
	 */
	public function action_delete()
	{
		$this->_rest->params = $this->_params;
		try
		{
			$this->rest_output( $this->_rest->delete());
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
		catch (Kohana_Exception $e)
		{
			$this->_error('An internal error has occurred', 500);
			throw $e;
		}
	}
	
} 
