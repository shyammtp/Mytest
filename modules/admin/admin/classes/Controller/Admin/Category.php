<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Category extends Controller_Core_Admin {

	public function action_categories()
	{
		$this->loadBlocks('category/category');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Place Category'));
		$contentblock->setPageTitle('<i class="fa  fa-sitemap" ></i>&nbsp;'.__('Place Category'));
		$parent_id="";
		$categorymodel = App::model('core/category');
		if($this->getRequest()->query('id')){
			$parent_id=$this->getRequest()->query('id');
			$categorymodel->load($parent_id);
	    }
		$level=$categorymodel->getLevel();
		$tree=$categorymodel->getTree_path();
		if($level==0){
			$level=array($parent_id);
		}else{
			$level= explode('/',$tree);
			$level[] = $parent_id;
		}
		$categorymodel->unsetData();
		$category_title=App::model('core/category')->getTitleLists($level);
		$breadcrumb = $this->getBlock('breadcrumbs');
		$j = 1;
		foreach($category_title as $k) {
			if($parent_id) {
				$brarray = array('label' => __($k->lang_catname,array($k->lang_catname => ucfirst($k->lang_catname))),'title' =>ucfirst($k->lang_catname));
				if(count($category_title) > $j) {
					$brarray = Arr::merge($brarray,array('link'=>'admin/category/categories','query'=>array('id'=>$k->place_category_id)));
				}
				$this->getBlock('head')->setTitle($k->lang_catname);
				$breadcrumb->addCrumb($k->lang_catname,$brarray);
				$j++;
			}
		}
		$this->renderBlocks();
	}

	public function action_editcategory()
	{
		
		$session = App::model('admin/session');
		$this->loadBlocks('category/category');
		$categorymodel = App::model('core/category')->load($this->getRequest()->query('category_id'));
		/**if($categorymodel->getLevel() == 1 && $this->getRequest()->query('sub')){
			$this->_redirect('admin/category/categories');
		}*/
		
		if($this->getRequest()->query('category_id')!='' && $categorymodel->getPlaceCategoryId()!= $this->getRequest()->query('category_id')) {
			Notice::add(Notice::ERROR, __('Invalid Category'));
			$this->_redirect('admin/category/categories');
		}
		$contentblock = $this->getBlock('content');
		$breadcrumb = $this->getBlock('breadcrumbs');

		$parent_id="";
		$categorymodel = App::model('core/category');
		if($this->getRequest()->query('id')){
			$parent_id=$this->getRequest()->query('id');
			$categorymodel->load($parent_id);
	    }
		$level=$categorymodel->getLevel();
		$tree=$categorymodel->getTree_path();
		if($level==0){
			$level=array($parent_id);
		}else{
			$level= explode('/',$tree);
			$level[] = $parent_id;
		}
		$categorymodel->unsetData();
		$category_title=App::model('core/category')->getTitleLists($level);
		$breadcrumb = $this->getBlock('breadcrumbs');
		foreach($category_title as $k) {
			if($parent_id) {
				$brarray = array('label' => __($k->lang_catname,array($k->lang_catname => ucfirst($k->lang_catname))),'title' =>ucfirst($k->lang_catname));

				$brarray = Arr::merge($brarray,array('query'=>array('id'=>$k->place_category_id)));

				$this->getBlock('head')->setTitle($k->lang_catname);
				$breadcrumb->addCrumb($k->lang_catname,$brarray);
			}
		}

		if($this->getRequest()->query('category_id')) {
			$categoryinfomodel = App::model('core/category_info')->load($this->getRequest()->query('category_id'),"place_category_id");
			$this->getBlock('head')->setTitle(__('Edit category',array('category' => $categoryinfomodel->getPlaceName())));
			$contentblock->setPageTitle(__('Edit <span class="semi-bold"> category</span>',array('category' => ucfirst($categoryinfomodel->getPlaceName()))));
			$breadcrumb->addCrumb('Edit category',array('label' => __('Edit category',array('category' => ucfirst($categoryinfomodel->getPlaceName()))),'title' => __('Edit category',array('category' => $categoryinfomodel->getPlaceName()))));
		}
		$categorysmodel = App::model('core/category')->load($this->getRequest()->query('category_id'));
		if($session->getFormData()) {
			$this->_localSessionData();
			$categorysmodel->addData($session->getFormData()); 
			$session->unsetData('form_data');
		} 
		App::register('category',$categorysmodel); 
		$this->renderBlocks();
	}
	
	public function _localSessionData()
	{
		$session = App::model('admin/session');
		$data = $session->getFormData();
		if(isset($data['category_description'])) {
			$data['place_description'] = $data['category_description'];
		}
		if(isset($data['category_name'])) {
			$data['place_name'] = $data['category_name'];
		}
		if(!isset($data['status'])) {
			$data['status'] = false;
		}
		$session->setDatas('form_data',$data);
	}

	public function action_updatecategory()
	{
		$category_id=$this->getRequest()->query('category_id');
		$categorystatus=$this->getRequest()->query('state');
		$parent_id=0;
			if($this->getRequest()->query('id') >0){
				$parent_id=$this->getRequest()->query('id');
			}
			$categorymodel = App::model('core/category');
			$categorymodel->setPlaceCategoryId($category_id);
			$categorymodel->setStatus($categorystatus);
			$categorymodel->save();
			if($categorystatus==0){
				Notice::add(Notice::SUCCESS, __('Category blocked successfully'));
			}else{
				Notice::add(Notice::SUCCESS, __('Category unblocked successfully'));
			}
			$query = array();
			$query['id'] = $parent_id;
			$this->_redirect('admin/category/categories',$query);
	}

	public function action_addcategory_post()
	{ 
		$session = App::model('admin/session');
		$resources = $this->getRequest()->post();
		$request = $this->getRequest();
		$data = $this->getRequest()->post(); 
		$backto = isset($data['backto']);
		$json=array();
		$success = false;
        $errors = array();
		try {
			$query = $this->getRequest()->query();
			$query['id'] = $request->post('parent_id');
			$query['category_id'] = $request->post('category_id');
			$categorymodel = App::model('core/category');
			if($request->post('parent_id')){
				$categorymodel->load($data['parent_id']);
			}
			$parent_id = $categorymodel->getPlaceCategoryId();
			$level = $categorymodel->getLevel();
			$categorymodel->unsetData();
			$model = App::model('core/category');
			$validate = $model->category_name_validate($resources,$level);
				$info = App::model('core/category_info');
				if($data['category_id']){
					$model->setPlaceCategoryId($data['category_id']);
					$info->load($data['category_id'],'place_category_id');
				}
				if($data['parent_id']){
					$model->setCategoryParentId($data['parent_id']);
				}
				$image = App::helper('admin')->ImageExist($request->post('cateimage'),$data['category_image']);
				$model->setCategoryImage($data['category_image']);
				$level=1+$level;
				$model->setLevel($level);
				if(Arr::get($data,'is_explore_frontend')) {
					$model->setIsExploreFrontend(true);
				} else {
					$model->setIsExploreFrontend(false);
				}
				if($data['category_id']) {
					$model->setUpdatedDate(date("Y-m-d H:i:s",time()));
				} else {
					$model->setCreatedDate(date("Y-m-d H:i:s",time()));
				}
				$model->setExploreHint($request->post('explore_hint'));
				if(isset($_FILES['explore_normal_marker_icon']) && Arr::get($_FILES['explore_normal_marker_icon'],'name')) {
					$normalmarker = $this->image_category_update(Arr::get($_FILES,'explore_normal_marker_icon'));
					$model->setData('explore_normal_marker_icon',$normalmarker);
				}
				if(isset($_FILES['explore_normal_marker_icon']) && Arr::get($_FILES['explore_cluster_marker_icon'],'name')) {
					$clustermarker = $this->image_category_update(Arr::get($_FILES,'explore_cluster_marker_icon'));
					$model->setData('explore_cluster_marker_icon',$clustermarker);
				}
				if(isset($_FILES['explore_right_icon']) && Arr::get($_FILES['explore_right_icon'],'name')) {
					$exploreicon = $this->image_category_update(Arr::get($_FILES,'explore_right_icon'));
					$model->setData('explore_right_icon',$exploreicon);
				}
				$status = isset($data['status']) ? true : false;
				$model->setStatus($status);
				if($data['category_url'] !=""){
					$model->setCategoryUrl(URL::title($data['category_url']));
				}else{
					$model->setCategoryUrl(URL::title($data['category_name']['1']));
				}
				$model->setCategoryTags($data['category_tags']);
				$model->save();
				if($model->getId()){
					$query['category_id']=$model->getId();
				} 
				$path=NULL;
				if($data['parent_id']){
					$parentCategory = App::model('core/category',false)->load($data['parent_id']);
					if($parentCategory->getTreePath())
					$path = $parentCategory->getTreePath()."/".$parentCategory->getPlaceCategoryId();
					else
					$path = $parentCategory->getPlaceCategoryId();
					$clevel = (int)$parentCategory->getLevel();
					$clevel = $clevel+1;
				}else{
					$clevel = 1;
				}
				$model->setLevel($clevel)->setTreePath($path)->save();
				if(isset($query['isajax'])){
						$success='Category information has been  added';
						$json['sucess']=$success;
				}else {
					if($data['category_id']){
						Notice::add(Notice::SUCCESS, __('Category edited successfully'));
					}else{
						Notice::add(Notice::SUCCESS, __('Category added successfully'));
					}
				}
			}catch(Validation_Exception $ve) {
				
				$session->setDatas('form_data',$request->post());
				$errors = $ve->array->errors('validate/category',true);
				$this->_addPostData($resources);
				if($data['category_id']) {
					$query['category_id'] = $data['category_id'];
				}
				if(isset($query['isajax'])){
					$json['errors']=$errors;

				}else{
					Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validate/category',true));
					$this->_redirect('admin/category/editcategory',$query);
				}
			}catch(Kohana_Exception $ke) {
				Notice::add(Notice::ERROR,$ke->getMessage());
				Log::Instance()->add(Log::ERROR, $ke);

			} catch(Exception $e) {
				
				Log::Instance()->add(Log::ERROR, $e);
			}
			if(isset($query['isajax'])){
				$this->getResponse()->body(json_encode($json));
			}else{
				if($backto){ 
					$this->_redirect('admin/category/editcategory',$query);
				}
				$this->_redirect('admin/category/categories',$query);
			}
	}
	
	
	public function image_category_update($files)
	{ 
		$json = array();
		$filename = NULL; 
		if (isset($files['name']))
		{
			$uploaddir = '/uploads/category/place_category';
			if(!file_exists(DOCROOT.$uploaddir)) {
				mkdir(DOCROOT.$uploaddir,0777,true);
			}
		
			$filename = $this->_save_image($files,DOCROOT.$uploaddir);
			if($filename) {
				$image = basename(trim($filename,"/"));
				$filename = $uploaddir.DS.$image; 
				return $filename;
			}
		}
        if (!$filename) {
            throw new Kohana_Exception(__('There was a problem while uploading the image.
                Make sure it is uploaded and must be JPG/PNG file & Resoultion will not be max 30 x 30.'));
        } 
	}
	
	protected function _save_image($image, $dir)
    {
        if (! Upload::valid($image) OR
            ! Upload::not_empty($image) OR
            ! Upload::type($image, array('jpg', 'jpeg', 'png')))
        {
            return FALSE;
        } 
        $directory = $dir;
        if ($file = Upload::save($image, $image['name'], $directory)) {
            return $file;
        }
        return FALSE;
    }

	public function action_massblockcategory()
	{
		$parent_id=App::instance()->getWebsite()->getRootCategoryid();
		if($this->getRequest()->query('id') >0){
			$parent_id=$this->getRequest()->query('id');
	    }
		$category_id=$this->getRequest()->post('category_id');
		$categorystatus=0;
		$reward_loop=explode(',',$category_id);
		foreach($reward_loop as $a){
			$categorymodel = App::model('core/category');
			$categorymodel->setPlaceCategoryId($a);
			$categorymodel->setStatus($categorystatus);
			$categorymodel->save();
		}
			Notice::add(Notice::SUCCESS,  __('Mass block action runned successfully'));
			$query = array();
			$query['id'] = $parent_id;
			$this->_redirect('admin/category/categories',$query);
	}

	public function action_massunblockcategory()
	{
		$parent_id=App::instance()->getWebsite()->getRootCategoryid();
		if($this->getRequest()->query('id') >0){
			$parent_id=$this->getRequest()->query('id');
	    }
		$category_id=$this->getRequest()->post('category_id');
		$categorystatus=1;
		$reward_loop=explode(',',$category_id);
		foreach($reward_loop as $a){
			$categorymodel = App::model('core/category');
			$categorymodel->setPlaceCategoryId($a);
			$categorymodel->setStatus($categorystatus);
			$categorymodel->save();
		}
			Notice::add(Notice::SUCCESS,  __('Mass unblock action runned successfully'));
			$query = array();
			$query['id'] = $parent_id;
			$this->_redirect('admin/category/categories',$query);
	}

	public function action_deletecategory()
	{
		$category_id=$this->getRequest()->query('category_id');
		$parent_id="";
		if($this->getRequest()->query('id') >0){
			$parent_id=$this->getRequest()->query('id');
		}
		$category = App::model('core/category')->delete_category($category_id);
		Notice::add(Notice::SUCCESS, __('Category has been deleted successfully'));
		$query = array();
		$query['id'] = $parent_id;
		$this->_redirect('admin/category/categories',$query);

	}

	public function action_editcategoryform()
	{
		
		$session = App::model('admin/session');
		$categorymodel = App::model('core/category');
		$this->auto_render = false;
		$this->loadBlocks('category/category');
		$contentblock = $this->getBlock('content');
		App::register('category',$categorymodel);
		echo $contentblock->toHtml();
	}

	public function action_editsubcategoryform()
	{
		$session = App::model('admin/session');
		$categorymodel = App::model('core/category');
		$this->auto_render = false;
		$this->loadBlocks('category/category');
		$contentblock = $this->getBlock('content');
		App::register('category',$categorymodel);
		echo $contentblock->toHtml();
	}
	
	public function action_ajaxcategories()
	{
		$this->loadBlocks('category/category');
		$output=$this->getBlock('listing')->toHtml();
		$this->getResponse()->body($output);
	}
} // End Category
