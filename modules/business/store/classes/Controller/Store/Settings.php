<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Store_Settings extends Controller_Core_Store { 
	protected $_fields = array();
	
	public function preDispatch()
	{ 
		$this->_noAccessCheckAction = array('addquickacess');
		parent::preDispatch();
	}
	
	protected function _getLocaleArray()
	{
		return App::model('core/language')->getOptionArray();
	}
	
	public function action_general()
	{
		$config = App::model('configuration');
		$storeThemes = array_values(array_diff(scandir(DOCROOT.'assets/store/'), array('..', '.','.svn')));
		$themes = array();
		foreach($storeThemes as $theme) {
			$themes[$theme] = ucfirst($theme);
		} 
		$this->_fields = array(
			'general' => array(
				'title' => __('General'),
				'fields' => array(
					'THEMES_COLOR' => array(
						'title' => 'Themes Color', 
						//'hint' => 'Theme Color', 
						'type' => 'select',
						'validation' => 'required',
						'options' => $themes,
						'value' => $config->getConfiguration('THEMES_COLOR'),
						'default_value' => 'base',
						'id' => 'select2',
						'style' => 'width:100%;',
						//'scripts' => '$(document).ready(function(){ $("#select2").select2(); $("#select2").focus();  });',
						'renderer' => 'Store/Settings/Themecolor',
					),
					'STOREADMIN_LOGO' => array(
						'title' => 'Logo', 
						'hint' => 'Upload type is *.jpg, *.png, *.jpeg', 
						'type' => 'image',
						'validation' => 'checktype',
						'file_type' => array('jpg','png','jpeg'), 
						'value' => $config->getConfiguration('STOREADMIN_LOGO'),
						'upload_path' => Model_Configuration::UPLOAD_DIRECTORY,
					),
				),
			),
			/*'locale' => array(
				'title' => __('Locale Options'),
				'fields' => array(
					'LOCALE' => array(
						'title' => 'Choose your language',
						'hint' => 'Store Language', 
						'type' => 'select',  
						'id' => 'localeselect',
						'style' => 'width:100%;',
						'options' => $this->_getLocaleArray(),
						'value' => $config->getConfiguration('LOCALE'),
						'scripts' => '$(document).ready(function(){ $("#localeselect").select2();});'
					),
				),
			),
			'default_currency' => array(
				'title' => __('Default Currency'),
				'fields' => array(
					'DEFAULT_CURRENCY' => array(
						'title' => 'Choose your currency',
						'type' => 'select',
						'validation' => 'required',
						'id' => 'currencyselect',
						'style' => 'width:100%;',
						'options' => $this->_getCurrencyArray(),
						'value' => $config->getConfiguration('DEFAULT_CURRENCY'),
						'scripts' => '$(document).ready(function(){ $("#currencyselect").select2();});'
					), 
				),
			),*/
			/*'user_notification_settings' => array(
				'title' => __('User Notification Settings'),
				'fields' => array(
						'SYSTEM_NOTIFICATION' => array(
						'title' => 'Enable',
						'hint' => 'User System Notification Enable',
						'type' => 'select',
						'options' => array('1' => __('Yes'),'0' => __('No')),
						'value' => $config->getConfiguration('SYSTEM_NOTIFICATION'),
						'default_value' => '0',
						'id' => 'select-notification',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#select-notification").select2();});'
						),
						'EMAIL_NOTIFICATION' => array(
						'title' => 'Enable',
						'hint' => 'User Email Notification Enable',
						'type' => 'select',
						'options' => array('1' => __('Yes'),'0' => __('No')),
						'value' => $config->getConfiguration('EMAIL_NOTIFICATION'),
						'default_value' => '0',
						'id' => 'email-notification',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#email-notification").select2();});'
						),
					),
				),
			'payments_method' => array(
				'title' => __('Payment Method'),
				'fields' => array(
					'PAYMENTS_METHOD' => array(
						'title' => 'Choose your payment',
						'type' => 'select',
						'validation' => 'required',
						'id' => 'paymentselect',						
						'style' => 'width:100%;',
						'options' => $this->_getPaymentArray(),
						'value' => $config->getConfiguration('PAYMENTS_METHOD'),
						'scripts' => '$(document).ready(function(){ $("#paymentselect").select2({placeholder: "Select a method"});});',
						'renderer'=>'Store/Paymentsettings',
					), 
				),
			),*/
			/**'user_rating_count_settings' => array(
				'title' => __('Place rating show count '),
				'fields' => array(
						'USER_PLACE_RATING_COUNT' => array(
						'title' => 'minimum user rating count',
						'hint' => 'user rating show in place after reach this count ', 
						'type' => 'text',
						'class' => 'form-control input-sm',
						'validation' => array('required','isnumeric'),
						'value' => $config->getConfiguration('USER_PLACE_RATING_COUNT'), 
					),
				),
			),
			'user_product_rating_count_settings' => array(
				'title' => __('Product rating show count '),
				'fields' => array(
						'USER_PRODUCT_RATING_COUNT' => array(
						'title' => 'minimum user product rating count',
						'hint' => 'product rating show in product after reach this count ', 
						'type' => 'text',
						'class' => 'form-control input-sm',
						'validation' => array('required','isnumeric'),
						'value' => $config->getConfiguration('USER_PRODUCT_RATING_COUNT'), 
					),
				),
			),
			'user_people_rating_count_settings' => array(
				'title' => __('People rating show count '),
				'fields' => array(
						'USER_PEOPLE_RATING_COUNT' => array(
						'title' => 'minimum people rating count',
						'hint' => 'people rating show in people after reach this count ', 
						'type' => 'text',
						'class' => 'form-control input-sm',
						'validation' => array('required','isnumeric'),
						'value' => $config->getConfiguration('USER_PEOPLE_RATING_COUNT'), 
					),
				),
			),**/
				
		);
		$this->loadBlocks('settings'); 
		$this->getBlock('forms')->setFields($this->_fields);
		$this->getBlock('head')->setTitle('General Settings');
		$this->getBlock('content')->setPageTitle('General Settings');
		$this->getBlock('leftmenu')->setActive('settings/general');
		$this->getBlock('breadcrumbs')
		->addCrumb('general_settings',array('label' => __('General Settings'),
										'title' => __('General Settings')
					));
		$this->renderBlocks(); 
	}
	
	protected function _getCurrencyArray()
	{
		return App::model('core/currency')->getOptionArray();
	}
	
	protected function _getPaymentArray()
	{				
		return array(1=>'Online payment',2=>'Payment on delivery');		
	}

	public function action_profile()
	{ 
		$store_owner = App::instance()->getWebsite()->getWebsiteId();
		$Session_Details = App::model('store/session')->getCustomer();
		$this->loadBlocks('customer/editcustomerprofile');
		$contentblock = $this->getBlock('content');
		$breadcrumb = $this->getBlock('breadcrumbs');
		if($Session_Details->getCustomerId()){
			
			$this->getBlock('head')->setTitle(__('My Account - Store'));
			$contentblock->setPageTitle(__('My Account'));
			$breadcrumb->addCrumb('editCustomerprofile',array('label' => __('My Account'),
												'title' => __('My Account')
							)); 
		} 
		$this->renderBlocks();
	} 
	
	public function action_timesettings()
	{
		$this->loadBlocks('timesettings');
		$this->renderBlocks();
	}
	
	public function action_addquickacess()
	{
		$this->auto_render = false;
		$request = $this->getRequest();
		$json = array();
		$url = $request->post('pageurl');
		if($url) {
			$model = App::model('core/quick_access')->load($url, 'link');
			try {
				if($request->post('method') == 'add') {
					$model->setPlaceId(App::instance()->getPlace()->getPlaceId());
					$model->setUserId(App::model('store/session')->getCustomer()->getUserId());
					$model->setName($request->post('name'));
					$model->setLink($url);
					$model->save();
					$json['success'] = __('Access added');
				}
				if($request->post('method') == 'remove') {
					$model->deleteaccess($url);
					$json['success'] = __('Access removed');
				}
			} catch(Kohana_Exception $ke) {
				Log::Instance()->add(Log::ERROR, $ke);

			} catch (Exception $e) {
				$json['error'] = __('Problem in the server.');
				Log::Instance()->add(Log::ERROR, $e);
			}
		}
		$this->getResponse()->body(json_encode($json));
	}	

} // End Dashboard
