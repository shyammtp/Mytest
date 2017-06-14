<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Searchproducts extends Controller_Rest {
	
	protected $_rest;
	protected $_resourceIndex = 'searchproducts';
	protected $_needApikey = true;
	protected $_needUserToken = true;
    
	public function before()
	{				
		parent::before();
		$this->_rest = App::model('api/searchproducts');
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
		
}
