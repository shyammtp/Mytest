<?php defined('SYSPATH') or die('No direct script access.');  

class Controller_Api_Translate extends Controller_Rest {
	
	protected $_rest;
	protected $_resourceIndex = 'translate';
	protected $_needApikey = false;
    protected $_needUserToken = false;
  
	public function action_index()
    {
        //$this->auto_render = false; 
        $messages = I18n::load(App::getCurrentLang()->getLanguageCode());
        try
		{			 
			$this->rest_output($messages);
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
