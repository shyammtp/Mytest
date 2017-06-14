<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Database Model base class.
 *
 * @package    Kohana/Database
 * @category   Models
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Model_User_Review_Api extends Model_RestAPI {
    
	public $params = array();    

	protected $_totalItem = 0;
    public function __construct()
    { 
        
    }
    
	private function topProductReviewsAll()
	{ 
		$language_sql= '(case when (select count(value_id) as totalcount from '.App::model('user/attribute')->getTableName().' as info where info.language_id = '.$this->params['language_id'].' and info.user_id = pr.user_id) > 0 THEN '.$this->params['language_id'].' ELSE 1 END)';
		$vote = ' ( (case when pr.review_yes is null then 0 else pr.review_yes end) + (case when pr.review_no is null then 0 else pr.review_no end))';
		$select = DB::select('pr.product_id','pr.title',array('pr.review_id','revid'), 'pr.description', 'pr.rated_date', array(DB::expr($vote),'totluser'),array('pr.review_yes','rhelp'), array('uav.value','username'), 'pr.average_rating')->from(array(App::model('core/rating_product_review')->getTableName(),'pr'))
						->join(array(App::model('user/attribute')->getTableName(),'uav'))
						->on('uav.attribute_id','=',DB::expr('22'))
						->on('uav.language_id','=',DB::expr($language_sql))
						->on('uav.user_id','=','pr.user_id') 
						->where('pr.user_id','=',$this->params['user_id'])
						->and_where('pr.is_review','=',true);
		$tabselect = DB::select('*')->from(array(DB::expr('('.$select.')'),'mat'));
		
		if(isset($this->params['rating']) && $this->params['rating']!="") { 
			if(strpos($this->params['rating'],'-')!==false) {
				$tabselect->where_open();
				$explode = explode("-",$this->params['rating']);
				$ratinga = (int) isset($explode[0])?$explode[0]:0;
				$ratingfroma = $ratinga - 0.99; 
				$tabselect->where('average_rating','between',array($ratingfroma,$ratinga));				

				$ratingb = (int) isset($explode[1])?$explode[1]:0;
				$ratingfromb = $ratingb - 0.99; 
				$tabselect->or_where('average_rating','between',array($ratingfromb,$ratingb));
				$tabselect->where_close();
				
			} else {
				$rating = (int) $this->params['rating'];
				$ratingfrom = $rating - 0.99;
				$tabselect->where('average_rating','between',array($ratingfrom,$rating));
			}
		}
		if(isset($this->params['sort-review'])) {
			switch($this->params['sort-review'])
			{
				case 'm-recent':
					$tabselect->order_by('mat.rated_date','desc');
					break;
				case 'm-helpful':
					$tabselect->order_by('mat.rhelp','desc');
					break;
			}
		} else {
			$tabselect->order_by('mat.rhelp','desc');
		}
		$counttopreviews = $this->_getTotalItem($tabselect); 
		$topreviews = array();
		$tabselect->limit($this->_getPerPage())
				->offset($this->_getOffset());
		$this->params['topreviews'] = array(0);
		foreach($tabselect->execute() as $reviews)
		{
            
            $product = App::model('product',false)->load($reviews['product_id']);
			$this->params['topreviews'][] = $reviews['revid'];
			$reviews['rated_date'] = Date::formatted_time($reviews['rated_date'],'M, d Y');
			$reviews['revid'] = Encrypt::instance()->encode($reviews['revid']);
            $reviews['product'] = array('name' => $product->getProductName(),
                                        'thumbnail' => $product->getProductThumbnail('w80'),
                                        'ref' => $product->getReference(),
                                        'url' => $product->getPathUrlKey());
            unset($reviews['product_id']);
			$topreviews[] = $reviews;
		}
		return array('top_reviews' => $topreviews, 'total' => $counttopreviews);
	}
	
	
	private function topPlaceReviewsAll()
	{ 
		$language_sql= '(case when (select count(value_id) as totalcount from '.App::model('user/attribute')->getTableName().' as info where info.language_id = '.$this->params['language_id'].' and info.user_id = pr.user_id) > 0 THEN '.$this->params['language_id'].' ELSE 1 END)';
		$placelanguage_sql= '(case when (select count(planginfo.place_id) as ptotalcount from '.App::model('core/place_info')->getTableName().' as planginfo where planginfo.language_id = '.$this->params['language_id'].' and planginfo.place_id = pr.place_id) > 0 THEN '.$this->params['language_id'].' ELSE 1 END)';
		
		$select = DB::select('pr.place_id','pr.title',array('pr.review_id','revid'), 'pr.description', 'pr.rated_date', array('uav.value','username'), 'pr.average_rating','pinfo.place_name','pi.place_index')->from(array(App::model('core/rating_place_review')->getTableName(),'pr'))
						->join(array(App::model('user/attribute')->getTableName(),'uav'))
						->on('uav.attribute_id','=',DB::expr('22'))
						->on('uav.language_id','=',DB::expr($language_sql))
						->on('uav.user_id','=','pr.user_id') 
						->join(array(App::model('core/place')->getTableName(),'pi'))
						->on('pr.place_id','=','pi.place_id')
						->join(array(App::model('core/place_info')->getTableName(),'pinfo'))
						->on('pr.place_id','=','pinfo.place_id')
						->on('pinfo.language_id','=',DB::expr($placelanguage_sql))
						->where('pr.user_id','=',$this->params['user_id'])
						->and_where('pr.is_review','=',true);
		$tabselect = DB::select('*')->from(array(DB::expr('('.$select.')'),'mat'));		
		$tabselect->order_by('mat.rated_date','desc');
		
		$counttopreviews = $this->_getTotalItem($tabselect); 
		$topreviews = array();
		$tabselect->limit($this->_getPerPage())
				->offset($this->_getOffset());
		$this->params['topreviews'] = array(0);
		foreach($tabselect->execute() as $reviews)
		{
            
           // $product = App::model('product',false)->load($reviews['product_id']);
			$this->params['topreviews'][] = $reviews['revid'];
			$reviews['rated_date'] = Date::formatted_time($reviews['rated_date'],'M, d Y');
			$reviews['revid'] = Encrypt::instance()->encode($reviews['revid']);
            /*$reviews['product'] = array('name' => $product->getProductName(),
                                        'thumbnail' => $product->getProductThumbnail('w80'),
                                        'ref' => $product->getReference(),
                                        'url' => $product->getPathUrlKey());*/
            //unset($reviews['product_id']);
			$topreviews[] = $reviews;
		}
		return array('top_reviews' => $topreviews, 'total' => $counttopreviews);
	}
	
	private function topSepcialistReviewsAll()
	{ 
		$language_sql= '(case when (select count(value_id) as totalcount from '.App::model('user/attribute')->getTableName().' as info where info.language_id = '.$this->params['language_id'].' and info.user_id = pr.user_id) > 0 THEN '.$this->params['language_id'].' ELSE 1 END)';
		
		
		$select = DB::select('pr.people_id','pr.title',array('pr.review_id','revid'), 'pr.description', 'pr.rated_date', array('uav.value','username'), 'pr.average_rating','peop.people_name')->from(array(App::model('core/rating_people_review')->getTableName(),'pr'))
						->join(array(App::model('user/attribute')->getTableName(),'uav'))
						->on('uav.attribute_id','=',DB::expr('22'))
						->on('uav.language_id','=',DB::expr($language_sql))
						->on('uav.user_id','=','pr.user_id') 
						->join(array(App::model('peoples')->getTableName(),'peop'))
						->on('pr.people_id','=','peop.people_id')  
						->where('pr.user_id','=',$this->params['user_id'])
						->and_where('pr.is_review','=',true);
		$tabselect = DB::select('*')->from(array(DB::expr('('.$select.')'),'mat'));		
		$tabselect->order_by('mat.rated_date','desc');
		
		$counttopreviews = $this->_getTotalItem($tabselect); 
		$topreviews = array();
		$tabselect->limit($this->_getPerPage())
				->offset($this->_getOffset());
		$this->params['topreviews'] = array(0);
		foreach($tabselect->execute() as $reviews)
		{
             
			$this->params['topreviews'][] = $reviews['revid'];
			$reviews['rated_date'] = Date::formatted_time($reviews['rated_date'],'M, d Y');
			$reviews['revid'] = Encrypt::instance()->encode($reviews['revid']); 
			$topreviews[] = $reviews;
		}
		return array('top_reviews' => $topreviews, 'total' => $counttopreviews);
	}
     
    public function getProductReviews()
    {
        if(isset($this->params['uid'])) {
            $user = App::model('user',false)->load($this->params['uid'],'user_token');
        }
        $this->params['user_id'] = $user->getId();
        $params = $this->params;
        $this->params['language_id'] = isset($this->params['language_id']) ? $this->params['language_id'] : 1;  
		 
        $topreviews = $this->topProductReviewsAll();
        return array('topreviews' => $topreviews['top_reviews'],'ttop' => $topreviews['total']);
     
    }
	
	public function getPlaceReviews()
    {
        if(isset($this->params['uid'])) {
            $user = App::model('user',false)->load($this->params['uid'],'user_token');
        }
        $this->params['user_id'] = $user->getId();
        $params = $this->params;
        $this->params['language_id'] = isset($this->params['language_id']) ? $this->params['language_id'] : 1;  
		 
        $topreviews = $this->topPlaceReviewsAll();
        return array('topreviews' => $topreviews['top_reviews'],'ttop' => $topreviews['total']);
     
    }
	
	public function getPeopleReviews()
    {
        if(isset($this->params['uid'])) {
            $user = App::model('user',false)->load($this->params['uid'],'user_token');
        }
        $this->params['user_id'] = $user->getId();
        $params = $this->params;
        $this->params['language_id'] = isset($this->params['language_id']) ? $this->params['language_id'] : 1;  
		 
        $topreviews = $this->topSepcialistReviewsAll();
        return array('topreviews' => $topreviews['top_reviews'],'ttop' => $topreviews['total']);
     
    }
    
    private function _getTotalItem($select)
	{
		if(!$this->_totalItem) { 
			$pagination_query = clone $select;
            $this->_totalItem =  $pagination_query->resetSelect()->resetSelect('order')->select(DB::expr('COUNT(\'*\') AS mycount'))->execute()->get('mycount'); 
        }
        return $this->_totalItem;
	}
	
	private function _getPerPage()
	{
		if(isset($this->params['perpage']) && $this->params['perpage']!="") {
			return $this->params['perpage'];
		}
		return 8;
	}
	
	public function getLastPage()
    { 
        return ceil($this->_getTotalItem()/$this->_getPerPage());
    }
	
	private function _getCurrentPage()
    {
        $currentpage = isset($this->params['page'])?$this->params['page']: 1; 
        /*if($currentpage > $this->getLastPage()) {
            $currentpage = $this->getLastPage();
        }*/ 
        return $currentpage;
    }
	
	private function _getOffset()
    {
		
        $this->_offset  = (int) (($this->_getCurrentPage() - 1) * $this->_getPerPage());
        if( $this->_offset < 0) {
             $this->_offset = 0;
        }
        return  $this->_offset;
    }
}
