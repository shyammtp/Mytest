<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Settings extends Controller_Core_Admin {
	protected $_fields = array();
	
	public function preDispatch()
	{ 
		$this->_noAccessCheckAction = array('addquickacess');
		parent::preDispatch();
	}
	
	public function action_index()
	{
		$this->loadBlocks('settings/index');
		$this->renderBlocks();
	}

	public function action_general()
	{  
		$config = App::model('configuration');
		$adminThemes = array_values(array_diff(scandir(DOCROOT.'assets/admin/'), array('..', '.','.svn')));
		$themes = array();
		foreach($adminThemes as $theme) {
			$themes[$theme] = ucfirst($theme);
		}
		$themescolor = array('red' => 'Red','green' => 'Green','teal' => 'Teal');
		$this->_fields = array(
			'general' => array(
				'title' => __('General'),
				'note' => __('Admin general settings'),
				'fields' => array(
					'SITE_NAME' => array(
						'title' => 'Site Name',
						'hint' => 'This name will visible as a title in frontend',
						'type' => 'text',
						'class' => 'form-control',
						'validation' => 'required',
						'value' => $config->getConfiguration('SITE_NAME'),
					),					
					'META_TITLE' => array(
						'title' => 'Meta Title',
						'hint' => 'This name will visible as a title in frontend',
						'type' => 'text',
						'class' => 'form-control',
						'validation' => 'required',
						'value' => $config->getConfiguration('META_TITLE'),
					),
					'META_KEYWORDS' => array(
						'title' => 'Meta Keywords',
						'hint' => 'This add as meta keywords in frontend',
						'type' => 'text',
						'class' => 'form-control',
						'validation' => 'required',
						'value' => $config->getConfiguration('META_KEYWORDS'),
					),
					'META_DESCRIPTION' => array(
						'title' => 'Meta Description',
						'hint' => 'This add as meta description frontend',
						'type' => 'editor',
						'validation' => 'required',
						'class' => 'form-control',
						'value' => $config->getConfiguration('META_DESCRIPTION'),
					),
					/*'THEMES' => array(
						'title' => 'Themes',
						'hint' => ' For admin',
						'type' => 'select',
						'validation' => 'required',
						'options' => $themes,
						'value' => $config->getConfiguration('THEMES'),
						'default_value' => 'base',
						'id' => 'select-basic',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#select-basic").select2();});'
					),*/'THEMES_COLOR' => array(
						'title' => 'Themes Color',
						'hint' => ' For admin',
						'type' => 'select',
						'validation' => 'required',
						'options' => $themescolor,
						'value' => $config->getConfiguration('THEMES_COLOR'),
						'default_value' => 'base',
						'id' => 'themcolor-select-basic',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#themcolor-select-basic").select2();});'
					),
					'ADMIN_LOGO' => array(
						'title' => 'Logo',
						'hint' => 'Upload type is *.jpg, *.png, *.jpeg',
						'type' => 'image',
						'preview-width' => '100',
						'validation' => 'checktype',
						'file_type' => array('jpg','png','jpeg'),
						'value' => $config->getConfiguration('ADMIN_LOGO'),
						'upload_path' => Model_Configuration::UPLOAD_DIRECTORY,
					),
					'ADMIN_HORIZONTAL_LOGO' => array(
						'title' => 'Horizontal Logo',
						'hint' => 'Upload type is *.jpg, *.png, *.jpeg',
						'type' => 'image',
						'preview-width' => '100',
						'validation' => 'checktype',
						'file_type' => array('jpg','png','jpeg'),
						'value' => $config->getConfiguration('ADMIN_HORIZONTAL_LOGO'),
						'upload_path' => Model_Configuration::UPLOAD_DIRECTORY,
					),
					'FAVICON' => array(
						'title' => 'Favicon',
						'hint' => 'Upload type is *.ico',
						'type' => 'image',
						'preview-width' => '16',
						'validation' => array('checktype'),
						'file_type' => array('ico'),
						'value' => $config->getConfiguration('FAVICON'),
						'upload_path' => Model_Configuration::UPLOAD_DIRECTORY,
					),
					/*'GOOGLE_MAP_APIKEY' => array(
						'title' => 'Add the api key',
						'hint' => 'create a API and paste in here <a href="https://developers.google.com/maps/documentation/javascript/get-api-key">https://developers.google.com/maps/documentation/javascript/get-api-key</a>', 
						'type' => 'text',
						'style' => 'width:100%;', 
						'value' => $config->getConfiguration('GOOGLE_MAP_APIKEY')
					),
					'GOOGLE_LATLONG' => array(
						'title' => 'Pin your office location',
						'hint' => 'Locate your office', 
						'type' => 'text',
						'style' => 'width:100%;', 
						'value' => $config->getConfiguration('GOOGLE_LATLONG'),
						'renderer'=>'Admin/Settings/Googlemap',
					),
					'SITE_CONTACT_ADDRESS' => array(
						'title' => 'Company contact address',
						'hint' => 'Company contact address',  
						'type' => 'editor',
						'validation' => 'required',
						'class' => 'form-control',
						'style' => 'width:100%;', 
						'value' => $config->getConfiguration('SITE_CONTACT_ADDRESS')
					), */
				),
			),
			/** 'email_template' => array(
				'title' => 'Email  Templates',
				'fields' => array(
				),
			),
			**/
			
			'web_urls' => array(
				'title' => __('URLs'),
				'fields' => array(
					'ASSETS_URL' => array(
						'title' => 'Assets path URL',
						'type' => 'text',
						'id' => 'assets_path_url',
						'style' => 'width:100%;', 
						'value' => $config->getConfiguration('ASSETS_URL')
					),
					'UPLOADS_URL' => array(
						'title' => 'Uploads path URL',
						'type' => 'text',
						'id' => 'assets_path_url',
						'style' => 'width:100%;', 
						'value' => $config->getConfiguration('UPLOADS_URL')
					),
					'FACEBOOK_PAGE' => array(
						'title' => 'Facebook Page URL',
						'type' => 'text',
						'id' => 'facebook_path_url',
						'style' => 'width:100%;', 
						'value' => $config->getConfiguration('FACEBOOK_PAGE')
					),
					'TWITTER_PAGE' => array(
						'title' => 'Twitter Page URL',
						'type' => 'text',
						'id' => 'twt_path_url',
						'style' => 'width:100%;', 
						'value' => $config->getConfiguration('TWITTER_PAGE')
					),
					'YOUTUBE_PAGE' => array(
						'title' => 'Youtube Page URL',
						'type' => 'text',
						'id' => 'yt_path_url',
						'style' => 'width:100%;', 
						'value' => $config->getConfiguration('YOUTUBE_PAGE')
					),
					'PLAYSTORE_LINK' => array(
						'title' => 'Google play store link',
						'type' => 'text',
						'id' => 'gp_path_url',
						'style' => 'width:100%;', 
						'value' => $config->getConfiguration('PLAYSTORE_LINK')
					),
					
					'APPSTORE_LINK' => array(
						'title' => 'App store link',
						'type' => 'text',
						'id' => 'app_path_url',
						'style' => 'width:100%;', 
						'value' => $config->getConfiguration('APPSTORE_LINK')
					),
					
					
					
					/** 'GEOSERVER_URL' => array(
						'title' => 'Geoserver URL',
						'hint' => ' for Data entry APP',
						'type' => 'text',
						'validation' => 'required',
						'class' => 'form-control',
						'value' => $config->getConfiguration('GEOSERVER_URL'),
					),
					**/ 
				),
			),
			/** 'owner_api_key' => array(
				'title' => __('Owner Api Authentication Key'),
				'fields' => array(
					'API_KEY' => array(
						'title' => 'Owner Api Authentication Key',
						'type' => 'text',
						'id' => 'assets_path_url',
						'style' => 'width:100%;', 
						'value' => $config->getConfiguration('API_KEY')
					),
					'PAYMENT_STATUS_TEMP' => array(
						'title' => 'Temporary Payment status for developer',
						'type' => 'select',
						'validation' => 'required',
						'id' => 'paymenttempstatus',
						'style' => 'width:100%;',
						'options' => array(
							'1' => 'Success',
							'2' => 'Failure',
						),
						'value' => $config->getConfiguration('PAYMENT_STATUS_TEMP'),
						'scripts' => '$(document).ready(function(){ $("#paymenttempstatus").select2();});'
					),
					
					'ANDROID_PACKEGE_API_KEY' => array(
						'title' => 'Store Admin Android Package Api Key',
						'type' => 'text',
						'id' => 'assets_path_url',
						'style' => 'width:100%;', 
						'value' => $config->getConfiguration('ANDROID_PACKEGE_API_KEY')
					), 
					'FRONTEND_ANDROID_PACKAGE_API_KEY' => array(
						'title' => 'Frontend Android Package Api Key',
						'type' => 'text',
						'id' => 'frontend_api_key',
						'style' => 'width:100%;', 
						'value' => $config->getConfiguration('FRONTEND_ANDROID_PACKAGE_API_KEY')
					),
					 
				),
			),
			**/ 
			'locale' => array(
				'title' => __('Locale Options'),
				'fields' => array(
					'LOCALE' => array(
						'title' => 'Choose your language',
						'type' => 'select',
						'validation' => 'required',
						'id' => 'localeselect',
						'style' => 'width:100%;',
						'options' => $this->_getLocaleArray(),
						'value' => $config->getConfiguration('LOCALE'),
						'scripts' => '$(document).ready(function(){ $("#localeselect").select2();});'
					),
					/*'COUNTRY' => array(
						'title' => 'Choose your default country',
						'type' => 'select',
						'validation' => 'required',
						'id' => 'countryselect',
						'style' => 'width:100%;',
						'options' => $this->_getCountryArray(),
						'value' => $config->getConfiguration('COUNTRY'),
						'scripts' => '$(document).ready(function(){ $("#countryselect").select2();});'
					),*/
				),
			),
			/**'default_currency' => array(
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
					'CURRENCY_EXCHANGE_RATE' => array(
						'title' => 'Exchange rates',
						'type' => 'text', 
						'id' => 'exchange_rate',
						'style' => 'width:100%;', 
						'value' => $config->getConfiguration('CURRENCY_EXCHANGE_RATE'),
						'scripts' => '$(document).ready(function(){ $("#currencyselect").select2();});',
						'renderer' => 'Admin/Settings/Exchangerate'
					),
					'CURRENCY_DISPLAY_FRONTEND' => array(
						'title' => 'Currency Display',
						'type' => 'select', 
						'id' => 'currency_display',
						'class' => 'form-control',
						'style' => 'width:100%;', 
						'value' => $config->getConfiguration('CURRENCY_DISPLAY_FRONTEND'),
						'options' => array('1' => 'Symbol','2' => 'Code')
					),
				),
			),
			
			'user_notification_settings' => array(
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
				),**/
				
			'copyrights' => array(
				'title' => __('Copyrights'),
				'fields' => array(
					'COPYRIGHTS' => array(
						'title' => 'Copyrights',
						'hint' => 'This name will visible as a footer copyrights in admin & frontend',
						'type' => 'text',
						'class' => 'form-control',
						'validation' => 'required',
						'value' => $config->getConfiguration('COPYRIGHTS'),
					)
				),
			),
			/** 'google_map_settings' => array(
				'title' => __('Google Map Settings'),
				'fields' => array(
					'GOOGLE_MAP_STYLE' => array(
						'title' => 'Google Map style',
						'hint' => 'create a style and paste in here <a href="https://snazzymaps.com/" target="_blank">https://snazzymaps.com/</a>',
						'type' => 'editor',
						'class' => 'form-control',
						'validation' => 'required',
						'value' => $config->getConfiguration('GOOGLE_MAP_STYLE'),
					)
				),
			),
			'peoples' => array(
				'title' => __('People Fees Labels'),
				'fields' => array(
					'FEES_LABELS' => array(
						'title' => 'People Fees Labels',
						'hint' => 'This label will visible in add people fees label',
						'type' => 'text',
						'class' => 'form-control',
						'validation' => 'required',
						'value' => $config->getConfiguration('FEES_LABELS'),
					)
				),
			),	
			
			'frontend_blocks' => array(
				'title' => __('Frontend Blocks'),
				'fields' => array(
					'HOMEPAGE_LEFT_CONTENT' => array(
						'title' => 'Home Page Left',
						'hint' => 'Home page left side content',
						'type' => 'select',
						'style' => 'width:100%',
						'id' => 'homepageleft',
						'options' => $this->_getCmsBlocks(),
						'value' => $config->getConfiguration('HOMEPAGE_LEFT_CONTENT'),
						'scripts' => '$(document).ready(function(){ $("#homepageleft").select2();});'
					)
				),
			),**/ 	

		); 
		$this->loadBlocks('settings');
		$this->getBlock('general_forms')->setFields($this->_fields);
		$this->renderBlocks();
	}
	
	protected function _getCmsBlocks()
	{
		$cmsblocks = App::model('cms/cms_blocks')->toOptionArray();
		$blocks = array();
		foreach($cmsblocks as $b) {
			$blocks[$b['index']] = $b['title'];
		}
		return $blocks;
	}


	protected function _getLocaleArray()
	{
		return App::model('core/language')->getOptionArray();
	}
	
	protected function _getCountryArray()
	{
		return array();
	}

	protected function _getCurrencyArray()
	{
		return App::model('admin/currency_settings')->getOptionArray();
	}
	
	public function action_users_templates()
	{ 
		$config = App::model('configuration');
		$adminThemes = array_values(array_diff(scandir(DOCROOT.'assets/admin/'), array('..', '.','.svn')));
		$themes = array();
		foreach($adminThemes as $theme) {
			$themes[$theme] = ucfirst($theme);
		}
		$this->_fields = array(
			'users_template' => array(
				'title' => __('User Email Templates'),
				'note' => __('User Email Templates'),
				'fields' => array(
					'ROLE_DELETE_USER_NOTIFICATION_EMAIL_TEMPLATE' => array(
						'title' => 'Role delete user notification email template',
						'hint' => 'email template for role deletion',
						'type' => 'select',
						'validation' => 'required',
						'options' => App::model('admin/email_template')->toOptionArray(),
						'value' => $config->getConfiguration('ROLE_DELETE_USER_NOTIFICATION_EMAIL_TEMPLATE'),
						//'default_value' => 'base',
						'id' => 'role_delete-template',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#role_delete-template").select2();});'
					),
					'ADMIN_FORGOT_PASSWORD_EMAIL_TEMPLATE' => array(
						'title' => 'Forgot Password email template',
						'hint' => 'email template for forgot password',
						'type' => 'select',
						'validation' => 'required',
						'options' => App::model('admin/email_template')->toOptionArray(),
						'value' => $config->getConfiguration('ADMIN_FORGOT_PASSWORD_EMAIL_TEMPLATE'),
						//'default_value' => 'base',
						'id' => 'select-template',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#select-template").select2();});'
					),
					/*'USERS_ADD_TO_PLACE_EMAIL_TEMPLATE' => array(
						'title' => 'Users add in to place email template',
						'hint' => 'email template for users add in to place',
						'type' => 'select',
						'validation' => 'required',
						'options' => App::model('admin/email_template')->toOptionArray(),
						'value' => $config->getConfiguration('USERS_ADD_TO_PLACE_EMAIL_TEMPLATE'),
						//'default_value' => 'base',
						'id' => 'select-template1',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#select-template1").select2();});'
					),
					/*'USERS_ADD_TO_PLACE_STORE_EMAIL_TEMPLATE' => array(
						'title' => 'Users add in to place store email template',
						'hint' => 'email template for users add in to place store',
						'type' => 'select',
						'validation' => 'required',
						'options' => App::model('admin/email_template')->toOptionArray(),
						'value' => $config->getConfiguration('USERS_ADD_TO_PLACE_STORE_EMAIL_TEMPLATE'),
						//'default_value' => 'base',
						'id' => 'select-template2',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#select-template2").select2();});'
					),
					'USERS_ADD_TO_PLACE_EDUCATION_EMAIL_TEMPLATE' => array(
						'title' => 'Users add in to place education email template',
						'hint' => 'email template for users add in to place education',
						'type' => 'select',
						'validation' => 'required',
						'options' => App::model('admin/email_template')->toOptionArray(),
						'value' => $config->getConfiguration('USERS_ADD_TO_PLACE_EDUCATION_EMAIL_TEMPLATE'),
						//'default_value' => 'base',
						'id' => 'select-template3',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#select-template3").select2();});'
					),
					'USERS_ADD_TO_PLACE_HEALTHCARE_EMAIL_TEMPLATE' => array(
						'title' => 'Users add in to place healthcare email template',
						'hint' => 'email template for users add in to place healthcare',
						'type' => 'select',
						'validation' => 'required',
						'options' => App::model('admin/email_template')->toOptionArray(),
						'value' => $config->getConfiguration('USERS_ADD_TO_PLACE_HEALTHCARE_EMAIL_TEMPLATE'),
						//'default_value' => 'base',
						'id' => 'select-template4',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#select-template4").select2();});'
					),
					'USERS_SIGNUP_EMAIL_TEMPLATE' => array(
						'title' => 'Users Signup email template',
						'hint' => 'email template for user signup',
						'type' => 'select',
						'validation' => 'required',
						'options' => App::model('admin/email_template')->toOptionArray(),
						'value' => $config->getConfiguration('USERS_SIGNUP_EMAIL_TEMPLATE'),
						//'default_value' => 'base',
						'id' => 'select-user_template',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#select-user_template").select2();});'
					),
					'USERS_WELCOME_EMAIL_TEMPLATE' => array(
						'title' => 'Users Welcome email template',
						'hint' => 'email template for user welcome',
						'type' => 'select',
						'validation' => 'required',
						'options' => App::model('admin/email_template')->toOptionArray(),
						'value' => $config->getConfiguration('USERS_WELCOME_EMAIL_TEMPLATE'),
						//'default_value' => 'base',
						'id' => 'select-welcome_template',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#select-welcome_template").select2();});'
					), */
					'USERS_RESET_PASSWORD_EMAIL_TEMPLATE' => array(
						'title' => 'Users reset password email template',
						'hint' => 'email template for user reset password',
						'type' => 'select',
						'validation' => 'required',
						'options' => App::model('admin/email_template')->toOptionArray(),
						'value' => $config->getConfiguration('USERS_RESET_PASSWORD_EMAIL_TEMPLATE'),
						//'default_value' => 'base',
						'id' => 'select-reset_password',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#select-reset_password").select2();});'
					),
					'FACEBOOK_USERS_SIGNUP_EMAIL_TEMPLATE' => array(
						'title' => 'Users Signup email template',
						'hint' => 'email template for user signup',
						'type' => 'select',
						'validation' => 'required',
						'options' => App::model('admin/email_template')->toOptionArray(),
						'value' => $config->getConfiguration('FACEBOOK_USERS_SIGNUP_EMAIL_TEMPLATE'),
						//'default_value' => 'base',
						'id' => 'select-facebook_user_template',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#select-facebook_user_template").select2();});'
					),
					/*'USERS_ADD_TO_CONTACTS_EMAIL_TEMPLATE' => array(
						'title' => 'Users contacts email template',
						'hint' => 'email template for user contacts',
						'type' => 'select',
						'validation' => 'required',
						'options' => App::model('admin/email_template')->toOptionArray(),
						'value' => $config->getConfiguration('USERS_ADD_TO_CONTACTS_EMAIL_TEMPLATE'),
						//'default_value' => 'base',
						'id' => 'contact-user_template',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#contact-user_template").select2();});'
					),
					'USERS_ADD_TO_SHORTLISTS_EMAIL_TEMPLATE' => array(
						'title' => 'Users shortlists email template',
						'hint' => 'email template for user shortlists share',
						'type' => 'select',
						'validation' => 'required',
						'options' => App::model('admin/email_template')->toOptionArray(),
						'value' => $config->getConfiguration('USERS_ADD_TO_SHORTLISTS_EMAIL_TEMPLATE'),
						//'default_value' => 'base',
						'id' => 'shortlist-user_template',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#shortlist-user_template").select2();});'
					),*/
					'USERS_ADD_TO_APPOINTMENT_EMAIL_TEMPLATE' => array(
						'title' => 'Users appointment email template',
						'hint' => 'email template for user appointment',
						'type' => 'select',
						'validation' => 'required',
						'options' => App::model('admin/email_template')->toOptionArray(),
						'value' => $config->getConfiguration('USERS_ADD_TO_APPOINTMENT_EMAIL_TEMPLATE'),
						//'default_value' => 'base',
						'id' => 'appointment-user_template',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#appointment-user_template").select2();});'
					),
					'USERS_EMAIL_CONFIRMATION' => array(
						'title' => 'Users confirmation email template',
						'hint' => 'email template for user email confirmation',
						'type' => 'select',
						'validation' => 'required',
						'options' => App::model('admin/email_template')->toOptionArray(),
						'value' => $config->getConfiguration('USERS_EMAIL_CONFIRMATION'),
						//'default_value' => 'base',
						'id' => 'select-confirmation_template',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#select-confirmation_template").select2();});'
					),
				),
			),
		);
		$this->loadBlocks('settings');
		$this->getBlock('users_template_forms')->setFields($this->_fields);
		$this->renderBlocks();
	}
	
	public function action_email()
	{
		$config = App::model('configuration');
		$adminThemes = array_values(array_diff(scandir(DOCROOT.'assets/admin/'), array('..', '.','.svn')));
		$themes = array();
		foreach($adminThemes as $theme) {
			$themes[$theme] = ucfirst($theme);
		}
		$this->_fields = array(
			'email' => array(
				'title' => __('Email'),
				'note' => __('SMTP Settings'),
				'fields' => array(
					'CONTACT_EMAIL' => array(
						'title' => 'Contact Email *',
						'hint' => 'This email will visible as a from in sent email', 
						'type' => 'text',
						'class' => 'form-control input-sm',
						'validation' => array('required','email'),						
						'value' => $config->getConfiguration('CONTACT_EMAIL'), 
					),
					'SUPPORT_EMAIL' => array(
						'title' => 'Support Email *',
						'hint' => 'This email will visible as a from site enquiry', 
						'type' => 'text',
						'class' => 'form-control input-sm',
						'validation' => array('required','email'),
						'value' => $config->getConfiguration('SUPPORT_EMAIL'), 
					),
					'SMTP_ENABLE' => array(
							'title' => 'Enable', 
							'hint' => 'Smtp Enable', 
							'type' => 'select',
							//'validation' => 'required',
							'options' => array('1' => 'Yes','0' => 'No'),
							'value' => $config->getConfiguration('SMTP_ENABLE'),
							'default_value' => '0',
							'id' => 'select_smtpenable',
							'style' => 'width:100%;',
							'scripts' => '$(document).ready(function(){ $("#select_smtpenable").select2();});'
						),
					 'SMTP_HOSTNAME' => array(
						'title' => 'Host Name',
						'hint' => 'smtp hostname',
						'type' => 'text',
						'class' => 'form-control',
						'validation' => 'required',
						'value' => $config->getConfiguration('SMTP_HOSTNAME'),
					),
					'SMTP_USERNAME' => array(
						'title' => 'Username',
						'hint' => 'smtp username',
						'type' => 'text',
						'validation' => array('required','email'),
						'value' => $config->getConfiguration('SMTP_USERNAME'),
					),
					'SMTP_PASSWORD' => array(
						'title' => 'Password',
						'hint' => 'smtp password',
						'type' => 'text',
						'input_type' => 'password',
						'validation' => 'required',
						'value' => $config->getConfiguration('SMTP_PASSWORD'),
					),
					'SMTP_PORT' => array(
						'title' => 'Port',
						'type' => 'text',
						'validation' => array('required','numeric'),
						'class' => 'form-control',
						'value' => $config->getConfiguration('SMTP_PORT'),
					),
					'SMTP_ENCRYPTION' => array(
						'title' => 'SSL Security',
						'hint' => 'Use an encrypt. <a href="'.App::helper('admin')->getUrl('admin/settings/sendsampleemail').'">Send Test Email</a> <a href="'.App::helper('admin')->getUrl('admin/settings/sendsampleiosnotification').'">Send IOS notification</a>',
						'type' => 'select',
						'validation' => 'required',
						'options' => array('tls' => 'TLS','ssl' => 'SSL'),
						'value' => $config->getConfiguration('SMTP_ENCRYPTION'),
						'id' => 'smtp_auth',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#smtp_auth").select2();});'
					),
				),
			),
			/*'templates' => array(
				'title' => __('Email Templates'),
				'fields' => array(
					'INVITATION_FOR_USER_PLACE' => array(
						'title' => 'Invitation for user place', 
						'type' => 'select',
						'validation' => 'required',
						'options' => App::model('admin/email_template')->toOptionArray(),
						'value' => $config->getConfiguration('INVITATION_FOR_USER_PLACE'),
						'id' => 'userinvitation-template',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#userinvitation-template").select2();});'
					),
					'NEW_POINT_ADD_NOTIFICATION' => array(
						'title' => 'New point notification', 
						'type' => 'select',
						'validation' => 'required',
						'options' => App::model('admin/email_template')->toOptionArray(),
						'value' => $config->getConfiguration('NEW_POINT_ADD_NOTIFICATION'),
						'id' => 'newpointnotification-template',
						'style' => 'width:100%;',
						'scripts' => '$(document).ready(function(){ $("#newpointnotification-template").select2();});'
					),
				),
			),*/
		);
		$this->loadBlocks('settings');
		$this->getBlock('email_forms')->setFields($this->_fields);
		$this->renderBlocks();
	}
	
	public function action_product()
	{
		$config = App::model('configuration'); 
		$this->_fields = array(
			'products' => array(
				'title' => __('Products'),
				'note' => __('Product Settings'),
				'fields' => array(
					'SIZE_UNITS' => array(
						'title' => 'Size Units',
						'hint' => 'add units seperated by comma (No spaces between)', 
						'type' => 'text',
						'class' => 'form-control input-sm',
						'validation' => 'required',
						'value' => $config->getConfiguration('SIZE_UNITS'), 
					),
					'BLACKLIST_WORDS' => array(
						'title' => 'Blacklist Words',
						'hint' => 'add words seperated by comma', 
						'type' => 'editor',
						'class' => 'form-control input-sm',
						'validation' => 'required',
						'value' => $config->getConfiguration('BLACKLIST_WORDS'), 
					),
					'SHIPPING_METHODS' => array(
						'title' => 'Shipping Methods',
						'hint' => 'add methods seperated by comma (No spaces between)', 
						'type' => 'text',
						'class' => 'form-control input-sm',
						'validation' => 'required',
						'value' => $config->getConfiguration('SHIPPING_METHODS'), 
					), 
				),
			),
			/*'notification_time_settings' => array(
				'title' => __('Place Rating User Notification Send Time Settings'),
				'note' => __('Time should  mention in hours'),
				'fields' => array(
					'USER_CITY_SAME_PLACE_CITY' => array(
						'title' => 'User current city and place city',
						'hint' => 'User site current city and place city both or same', 
						'type' => 'text',
						'class' => 'form-control input-sm',
						'validation' => array('required','isnumeric'),
						'value' => $config->getConfiguration('USER_CITY_SAME_PLACE_CITY'), 
					),
					'USER_CITY_DIFFERENT_PLACE_CITY' => array(
						'title' => 'User current city and different place city',
						'hint' => 'User site current city and different place city', 
						'type' => 'text',
						'class' => 'form-control input-sm',
						'validation' => array('required','isnumeric'),
						'value' => $config->getConfiguration('USER_CITY_DIFFERENT_PLACE_CITY'), 
					), 
				),
			),*/
			'default_user_rating_count_settings' => array(
				'title' => __('Place user rating show count '),
				'fields' => array(
						'USER_PLACE_DEFAULT_RATING_COUNT' => array(
						'title' => 'minimum user rating count',
						'hint' => 'user rating show  in place default count', 
						'type' => 'text',
						'class' => 'form-control input-sm',
						'validation' => array('required','isnumeric'),
						'value' => $config->getConfiguration('USER_PLACE_DEFAULT_RATING_COUNT'), 
					),
				),
			),
			'default_user_rating_question' => array(
				'title' => __('Rating default questions'),
				'fields' => array(
					'PLACE_DEFAULT_QUESTIONID' => array(
								'title' => 'Place user rating default question', 
								'hint' => 'This is the default question for all places when no questions added', 
								'type' => 'select',
								'validation' => 'required',
								'options' => App::model('question/ratings')->toOptionArray(),
								'value' => $config->getConfiguration('PLACE_DEFAULT_QUESTIONID'),
								'id' => 'placedefault',
								'style' => 'width:100%;',
								'scripts' => '$(document).ready(function(){ $("#placedefault").select2();});'
					),
					'PRODUCT_DEFAULT_QUESTIONID' => array(
								'title' => 'Product user rating default question', 
								'hint' => 'This is the default question for all products when no questions added', 
								'type' => 'select',
								'validation' => 'required',
								'options' => App::model('question/ratings')->toOptionArray(),
								'value' => $config->getConfiguration('PRODUCT_DEFAULT_QUESTIONID'),
								'id' => 'productdefault',
								'style' => 'width:100%;',
								'scripts' => '$(document).ready(function(){ $("#productdefault").select2();});'
					),
					'SERVICE_DEFAULT_QUESTIONID' => array(
								'title' => 'Service user rating default question', 
								'hint' => 'This is the default question for all places when no questions added', 
								'type' => 'select',
								'validation' => 'required',
								'options' => App::model('question/ratings')->toOptionArray(),
								'value' => $config->getConfiguration('SERVICE_DEFAULT_QUESTIONID'),
								'id' => 'servicedefault',
								'style' => 'width:100%;',
								'scripts' => '$(document).ready(function(){ $("#servicedefault").select2();});'
					),
					'PEOPLE_DEFAULT_QUESTIONID' => array(
								'title' => 'People user rating default question', 
								'hint' => 'This is the default question for all Peoples when no questions added', 
								'type' => 'select',
								'validation' => 'required',
								'options' => App::model('question/ratings')->toOptionArray(),
								'value' => $config->getConfiguration('PEOPLE_DEFAULT_QUESTIONID'),
								'id' => 'peopledefault',
								'style' => 'width:100%;',
								'scripts' => '$(document).ready(function(){ $("#peopledefault").select2();});'
					),
				),
			),
		);
		$this->loadBlocks('settings');
		$this->getBlock('product_forms')->setFields($this->_fields);
		$this->renderBlocks();
	}
	
	public function action_social_media()
	{ 
		$config = App::model('configuration');
		$adminThemes = array_values(array_diff(scandir(DOCROOT.'assets/admin/'), array('..', '.','.svn')));
		$themes = array();
		foreach($adminThemes as $theme) {
			$themes[$theme] = ucfirst($theme);
		}
		$this->_fields = array(
			'social_media' => array(
				'title' => __('Social Media'),
				'note' => __('Social Media Settings'),
				'fields' => array(
					'FACEBOOK_APP_ID' => array(
						'title' => 'Facebook App Id *',
						'hint' => 'This app id used for facebook login', 
						'type' => 'text',
						'class' => 'form-control input-sm',
						'validation' => 'required',
						'value' => $config->getConfiguration('FACEBOOK_APP_ID'), 
					),
					'FACEBOOK_SECRET_KEY' => array(
						'title' => 'Facebook Secret Key *',
						'hint' => 'This key used for facebook login', 
						'type' => 'text',
						'class' => 'form-control input-sm',
						'validation' => 'required',
						'value' => $config->getConfiguration('FACEBOOK_SECRET_KEY'), 
					),
					'GOOGLE_PLUS_APP_ID' => array(
						'title' => 'Google Plus App Id',
						'hint' => 'This app id used for google plus login',
						'type' => 'text',
						'class' => 'form-control',
						'validation' => 'required',
						'value' => $config->getConfiguration('GOOGLE_PLUS_APP_ID'),
					),
					'GOOGLE_PLUS_API_KEY' => array(
						'title' => 'Google Plus Api Key',
						'hint' => 'This api key used for google plus login',
						'type' => 'text',
						'class' => 'form-control',
						'validation' => 'required',
						'value' => $config->getConfiguration('GOOGLE_PLUS_API_KEY'),
					),
					'GOOGLE_PLUS_SECRET_KEY' => array(
						'title' => 'Google Plus Secret Key',
						'hint' => 'This app id used for google plus login',
						'type' => 'text',
						'validation' => 'required',
						'value' => $config->getConfiguration('GOOGLE_PLUS_SECRET_KEY'),
					),					
				),
			),
		);
		$this->loadBlocks('settings');
		$this->getBlock('social_media_forms')->setFields($this->_fields);
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
					$model->setUserId(App::model('admin/session')->getCustomer()->getUserId());
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
	
	public function action_currency_settings()
	{
		$this->loadBlocks('currency_settings');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Currency Settings'));
		$contentblock->setPageTitle('<i class="fa fa-money" ></i>&nbsp;'.__('Currency Settings'));
		$this->renderBlocks();
		
	}
	
	
	
	/** Add and Edit Currency **/ 
	public function action_edit_currency()
	{
		$currencymodel = App::model('admin/currency_settings')->load($this->getRequest()->query('id'));
		$this->loadBlocks('currency_settings');
		$contentblock = $this->getBlock('content');
		$breadcrumb = $this->getBlock('breadcrumbs');
		if($this->getRequest()->query('id')) {
			$this->getBlock('head')->setTitle(__('Edit :currency',array(':currency' => $currencymodel->getCurrencyName())));
			$contentblock->setPageTitle('<i class="fa fa-money" ></i>&nbsp;'.__('Edit - <span class="semi-bold">:currency</span>',array(':currency' =>$currencymodel->getCurrencyName())));
			$breadcrumb->addCrumb('editCurrency',array('label' => __('Edit - :currency',array(':currency' => $currencymodel->getCurrencyName())),
												'title' => __('Edit - :currency',array(':currency' => $currencymodel->getCurrencyName()))
							)); 
		} else {
			
			$this->getBlock('head')->setTitle(__('Add currency- Settings'));
			$contentblock->setPageTitle('<i class="fa fa-money" ></i>&nbsp;'.__('Add Currency'));
			$breadcrumb->addCrumb('editCurrency',array('label' => __('Add Currency'),
												'title' => __('Add Currency')
							)); 
		} 
		$this->renderBlocks();
	}
	
	/** Add and Edit Subject **/ 
	public function action_savecurrency()
	{
		$request = $this->getRequest();
		$data = $request->post();
		$query = $this->getRequest()->query();
		$backto = isset($data['backto']);
		$success = false;
        $errors = array();
			try { 
					$currencymodel = App::model('admin/currency_settings');
					$validate = $currencymodel->validate($data);
					if($request->post('currency_setting_id')) {
						$currencymodel->setCurrencySettingId($request->post('currency_setting_id'));
						$currencymodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
					} else { 
						$currencymodel->setCreatedDate(date("Y-m-d H:i:s",time()));
					} 
					$currencymodel->setCountryId($request->post('country_id'));
					$currencymodel->setCurrencyName($request->post('currency_name'));
					$currencymodel->setNumericIsoCode($request->post('numeric_iso_code'));
					$currencymodel->setCurrencySymbolRight($request->post('currency_symbol_right'));
					$currencymodel->setCurrencySymbolLeft($request->post('currency_symbol_left'));
					$currencymodel->setCurrencyCode($request->post('currency_code'));
					$currencymodel->setCurrencyRate($request->post('exchange_rate'));
					$currencymodel->save();
					$currencymodel->loadAllCurrency(true);
					$success = true;
			}catch(Validation_Exception $ve) {
				
					Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('emailtemplate',true));
					$errors = $ve->array->errors('emailtemplate',true);
					if($request->post('currency_setting_id')) {
						$query['currency_setting_id'] = $request->post('currency_setting_id');
					}
					$this->_redirect('admin/settings/edit_currency',$query);
					return;
			}catch(Kohana_Exception $ke) {
			//Log::Instance()->add(Log::ERROR, $ke);

			} catch(Exception $e) {
				Log::Instance()->add(Log::ERROR, $e);
			}
			if($success) {
					if($request->post('subject_id')) {
						Notice::add(Notice::SUCCESS, __('Currency  has been  updated'));
					}else{
						Notice::add(Notice::SUCCESS, __('Currency has been  added'));
					}
			}
			if($currencymodel->getCurrencySettingId()) {
				$query['id'] = $currencymodel->getCurrencySettingId();
			}
			if($backto){ 
				$this->_redirect('admin/settings/edit_currency',$query);
			}else{
				$this->_redirect('admin/settings/currency_settings',$query);
			}	
		
	}
	
	public function action_delete_currency()
	{
		$currency_id=$this->getRequest()->query('id');
		$currency = App::model('admin/currency_settings')->deleterow($currency_id,'currency_setting_id');
		Notice::add(Notice::SUCCESS, __('Currency has been deleted successfully'));
		$this->_redirect('admin/settings/currency_settings');
	}
	
	/** Language Menu **/
	public function action_language_settings()
	{
		$this->loadBlocks('language_settings');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Language Settings'));
		$contentblock->setPageTitle(__('Language Settings'));
		$this->renderBlocks();
	}

	public function action_edit_language(){
		$languagemodel = App::model('admin/language_settings')->load($this->getRequest()->query('id'));
		$this->loadBlocks('language_settings');
		if($this->getRequest()->query('id')!='' && $languagemodel->getLanguageId()!= $this->getRequest()->query('id')) {
			Notice::add(Notice::ERROR, __('Invalid Language'));
			$this->_redirect('admin/settings/language_settings');
		}
		$contentblock = $this->getBlock('content');
		$breadcrumb = $this->getBlock('breadcrumbs');
		if($this->getRequest()->query('id')) {
			$this->getBlock('head')->setTitle(__('Edit :language',array(':language' => $languagemodel->getName())));
			$contentblock->setPageTitle(__('Edit - <span class="semi-bold">:language</span>',array(':language' =>$languagemodel->getName())));
			$breadcrumb->addCrumb('editLanguage',array('label' => __('Edit - :language',array(':language' => $languagemodel->getName())),
												'title' => __('Edit - :language',array(':language' => $languagemodel->getName()))
							)); 
		} else {
			
			$this->getBlock('head')->setTitle(__('Add language - Settings'));
			$contentblock->setPageTitle(__('Add Language'));
			$breadcrumb->addCrumb('editLanguage',array('label' => __('Add Language'),
												'title' => __('Add Language')
							)); 
		} 
		$this->renderBlocks();
	}
	
	public function action_savelanguage()
	{
		$request = $this->getRequest();
		$data = $request->post();
		$query = $this->getRequest()->query();
		$backto = isset($data['backto']);
		$success = false;
        $errors = array();
			try { 
					$languagemodel = App::model('admin/language_settings');
					$validate = $languagemodel->validate($data);
					if($request->post('language_id')) {
						$languagemodel->setLanguageId($request->post('language_id'));
						$languagemodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
					} else { 
						$languagemodel->setCreatedDate(date("Y-m-d H:i:s",time()));
					} 
					$languagemodel->setName($request->post('language_name'));
					$languagemodel->setLanguageCode($request->post('language_code'));
					$languagemodel->setDateFormatShort($request->post('short_date_format'));
					$languagemodel->setDateFormatFull($request->post('full_date_format'));
					$rtl = $request->post('rtl') ? 1 : 0;
					$status = $request->post('status') ? 1 : 0;
					$languagemodel->setStatus($status);
					$languagemodel->setIsRtl($rtl);
					$languagemodel->save(); 
					$success = true;
			} catch(Validation_Exception $ve) {
				
					Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('emailtemplate',true));
					$errors = $ve->array->errors('emailtemplate',true);
					if($request->post('language_id')) {
						$query['language_id'] = $request->post('language_id');
					}
					$this->_redirect('admin/settings/edit_language',$query);
					return;
			}catch(Kohana_Exception $ke) {
			//Log::Instance()->add(Log::ERROR, $ke);

			} catch(Exception $e) {
				Log::Instance()->add(Log::ERROR, $e);
			}
			if($success) {
					if($request->post('language_id')) {
						Notice::add(Notice::SUCCESS, __('Language  has been  updated'));
					}else{
						Notice::add(Notice::SUCCESS, __('Language has been  added'));
					}
			}
			if($languagemodel->getLanguageId()) {
				$query['id'] = $languagemodel->getLanguageId();
			}
			if($backto){ 
				$this->_redirect('admin/settings/edit_language',$query);
			}else{
				$this->_redirect('admin/settings/language_settings',$query);
			}	
		
	}
	
	public function action_exchangeratetable()
	{ 
		$this->auto_render = false;
		$this->loadBlocks('settings'); 
		$content = $this->getBlock('exchangetable')->toHtml();
		$this->getResponse()->body($content);
	}
	
	public function action_users_settings()
	{
		$config = App::model('configuration');
		$adminThemes = array_values(array_diff(scandir(DOCROOT.'assets/admin/'), array('..', '.','.svn')));
		$themes = array();
		foreach($adminThemes as $theme) {
			$themes[$theme] = ucfirst($theme);
		}
		$this->_fields = array(
			'users_settings' => array(
				'title' => __('User Settings'),
				'note' => __('User Settings'),
				'fields' => array(
					'USER_SETTINGS' => array(
							'title' => 'Enable', 
							'hint' => 'Login after email confirmation', 
							'type' => 'select',
							//'validation' => 'required',
							'options' => array('1' => 'Yes','0' => 'No'),
							'value' => $config->getConfiguration('USER_SETTINGS'),
							'default_value' => '0',
							'id' => 'select_usersettings',
							'style' => 'width:100%;',
							'scripts' => '$(document).ready(function(){ $("#select_usersettings").select2();});'
						),
						'PROFILE_SETTINGS' => array(
							'title' => 'Profile Settings',
							'hint' => 'User Profile Settings', 
							'type' => 'text',
							'style' => 'width:100%;',
							'options' => $this->_getLocaleArray(),
							'value' => $config->getConfiguration('PROFILE_SETTINGS'),
							'renderer'=>'Admin/Settings/Profilesettings',
						),
				),
			),

		);
		$this->loadBlocks('settings');
		$this->getBlock('users_settings')->setFields($this->_fields);
		$this->renderBlocks();
	}
	
	// Banner Module
	public function action_banner_settings()
	{
		$this->loadBlocks('banner_settings');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Banner Settings'));
		$contentblock->setPageTitle('<i class="fa  fa-bookmark" ></i>&nbsp;'.__('Banner Settings'));
		$this->renderBlocks();
		
	}
	
	public function action_edit_banner()
	{
		$bannermodel = App::model('admin/banner_settings')->load($this->getRequest()->query('id'));
		$this->loadBlocks('banner_settings');
		$contentblock = $this->getBlock('content');
		$breadcrumb = $this->getBlock('breadcrumbs');
		if($this->getRequest()->query('id')) {
			$this->getBlock('head')->setTitle(__('Edit :banner',array(':banner' => $bannermodel->getBannerTitle())));
			$contentblock->setPageTitle('<i class="fa fa-bookmark" ></i>&nbsp;'.__('Edit - <span class="semi-bold">:banner</span>',array(':banner' =>$bannermodel->getBannerTitle())));
			$breadcrumb->addCrumb('editBanner',array('label' => __('Edit - :banner',array(':banner' => $bannermodel->getBannerTitle())),
												'title' => __('Edit - :banner',array(':banner' => $bannermodel->getBannerTitle()))
							)); 
		} else {
			
			$this->getBlock('head')->setTitle(__('Add Banner - Settings'));
			$contentblock->setPageTitle('<i class="fa fa-bookmark" ></i>&nbsp;'.__('Add Banner'));
			$breadcrumb->addCrumb('editBanner',array('label' => __('Add Banner'),
												'title' => __('Add Banner')
							)); 
		} 
		$this->renderBlocks();
	}
	
	public function action_savebanner()
	{
		$request = $this->getRequest();
		$data = $request->post();
				
		$data = Arr::merge($data,$_FILES);
		$image = $data['banner_image']['name'];
					
		$query = $this->getRequest()->query();
		$backto = isset($data['backto']);
		$success = false;
        $errors = array();
		try { 
			$bannermodel = App::model('admin/banner_settings');
			$validate = $bannermodel->validate($data);
			//print_r($bannermodel);exit;
			if($request->post('banner_setting_id')) {
				$bannermodel->setBannerSettingId((int)$request->post('banner_setting_id'));
				$bannermodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
			} else { 
				$bannermodel->setCreatedDate(date("Y-m-d H:i:s",time()));
				$bannermodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
			}  
			if($_FILES['banner_image']['name']) {
				$name=App::imagenamereplace($image);
				$bannermodel->setBannerImage('uploads/banner/'.$name);
			}
			$bannermodel->setBannerLink($request->post('banner_link'));
			$status = $request->post('status') ? TRUE : FALSE;					
			$bannermodel->setStatus($status);
			
			$bannermodel->save();
			$language = App::model('core/language',false)->getLanguages();
			 
			$infomodel = App::model('core/banner_info',false);
			$infomodel->deleterow($bannermodel->getId(),'banner_setting_id');
			foreach($language as $lang) { 
				$bannertitle = Arr::get($data,'banner_title');
				$bannersubtitle = Arr::get($data,'banner_subtitle');
				
				$infomodel->setBannerSettingId($bannermodel->getId())->setBannerTitle(Arr::get($bannertitle,Arr::get($lang,'language_id')))
						->setBannerSubtitle(Arr::get($bannersubtitle,Arr::get($lang,'language_id')))
						->setLanguageId(Arr::get($lang,'language_id'));
				if(Arr::get($bannertitle,Arr::get($lang,'language_id')) || Arr::get($bannersubtitle,Arr::get($lang,'language_id'))) {
					$infomodel->save();
				}
				$infomodel->unsetData();
			}
			$success = true;
		}catch(Validation_Exception $ve) {					
				Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validate/banner',true));
				$errors = $ve->array->errors('validate/banner',true);
				if($request->post('banner_setting_id')) {
					$query['banner_setting_id'] = $request->post('banner_setting_id');
				}
				$this->_redirect('admin/settings/edit_banner',$query);
				return;
		}catch(Kohana_Exception $ke) { 
		 Log::Instance()->add(Log::ERROR, $ke);

		} catch(Exception $e) {
			Log::Instance()->add(Log::ERROR, $e);
		}
		if($success) {
			if($request->post('banner_setting_id')) {
				Notice::add(Notice::SUCCESS, __('Banner has been updated'));
			}else{
				Notice::add(Notice::SUCCESS, __('Banner has been added'));
			}
		}
		if($bannermodel->getBannerSettingId()) {
				$query['id'] = $bannermodel->getBannerSettingId();
		}
		if($backto){ 
			$this->_redirect('admin/settings/edit_banner',$query);
		}
		$this->_redirect('admin/settings/banner_settings',$query);					
	}
	
	public function action_delete_banner()
	{
		$banner_id=$this->getRequest()->query('id');
		$banner = App::model('admin/banner_settings')->deleterow($banner_id,'banner_setting_id');
		Notice::add(Notice::SUCCESS, __('Banner has been deleted successfully'));
		$this->_redirect('admin/settings/banner_settings');
	}
	
	public function action_email_subject() {
		$this->loadBlocks('email_subject');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Notification Subject'));
		$contentblock->setPageTitle('<i class="fa  fa-envelope" ></i>&nbsp;'.__('Notification Subject'));
		$this->renderBlocks();	
	}
	
	public function action_edit_email_subject()
	{
		$subjectmodel = App::model('admin/email_subject/info')->load($this->getRequest()->query('id'),'id');
		$this->loadBlocks('email_subject');
		$contentblock = $this->getBlock('content');
		$breadcrumb = $this->getBlock('breadcrumbs');
		if($this->getRequest()->query('id')) {
			$this->getBlock('head')->setTitle(__('Edit :subject',array(':subject' => $subjectmodel->getSubject())));
			$contentblock->setPageTitle('<i class="fa fa-envelope" ></i>&nbsp;'.__('Edit - <span class="semi-bold">:subject</span>',array(':subject' =>$subjectmodel->getSubject())));
			$breadcrumb->addCrumb('editSubject',array('label' => __('Edit - :subject',array(':subject' => $subjectmodel->getSubject())),
												'title' => __('Edit - :subject',array(':subject' => $subjectmodel->getSubject()))
							)); 
		} else {
			
			$this->getBlock('head')->setTitle(__('Add Notification Subject - Settings'));
			$contentblock->setPageTitle('<i class="fa fa-envelope" ></i>&nbsp;'.__('Add Notification Subject'));
			$breadcrumb->addCrumb('editSubject',array('label' => __('Add Notification Subject'),
												'title' => __('Add Notification Subject')
							)); 
		} 
		$this->renderBlocks();
	}
	
	public function action_savesubject()
	{
		$request = $this->getRequest();
		$data = $request->post();		
		$subject_type = explode('|',$data['subject_type']);
		
		$query = $this->getRequest()->query();
		$backto = isset($data['backto']);
		$success = false;
        $errors = array();
		try { 
			$subjectmodel = App::model('admin/email_subject');
			$validate = $subjectmodel->validate($data);
			
			if($request->post('id')) {
				$subjectmodel->setId((int)$request->post('id'));				
			} 			
			$subjectmodel->setSubjectType($subject_type[0]);
			$subjectmodel->setSubjectIndex($subject_type[1]);			
			$subjectmodel->setTemplateID($request->post('template_id'));
			$subjectmodel->setColorCode($request->post('color_code'));
			$status = $request->post('status') ? TRUE : FALSE;					
			$subjectmodel->setStatus($status);		
			$subjectmodel->save(); 	
			//$subjectmodel->saveSubject(); 
			$success = true;
		}catch(Validation_Exception $ve) {								
				Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validation',true));
				$errors = $ve->array->errors('validation',true);
				if($request->post('id')) {
					$query['id'] = $request->post('id');
				}
				$this->_redirect('admin/settings/edit_email_subject',$query);
				return;
		}catch(Kohana_Exception $ke) {
		//Log::Instance()->add(Log::ERROR, $ke);

		} catch(Exception $e) {
			Log::Instance()->add(Log::ERROR, $e);
		}
		if($success) {
			if($request->post('id')) {
				Notice::add(Notice::SUCCESS, __('Notification Subject has been updated'));
			}else{
				Notice::add(Notice::SUCCESS, __('Notification Subject has been added'));
			}
		}
		if($subjectmodel->getId()) {
				$query['id'] = $subjectmodel->getId();
		}
		if($backto){ 
			$this->_redirect('admin/settings/edit_email_subject',$query);
		}
		$this->_redirect('admin/settings/email_subject',$query);					
	}
	
	public function action_delete_subject()
	{
		$subject_id=$this->getRequest()->query('id');
		$subject = App::model('admin/email_subject')->deleterow($subject_id,'id');
		Notice::add(Notice::SUCCESS, __('Subject has been deleted successfully'));
		$this->_redirect('admin/settings/email_subject');
	}
	
	public function action_emailajaxlist()
	{
		$this->loadBlocks('email_subject');
		$output=$this->getBlock('listing')->toHtml();
		$this->getResponse()->body($output);
	}
	
	public function action_cache()
	{
		$this->loadBlocks('settings');
		$this->renderBlocks();
	}
	
	/*********** COUNTRY SETTINGS   ************/
	public function action_countrysettings()
	{
		$this->loadBlocks('country_settings');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Country Settings'));
		$contentblock->setPageTitle('<i class="fa fa-money" ></i>&nbsp;'.__('Country Settings'));
		$this->renderBlocks();
		
	}
	/** Add and Edit Currency **/ 
	public function action_editcountry()
	{
		$countrymodel = App::model('admin/country_settings')->load($this->getRequest()->query('id'));
		$this->loadBlocks('country_settings');
		$contentblock = $this->getBlock('content');
		$breadcrumb = $this->getBlock('breadcrumbs');
		if($this->getRequest()->query('id')) {
			$this->getBlock('head')->setTitle(__('Edit :country',array(':country' => $countrymodel->getCountryName())));
			$contentblock->setPageTitle('<i class="fa fa-money" ></i>&nbsp;'.__('Edit - <span class="semi-bold">:country</span>',array(':country' =>$countrymodel->getCountryName())));
			$breadcrumb->addCrumb('editCountry',array('label' => __('Edit - :country',array(':country' => $countrymodel->getCountryName())),
												'title' => __('Edit - :country',array(':country' => $countrymodel->getCountryName()))
							)); 
		} else {
			
			$this->getBlock('head')->setTitle(__('Add Country- Settings'));
			$contentblock->setPageTitle('<i class="fa fa-money" ></i>&nbsp;'.__('Add Country'));
			$breadcrumb->addCrumb('editCountry',array('label' => __('Add Country'),
												'title' => __('Add Country')
							)); 
		} 
		$this->renderBlocks();
	}
	/** Save country **/ 
	public function action_savecountry()
	{
		$request = $this->getRequest();
		$data = $request->post();
		$query = $this->getRequest()->query();
		$backto = isset($data['backto']);
		$success = false;
        $errors = array();
			try {
					$countrymodel = App::model('admin/country_settings');
					$validate = $countrymodel->validate($data);
					$countrymodel->addData($data);
					if($this->getRequest()->query('id')) {
						$countrymodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
					} else { 
						$countrymodel->setCreatedDate(date("Y-m-d H:i:s",time()));
						$countrymodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
					} 
					$countryname = $request->post('country_name');
					$countrymodel->setCountryId($request->post('country_id'));
					//$countrymodel->setCountryName($request->post('country_name'));
					$countrymodel->setUrl(Url::title($countryname[1]));
					$countrymodel->setCountryCode($request->post('country_code'));
					$countrymodel->setCountryStatus($request->post('country_status'));
					$countrymodel->saveCountry();
					$success = true;
			}catch(Validation_Exception $ve) {
				
					Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('emailtemplate',true));
					$errors = $ve->array->errors('emailtemplate',true);
					if($request->post('country_id')) {
						$query['currency_setting_id'] = $request->post('country_id');
					}
					$this->_redirect('admin/settings/editcountry',$query);
					return;
			}catch(Kohana_Exception $ke) {
				print_r($ke);exit;
			//Log::Instance()->add(Log::ERROR, $ke);

			} catch(Exception $e) {
				print_r($e);exit;
				Log::Instance()->add(Log::ERROR, $e);
			}
			if($success) {
					if($request->post('country_id')) {
						Notice::add(Notice::SUCCESS, __('Country has been updated'));
					}else{
						Notice::add(Notice::SUCCESS, __('Country has been added'));
					}
			}
			if($countrymodel->getCountryId()) {
				$query['id'] = $countrymodel->getCountryId();
			}
			if($backto){ 
				$this->_redirect('admin/settings/editcountry',$query);
			}else{
				$this->_redirect('admin/settings/countrysettings',$query);
			}	
		
	}
	/** Delete Country **/ 
	public function action_deletecountry()
	{
		$country_id=$this->getRequest()->query('id');
		$country = App::model('admin/country_settings')->deleterow($country_id,'country_id');
		Notice::add(Notice::SUCCESS, __('Country has been deleted successfully'));
		$this->_redirect('admin/settings/countrysettings');
	}
	/** Ajax scroll load Country list**/ 
	public function action_ajaxcountry()
	{
		$this->loadBlocks('country_settings');
		$output = $this->getBlock('countrylist')->toHtml();
		$this->getResponse()->body($output); 
	}
	
	
	/********** CITY SETTINGS   *********/
	public function action_citysettings()
	{
		$this->loadBlocks('city_settings');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('City Settings'));
		$contentblock->setPageTitle('<i class="fa fa-money" ></i>&nbsp;'.__('City Settings'));
		$this->renderBlocks();
		
	}
	/** Add and Edit City **/ 
	public function action_editcity()
	{
		$citymodel = App::model('admin/city_settings')->load($this->getRequest()->query('id'));
		$this->loadBlocks('city_settings');
		$contentblock = $this->getBlock('content');
		$breadcrumb = $this->getBlock('breadcrumbs');
		if($this->getRequest()->query('id')) {
			$this->getBlock('head')->setTitle(__('Edit :city',array(':city' => $citymodel->getCityName())));
			$contentblock->setPageTitle('<i class="fa fa-money" ></i>&nbsp;'.__('Edit - <span class="semi-bold">:city</span>',array(':city' =>$citymodel->getCityName())));
			$breadcrumb->addCrumb('editCity',array('label' => __('Edit - :city',array(':city' => $citymodel->getCityName())),
												'title' => __('Edit - :city',array(':city' => $citymodel->getCityName()))
							)); 
		} else {
			
			$this->getBlock('head')->setTitle(__('Add City- Settings'));
			$contentblock->setPageTitle('<i class="fa fa-money" ></i>&nbsp;'.__('Add City'));
			$breadcrumb->addCrumb('editCity',array('label' => __('Add City'),
												'title' => __('Add City')
							)); 
		} 
		$this->renderBlocks();
	}
	/** Save City **/ 
	public function action_savecity()
	{
		$request = $this->getRequest();
		$data = $request->post();
		$query = $this->getRequest()->query();
		$backto = isset($data['backto']);
		$success = false;
        $errors = array();
			try { 
					$citymodel = App::model('admin/city_settings');
					$validate = $citymodel->validate($data);
					$citymodel->addData($data);
					$cityname = $request->post('city_name');
					if($this->getRequest()->query('id')) {
						$citymodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
					} else { 
						$citymodel->setCreatedDate(date("Y-m-d H:i:s",time()));
						$citymodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
					} 
					$citymodel->setCityId($request->post('city_id'));
					//$citymodel->setCityName($request->post('city_name'));
					$citymodel->setUrl(Url::title(Arr::get($cityname,1)));
					$citymodel->setCountryId($request->post('country_id'));
					$citymodel->setCityStatus($request->post('city_status'));
					$citymodel->saveCity();
					$success = true;
			}catch(Validation_Exception $ve) {
				
					Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('emailtemplate',true));
					$errors = $ve->array->errors('emailtemplate',true);
					if($request->post('city_id')) {
						$query['city_id'] = $request->post('city_id');
					}
					$this->_redirect('admin/settings/editcity',$query);
					return;
			}catch(Kohana_Exception $ke) {
				print_r($ke);exit;
			//Log::Instance()->add(Log::ERROR, $ke);

			} catch(Exception $e) {
				Log::Instance()->add(Log::ERROR, $e);
			}
			if($success) {
					if($request->post('city_id')) {
						Notice::add(Notice::SUCCESS, __('City has been updated'));
					}else{
						Notice::add(Notice::SUCCESS, __('City has been added'));
					}
			}
			if($citymodel->getCityId()) {
				$query['id'] = $citymodel->getCityId();
			}
			if($backto){ 
				$this->_redirect('admin/settings/editcity',$query);
			}else{
				$this->_redirect('admin/settings/citysettings',$query);
			}	
		
	}
	/** Delete City **/ 
	public function action_deletecity()
	{
		$city_id=$this->getRequest()->query('id');
		$city = App::model('admin/city_settings')->deleterow($city_id,'city_id');
		Notice::add(Notice::SUCCESS, __('City has been deleted successfully'));
		$this->_redirect('admin/settings/citysettings');
	}
	/** Ajax scroll load City list**/ 
	public function action_ajaxcity()
	{
		$this->loadBlocks('city_settings');
		$output = $this->getBlock('citylist')->toHtml();
		$this->getResponse()->body($output); 
	}
	
	/********** AREA SETTINGS   *********/
	public function action_areasettings()
	{
		$this->loadBlocks('area_settings');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Area Settings'));
		$contentblock->setPageTitle('<i class="fa fa-money" ></i>&nbsp;'.__('Area Settings'));
		$this->renderBlocks();
		
	}
	/** Add and Edit Area **/ 
	public function action_editarea()
	{
		$areamodel = App::model('admin/area_settings')->load($this->getRequest()->query('id'));
		$this->loadBlocks('area_settings');
		$contentblock = $this->getBlock('content');
		$breadcrumb = $this->getBlock('breadcrumbs');
		if($this->getRequest()->query('id')) {
			$this->getBlock('head')->setTitle(__('Edit :area',array(':area' => $areamodel->getAreaName())));
			$contentblock->setPageTitle('<i class="fa fa-money" ></i>&nbsp;'.__('Edit - <span class="semi-bold">:area</span>',array(':area' =>$areamodel->getAreaName())));
			$breadcrumb->addCrumb('editArea',array('label' => __('Edit - :area',array(':area' => $areamodel->getAreaName())),
												'title' => __('Edit - :area',array(':area' => $areamodel->getAreaName()))
							)); 
		} else {
			
			$this->getBlock('head')->setTitle(__('Add Area- Settings'));
			$contentblock->setPageTitle('<i class="fa fa-money" ></i>&nbsp;'.__('Add Area'));
			$breadcrumb->addCrumb('editArea',array('label' => __('Add Area'),
												'title' => __('Add Area')
							)); 
		} 
		$this->renderBlocks();
	}
	/** Save Area **/ 
	public function action_savearea()
	{
		$request = $this->getRequest();
		$data = $request->post();
		$query = $this->getRequest()->query();
		$backto = isset($data['backto']);
		$success = false;
		
        $errors = array();
			try { 
					$areamodel = App::model('admin/area_settings');
					$validate = $areamodel->validate($data);
					$areamodel->addData($data);
					$areaname = $request->post('area_name');
					if($this->getRequest()->query('id')) {
						$areamodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
					} else { 
						$areamodel->setCreatedDate(date("Y-m-d H:i:s",time()));
						$areamodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
					} 
					$areamodel->setAreaId($request->post('area_id'));
					//$areamodel->setAreaName($request->post('area_name'));
					$areamodel->setUrl(Url::title(Arr::get($areaname,1)));
					$areamodel->setCountryId($request->post('country_id'));
					$areamodel->setCityId($request->post('city_id'));
					$areamodel->setAreaStatus($request->post('area_status'));
					$areamodel->saveArea();
					
					$success = true;
			}catch(Validation_Exception $ve){
					Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('emailtemplate',true));
					$errors = $ve->array->errors('emailtemplate',true);
					if($request->post('area_id')) {
						$query['area_id'] = $request->post('area_id');
					}
					$this->_redirect('admin/settings/editarea',$query);
					return;
			}catch(Kohana_Exception $ke) {
			//Log::Instance()->add(Log::ERROR, $ke);

			} catch(Exception $e) {
				Log::Instance()->add(Log::ERROR, $e);
			}
			if($success) {
					if($request->post('area_id')) {
						Notice::add(Notice::SUCCESS, __('Area has been updated'));
					}else{
						Notice::add(Notice::SUCCESS, __('Area has been added'));
					}
			}
			if($areamodel->getAreaId()) {
				$query['id'] = $areamodel->getAreaId();
			}
			if($backto){ 
				$this->_redirect('admin/settings/editarea',$query);
			}else{
				$this->_redirect('admin/settings/areasettings',$query);
			}	
		
	}
	/** Delete Area **/ 
	public function action_deletearea()
	{
		$area_id=$this->getRequest()->query('id');
		$area = App::model('admin/area_settings')->deleterow($area_id,'area_id');
		Notice::add(Notice::SUCCESS, __('Area has been deleted successfully'));
		$this->_redirect('admin/settings/areasettings');
	}
	/** Ajax scroll load Area list**/ 
	public function action_ajaxarea()
	{
		$this->loadBlocks('area_settings');
		$output = $this->getBlock('arealist')->toHtml();
		$this->getResponse()->body($output); 
	}
	
	/* Country based city Change */
	public function action_getcity()
	{
		$this->auto_render = false;
		$this->loadBlocks('area_settings');
		$country = $this->getRequest()->query('country_id');
		$city = $this->getRequest()->query('city_id');
		$area = $this->getRequest()->query('area_id');
		$output = $this->getBlock('city')->setCountryId($country)->setCityId($city)->setAreaId($area)->toHtml();
		$this->getResponse()->body($output); 
	}
	
	/* city based area Change */
	public function action_getarea()
	{
		$this->auto_render = false;
		$this->loadBlocks('area_settings');
		$city = $this->getRequest()->query('city_id');
		$area = $this->getRequest()->query('area_id');
		$output = $this->getBlock('area')->setCityId($city)->setAreaId($area)->toHtml();
		$this->getResponse()->body($output); 
	}
	
	public function action_massdeletecountry()
	{
		$request = $this->getRequest();
		$data = $request->post();
		$query = $this->getRequest()->query();
		$countrymodel = App::model('core/country');
		$count_arr = explode(',',$data['country_id']);
		$result = $countrymodel->massDeleteCountry($count_arr);
		if($result > 1):
			Notice::add(Notice::SUCCESS, __(':count countries has been deleted successfully',array(':count' => $result)));
			$this->_redirect('admin/settings/countrysettings');
		endif;
		Notice::add(Notice::SUCCESS, __('Country has been deleted successfully'));
		$this->_redirect('admin/settings/countrysettings');
	}
	
	public function action_massdeletecity()
	{
		$request = $this->getRequest();
		$data = $request->post();
		$query = $this->getRequest()->query();
		$citymodel = App::model('core/city');
		$count_arr = explode(',',$data['city_id']);
		$result = $citymodel->massDeleteCity($count_arr);
		if($result > 1):
			Notice::add(Notice::SUCCESS, __(':count cities has been deleted successfully',array(':count' => $result)));
			$this->_redirect('admin/settings/citysettings');
		endif;
		Notice::add(Notice::SUCCESS, __('City has been deleted successfully'));
		$this->_redirect('admin/settings/citysettings');
	}
	
	public function action_massdeletearea()
	{
		$request = $this->getRequest();
		$data = $request->post();
		$query = $this->getRequest()->query();
		$areamodel = App::model('core/area');
		$count_arr = explode(',',$data['area_id']);
		$result = $areamodel->massDeleteArea($count_arr);
		if($result > 1):
			Notice::add(Notice::SUCCESS, __(':count areas has been deleted successfully',array(':count' => $result)));
			$this->_redirect('admin/settings/areasettings');
		endif;
		Notice::add(Notice::SUCCESS, __('Country has been deleted successfully'));
		$this->_redirect('admin/settings/areasettings');
	}

	public function action_sendsampleemail() {
		App::helper('notification')->ForceStopSystemNotification()
								->ForceStopPushNotification()
								->setGuest(true)
								->setCustomTemplateId(4)
								->setSsubject('This is test mail')
								->setMessage(array('MAIL' => 'This is test message'))
								->ForceStopPermissionCheck()
								->setTo(array('pradeepshyam@ndot.in'))
								->sendNotification();
		Notice::add(Notice::SUCCESS, __('Mail Sent Successfully'));
		$this->_redirect('admin/settings/email');
	}

	public function action_sendsampleiosnotification() {
		App::helper('notification')->sendIphoneNotificationAPNS('928220f1c7ec11607a247ecc4f22c0fe2a6ea33b8393a061d112d277fbea7a6c','test subject','dummy message');
	}
}
