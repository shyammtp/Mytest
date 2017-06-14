<?php defined('SYSPATH') OR die('No direct script access.');
/*
    * @Front End Login Model
*/
class Model_Login extends Model_User {

	public function validateFrontEndUser($data)
    {		
        App::dispatchEvent('User_Validate_Before',array('user' => $this));        
        $attributes = App::model('entity/attributes')->getAttributeByEntity($this->getEntity()->getEntityTypeId(),true);        
        $validate = Validation::factory($this->getData());                
        $validate->label('primary_email_address','Email Address')->rules('primary_email_address',array(array('not_empty'),array('email')));
        $validate->rule('primary_email_address',array($this,'_validateEmailExist'));
        if(!$this->getUserId()) {
            $validate->label('password','Password')->rule('password','not_empty');
            $validate->label('first_name','Full Name')->rule('first_name','not_empty');
            $validate->label('date_of_birth','Date of Birth')->rule('date_of_birth','not_empty');
        }        
        App::dispatchEvent('User_Validate_Before',array('user' => $this,'validate' => $validate));
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }                
        return $this;
    }
    
    public function validatesignin($data)
    { 	
        $validate = Validation::factory($data);
        $validate->label('email','Email')
				 ->label('password','Password')
				 ->rule('email','not_empty')
				 ->rule('password','not_empty')
				 ->rule('email','email')
				 ->rule('email',array($this,'_validateEmailNotExist'), array($data['email']))                    
				 ->rule('email',array($this,'_validateEmailPassword'), array($data['email'],$data['password']));                      
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }
        return $this;
    }
    
    public function validateforgetpass($data)
    { 				
        $validate = Validation::factory($data);
        $validate->label('email','Email')
				 ->rule('email','not_empty')
				 ->rule('email','email')
				 ->rule('email',array($this,'_validateEmailNotExist'), array($data['email']));                         
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }
        return $this;
    }
    
    public function _validateEmailPassword($email,$pass)
    { 
		
        $db = DB::select(array(DB::expr('count(user_id)'),'total'))->from(App::model('user')->getTableName())
                    ->where('primary_email_address','=',$email)                
                    ->where('password','=',md5($pass))                   
                    ->where('status','=',1)                  
                    ->where('is_verified','=',1);                   
        $select = $db->execute()->get('total');
        return $select > 0 ? true: false;
    } 
    
    public function _validateEmailNotExist($value)
    { 
        $db = DB::select(array(DB::expr('count(user_id)'),'total'))->from(App::model('user')->getTableName())
                    ->where('primary_email_address','=',$value);                   
        $select = $db->execute()->get('total');
        return $select > 0 ? true: false;
    } 
    
    public function _validateEmailExist($value)
    { 
        $db = DB::select(array(DB::expr('count(user_id)'),'total'))->from(App::model('user')->getTableName())
                    ->where('primary_email_address','=',$value);                   
        $select = $db->execute()->get('total');
        return $select > 0 ? false: true;
    } 
    
    public function _isVerification($key,$email)
    { 
        $db = DB::select(array(DB::expr('count(user_id)'),'total'))->from(App::model('user')->getTableName())
                    ->where('primary_email_address','=',$email)
                    ->where('verification_key','=',$key)
                    ->where('is_verified','=',0);                   
        $select = $db->execute()->get('total');
        return $select > 0 ? true: false;
    }
    
    public function _emailConfirmation($key,$email)
    { 
        $db = DB::select(array(DB::expr('count(user_id)'),'total'))->from(App::model('user')->getTableName())
                    ->where('primary_email_address','=',$email)
                    ->where('verification_key','=',$key);                   
        $select = $db->execute()->get('total');
        return $select > 0 ? true: false;
    }
    
    public function userlogin($post = array())
    {
        $customer = $this->selectAttributes('*')->filter('primary_email_address', array('=',trim(strtolower($post['email']))))
                            ->filter('password', array('=',md5($post['password'])))
							->filter('status', array('=',true))
							->filter('is_verified', array('=',true));
		 
        $select = $customer->loadCollection();
        if(isset($select[0])) {
            if(isset($post['rememberme']) && $post['rememberme']== 1) {
                Cookie::set('user_info', base64_encode(json_encode($post)),604800);
            }
            return $select;
        }
        return false;
    }
    

}
