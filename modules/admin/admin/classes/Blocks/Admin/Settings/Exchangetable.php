<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Settings_Exchangetable extends Blocks_Admin_Abstract
{ 
    public function __construct()
    {
        $this->setTemplate('settings/exchangetable');
    }
    
    public function getBaseCurrency()
    {
        return $this->getRequest()->query('basecurrency');
    }
    
    public function getFieldName()
    {
        return Arr::get($this->getRequest()->query(),'fieldname','CURRENCY_EXCHANGE_RATE');
    }
    
    public function getValue()
    {
        return Arr::get($this->getRequest()->query(),'value',array());
    }
    
    
    
    public function getCurrency()
    {
        if(!$this->hasData('currency')) {
            $model = DB::select('*')->from(App::model('core/currency')->getTableName())
                    ->execute()
                    ->as_array();
            $this->setData('currency',$model);
        }
        return $this->getData('currency');
    }
    
    public function getCurrencyIds()
    {
        $currencyset = array();
        foreach($this->getCurrency() as $currency) {
            $currencyset[] = $currency['currency_setting_id'];
        }
        return $currencyset;
    }
    
    public function getCurrencySet($id = '')
    {
        $currencyset = array();
        foreach($this->getCurrency() as $currency) {
            $currencyset[$currency['currency_setting_id']] = $currency;
        }
        return new Kohana_Core_Object(Arr::get($currencyset,$id,array()));
    }
    
    public function getCurrencySetWithoutBase()
    {        
        $currencyset = array();
        foreach($this->getCurrency() as $currency) {
            if($currency['currency_setting_id'] != $this->getBaseCurrency()) {                
                $currencyset[$currency['currency_setting_id']] = $currency;
            }
        }
        return $currencyset;
    }
    
    public function getCurrencyWithBase()
    { 
        foreach($this->getCurrency() as $currency) {
            if($currency['currency_setting_id'] == $this->getBaseCurrency()) {                
                return new Kohana_Core_Object($currency);
            }
        }
        return new Kohana_Core_Object(array());
    }
}