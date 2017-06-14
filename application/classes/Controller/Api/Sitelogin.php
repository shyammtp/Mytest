<?php defined('SYSPATH') or die('No direct script access.'); 
/*
    * @Front End Login Controller
*/
class Controller_Api_Sitelogin extends Controller_Rest {
	
	protected $_rest;
	protected $_resourceIndex = 'login';
	protected $_needApikey = false;
    protected $_needUserToken = false;
    /**
	 * Initialize the example model.
	 */
	public function before()
	{ 				
		parent::before();
		$this->_rest = App::model('api/sitelogin');		
	}
	
	public function action_create()
	{ 					
		try
		{	
			if(isset($this->_params['user_login_type'])) {
				if($this->_params['user_login_type'] == 2) {
					
					$this->rest_output( $this->_rest->sitelogin( $this->_params ) );
				} else if($this->_params['user_login_type'] == 3 || $this->_params['user_login_type'] == 4) {
					$this->rest_output( $this->_rest->sociallogin( $this->_params ) );
				} else {
					
					return;
				}
			} else {
				$this->rest_output( $this->_rest->sitelogin( $this->_params ) );
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
