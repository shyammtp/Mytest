<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Page_Header extends Blocks_Front_Abstract
{ 
    public function getLogo($type = "square")
    {
        if($type == 'horizontal') {
            $logo = App::getConfig('ADMIN_HORIZONTAL_LOGO',Model_Core_Place::ADMIN);
        } else {
            $logo = App::getConfig('ADMIN_LOGO',Model_Core_Place::ADMIN);
        }
        if($logo && file_exists(DOCROOT.$logo)) {
            $logo = App::getBaseUrl().$logo;
        }
        return $logo;
    }
    
    public function getCartItems()
	{
		$cartmodel = App::model('cart',false);
        $cartid = $cartmodel->lastCartId(); 
		$cart = $cartmodel->load($cartid); 
		$cartitems = $cart->getItems();
        $it = array();
        foreach($cartitems as $items) {
            $products = $this->_getProductContent($items);
			
            $items->setProductInfo(new Kohana_Core_Object($products)); 
            $it[] = $items;            
        }
		return $it;
	}
	
	private function _getProductContent($items)
	{
		$itemlang = DB::select('item_name')->from(App::model('cart/items_language')->getTableName())
							->where('item_id','=', $items->getId())
							->where('language_id','=',App::getCurrentLanguageId())
							->execute()->current();
		$sel = $items->getData();
		/*$condition = '(case when (pr.special_price > 0 and pr.special_price <= pr.price) then pr.special_price else pr.price end)';
		$product = App::model('product',false)->load($product_id);
		$cdate = Date::formatted_time(); 
		$promotionpercentage = '(select (case when(offer_from_date < \''.$cdate.'\' and offer_to_date > \''.$cdate.'\') then offer_value else 0 end) as offer_value,place_id,promotion_product_id  from '.App::model('core/promotion')->getTableName().' where place_id = '.$place_id.' and promotion_product_id = '.$product->getId().' and offer_type = 1 and offer_apply = 1 order by created_date limit 1) ';
		$select = DB::select(array(DB::expr($condition),'price'),array('pr.price','old_price'),'offer_value')
						->from(array(App::model('product/price')->getTableName(),'pr'))
						->join(array(DB::expr($promotionpercentage),'pom'),'left')
						->on('pom.promotion_product_id','=','pr.product_id')
						->on('pom.place_id','=','pr.place_id')
						->where('pr.product_id','=',$product->getId())
						->where('pr.place_id','=',$place_id);
		$price = DB::select(array(DB::expr('(case when (price - price * (offer_value / 100)) > 0 and (price - price * (offer_value / 100)) < price then price else old_price end )'),'old_price'),
							array(DB::expr(' (case when (price - price * (offer_value / 100)) > 0 and (price - price * (offer_value / 100)) < price then cast((price - price * (offer_value / 100)) as numeric(12,4)) else price end )'),'price'))
					->from(array(DB::expr('('.$select.')'),'tab'))
					->execute()->current();*/
		$products = array();
		$products['product_name'] = Arr::get($itemlang,'item_name',null);
		$products['product_url'] = Arr::get($sel,'item_url'); 							
		$products['thumbnail'] = Arr::get($sel,'item_image'); 
		$products['price'] = Arr::get($sel,'base_price');
		$products['old_price'] = Arr::get($sel,'old_price');							
		$place_id = Arr::get($sel,'place_id'); 
		$products['price_formatted'] = App::helper('price')->formatPrice($products['price'],$place_id,true);
		$products['old_price_formatted'] = App::helper('price')->formatPrice($products['old_price'],$place_id,true,'clr2 line-through');  
		if($products['old_price'] != $products['price']) {
			$products['offer'] = round((1 - ( $products['price'] / $products['old_price'] )) * 100);
		}  
		return $products; 
		
	} 
    
}