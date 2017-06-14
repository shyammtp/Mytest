<?php defined('SYSPATH') OR die('No direct script access.');
/*
    * @Override Model
*/
class Model_Admin_Currency_Settings extends Model_Core_Currency {
  
    
    public function validate($data)
    { 
        $validate = Validation::factory($data);
        $validate->label('country_id',__('Country'))
                ->rule('country_id','not_empty')
                ->rule('currency_name','not_empty');          
        $currencyid = '';
        if(isset($data['currency_setting_id'])) { 
           $currencyid = $data['currency_setting_id'];
        }
        $validate->rule('currency_code',array($this,'_validateCurrencycode'),array(':value',$currencyid));
        $validate->rule('country_id',array($this,'_uniqueCountryId'),array(':value',$currencyid));
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }
        return $this;
    }
    
    public function _validateCurrencycode($value,$currencyid = '')
    { 
        $db = DB::select(array(DB::expr('count(currency_setting_id)'),'total'))->from($this->getTableName())
                    ->where('currency_code','=',$value);
        if($currencyid) {
            $db->where('currency_setting_id','!=',$currencyid);
        }
        $select = $db->execute()->get('total');
        return $select > 0 ? false: true;
            
    }

	
	public function _uniqueCountryId($value,$currencyid = '')
    { 
        $db = DB::select(array(DB::expr('count(country_id)'),'total'))->from($this->getTableName())
                    ->where('country_id','=',$value);
        if($currencyid) {
            $db->where('currency_setting_id','!=',$currencyid);
        }
        $select = $db->execute()->get('total');
        return $select > 0 ? false: true;
            
    }
	
	public function getOptionArray()
    {
        $options = array();
        $select = DB::select('*')->from(array($this->getTableName(),'main_table'))
                    ->as_object()->execute();

        foreach($select as $sel) {
            $options[$sel->currency_setting_id] = $sel->currency_name;
        }
        return $options;
    }
	
	

}
