<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Changepassword extends Controller_Rest {
	
	protected $_rest;
	protected $_auth_type = RestUser::AUTH_TYPE_APIKEY;
	protected $_auth_source = RestUser::AUTH_SOURCE_GET;
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

	/**
	 * Handle POST requests.
	 */
	public function action_create()
	{ 
		try
		{ 
			$this->rest_output( $this->_rest->password_update($this->_params));
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
