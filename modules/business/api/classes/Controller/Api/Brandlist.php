<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Brandlist extends Controller_Rest {
	
	protected $_rest;
	protected $_resourceIndex = 'brandlist';
	protected $_needApikey = false;
	protected $_needUserToken = false;
    
	public function before()
	{				
		parent::before();		
		$this->_rest = App::model('api/brandlist');
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
