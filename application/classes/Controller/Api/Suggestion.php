<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Suggestion extends Controller_Rest {
  
	protected $_rest;
	protected $_resourceIndex = 'suggestions';
	protected $_needApikey = false;
    protected $_needUserToken = false;
    /**
	 * Initialize the example model.
	 */
	public function before()
	{ 
		parent::before();
		$this->_rest = App::model('search/api');
	}
	
	public function action_index()
	{
		 exit('d');
		$this->_rest->params = $this->_params;
		try
		{			 
			$this->rest_output($this->_rest->getSuggestions());
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
