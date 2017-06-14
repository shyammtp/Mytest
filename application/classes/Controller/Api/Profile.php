<?php defined('SYSPATH') or die('No direct script access.');  
/*
    * @Front End Signup Controller
*/
class Controller_Api_Profile extends Controller_Rest {
	
	protected $_rest;
	protected $_resourceIndex = 'profile';
	protected $_needApikey = false;
    protected $_needUserToken = false;
    /**
	 * Initialize the example model.
	 */
	public function before()
	{ 				
		parent::before();
		$this->_rest = App::model('api/profile');		
	}
	
	public function action_index()
	{
		$this->_rest->params = $this->_params;
		try
		{
			if(isset($this->_params['for']) && $this->_params['for'] == 'timings'){
				$this->rest_output($this->_rest->getTimings());
			} if(isset($this->_params['for']) && $this->_params['for'] == 'photos'){				
				$this->rest_output($this->_rest->getPhotos());
			}
			if(isset($this->_params['for']) && $this->_params['for'] == 'videos'){				
				$this->rest_output($this->_rest->getVideos());
			}
			if(isset($this->_params['for']) && $this->_params['for'] == 'appointments'){				
				$this->rest_output($this->_rest->getAppointments());
			}
			if(isset($this->_params['for']) && $this->_params['for'] == 'rotatedoctors'){				
				$this->rest_output($this->_rest->getDoctorTimings());
			}
			if(isset($this->_params['for']) && $this->_params['for'] == 'rotatedoctorslists'){	
				$this->rest_output($this->_rest->getDoctorLists());
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
	
	public function action_create()
	{
		$this->_rest->params = $this->_params;
		try
		{
			if(isset($this->_params['for']) && $this->_params['for'] == 'photos'){				
				$this->rest_output($this->_rest->addphotos());
			}
			if(isset($this->_params['for']) && $this->_params['for'] == 'videos'){				
				$this->rest_output($this->_rest->addvideo());
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
	
	public function action_delete()
	{
		$this->_rest->params = $this->_params;
		try
		{
			if(isset($this->_params['for']) && $this->_params['for'] == 'photos'){				
				$this->rest_output($this->_rest->deletephotos());
			}
			if(isset($this->_params['for']) && $this->_params['for'] == 'videos'){				
				$this->rest_output($this->_rest->deletevideos());
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
	
	public function action_update()
	{
		$this->_rest->params = $this->_params; 
		
		try
		{
			if(isset($this->_params['for']) && $this->_params['for'] == 'timings'){
				
				$this->rest_output($this->_rest->updateTimings());
			}
			if(isset($this->_params['for']) && $this->_params['for'] == 'settings'){				
				$this->rest_output($this->_rest->updateSettings());
			}
			if(isset($this->_params['for']) && $this->_params['for'] == 'appointments'){				
				$this->rest_output($this->_rest->updateAppointment());
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
