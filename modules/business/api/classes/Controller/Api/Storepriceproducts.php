<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Storepriceproducts extends Controller_Rest {
	
	protected $_rest;
	protected $_resourceIndex = 'storepriceproducts';
	protected $_needApikey = false;
	protected $_needUserToken = false;
    
	public function before()
	{				
		parent::before();
		$this->_rest = App::model('api/storepriceproducts');
	}
	
	public function action_index()
	{ 		
		try
		{	
			if(isset($this->_params['storeadmin']))	{
				$this->rest_output($this->_rest->get($this->_params));
			} else {
				$this->rest_output(array( 'action' => $this->_rest->get($this->_params)));
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
	
	public function action_create()
	{ 		
				
		try
		{
			$this->rest_output( $this->_rest->create( $this->_params ) );
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
	
	public function action_delete() 
	{
		try
		{
			$this->rest_output( $this->_rest->delete( $this->_params ) );
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
