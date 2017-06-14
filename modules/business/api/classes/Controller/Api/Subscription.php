<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Subscription extends Controller_Rest {
	
	protected $_rest;
	protected $_resourceIndex = 'subscription';
	protected $_needApikey = true;
	protected $_needUserToken = false;
    
	public function before()
	{				
		parent::before();
		$this->_rest = App::model('api/subscription');
	}
	
	public function action_index()
	{ 	
		try
		{	
			$this->rest_output( array(
				'promotion_subscription' => $this->_rest->get($this->_params),
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
