<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Appointments extends Controller_Rest {
	
	protected $_rest;
	protected $_resourceIndex = 'appointments';
	protected $_needApikey = true;
	protected $_needUserToken = true;
    
	public function before()
	{				
		parent::before();
		$this->_rest = App::model('api/appointments');
	}
	
	public function action_index()
	{ 	
		try
		{		
			$this->rest_output( array(
				'action' => $this->_rest->get($this->_params),
			) );
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
	
	/**
	 * Handle PUT requests.
	 */
	 
	public function action_update()
	{ 			
		try
		{
			$this->rest_output( $this->_rest->update( $this->_params ) );
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
	
	
}
