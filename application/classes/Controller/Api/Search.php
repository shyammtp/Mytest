<?php defined('SYSPATH') or die('No direct script access.');  
/*
    * @Front End Signup Controller
*/
class Controller_Api_Search extends Controller_Rest {
	
	protected $_rest;
	protected $_resourceIndex = 'search';
	protected $_needApikey = false;
    protected $_needUserToken = false;
    /**
	 * Initialize the example model.
	 */
	public function before()
	{ 				
		parent::before();
		$this->_rest = App::model('api/search');		
	}
	
	public function action_index()
	{
		$this->_rest->params = $this->_params;
		try
		{
			if(isset($this->_params['for'])) {
				if($this->_params['for'] == 'suggestion') {
					$this->rest_output($this->_rest->getSuggestions());
				}
				else if($this->_params['for'] == 'doctor') {
					$this->rest_output($this->_rest->getDoctors());
				} else {
					$this->rest_output($this->_rest->getMedicalPlaces());
				}
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
} 
