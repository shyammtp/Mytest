<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Api_Storeuserslist extends Controller_Rest {
	
	protected $_rest;
	protected $_resourceIndex = 'userslist';
	protected $_auth_type = RestUser::AUTH_TYPE_APIKEY;
	protected $_auth_source = RestUser::AUTH_SOURCE_GET;
	protected $_needApikey = false;
    protected $_needUserToken = true;
    /**
	 * Initialize the example model.
	 */
	public function before()
	{
		parent::before();
		$this->_rest = App::model('user/api');
	}
	/**
	 * Handle GET requests.
	 */
	 
	 
	public function action_index()
	{ 
		$params = $this->_params;		
		$this->auto_render=false;
        $model = App::model('user');
		$term = '';
		if($this->getRequest()->query('term')) {
			$term = $this->getRequest()->query('term');
		}		
		try
		{
            $options = array();    
            if(isset($params['id'])) {        
				foreach($model->getPlaceCustomerByKeyword('primary_email_address',$term, $params['id']) as  $optio)
				{
					$options[] = array('label' => $optio->getData('primary_email_address')." (".$optio->getData('first_name').")" , 'value' => $optio->getData('user_id'));
				}			
				$details = array('details' => $options);
				
				$this->rest_output( array(
					'action' => $details,
				) );
			} else {
				$this->rest_output( array('code'=>401,'error'=>'Place Id is Missing'));
			}			
		}
		catch (Kohana_HTTP_Exception $khe)
		{
			return;
		}
		catch (Kohana_Exception $e)
		{
			throw $e;
		}
	}

}
