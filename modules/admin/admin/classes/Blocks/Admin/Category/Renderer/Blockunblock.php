<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Category_Renderer_Blockunblock extends Blocks_Core_Widget_List_Column_Renderer_Abstract
{
    
    public function render(Kohana_Core_Object $row)
    {  
		$parentcat=$this->getRootCatId();
		if($this->getRequest()->query('id')){
			$parentcat=$this->getRequest()->query('id');
		}
		$addurl= App::helper('url')->getUrl('admin/category/editcategory',array('id'=>$row->getData('place_category_id')));
		$viewurl=App::helper("url")->getUrl('admin/category/categories',array('id'=>$row->getData('place_category_id')));
		$row->getData($this->getColumn()->getIndex())?$status=0:$status=1;	
		$parent_id="";
		if($this->getRequest()->query('id') >0){
			$parent_id=$this->getRequest()->query('id');
	    }
        $editurl = App::helper('url')->getUrl('admin/category/editcategory',array('id'=>$parent_id,'category_id'=>$row->getData('place_category_id')));
        $deleteurl = App::helper('url')->getUrl('admin/category/deletecategory',array('id'=>$parent_id,'category_id'=>$row->getData('place_category_id')));  
        $blockunblockurl = App::helper('url')->getUrl('admin/category/updatecategory',array('id'=>$parent_id,'category_id'=>$row->getData('place_category_id'),'state' =>$status));     
           
            $html1="";
            
		//if(App::hasTask('admin/place/editplacecategory')){
			if($row->getData('category_parent_id')!=0){
				if($status){
					$html1 = '<a href="'.$blockunblockurl.'"  title="'.__('UnBlock').'" onclick="SD.Common.confirm(event,\''.__("Unblocking this category will unblock all the children category?").'\');"> <i class="fa fa-lock"></i>&nbsp;&nbsp;'.__('UnBlock').'</a>';
				} else {
					$html1 = '<a href="'.$blockunblockurl.'"  title="'.__('Block').'" onclick="SD.Common.confirm(event,\''.__("Blocking this category will block all the children category?").'\');"><i class="fa fa-unlock"></i>&nbsp;&nbsp; '.__('Block').'</a>';	
				}
				$html1 .= '<li><a href="'.$editurl.'"><i class="fa fa-edit"></i>&nbsp;&nbsp;'.__('Edit').'</a></li>';
				
				$html1 .=  '<li><a  href="'. $deleteurl.'" onclick="SD.Common.confirm(event,\''.__("Are you sure want to delete this category?").'\');"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;'.__('Delete').'</a></li>';
			}
			$html='--';
			  if(App::hasTask('admin/category/editcategory')){

				$html = '<div class="btn-group">
											<a href="'.$viewurl.'" class="btn btn-xs btn-white"><i class="fa fa-search-plus"></i>&nbsp;'.__('View').'</a>
											<button type="button" class="btn btn-xs btn-white dropdown-toggle" data-toggle="dropdown">
											  <span class="caret"></span>
											  <span class="sr-only">Toggle Dropdown</span>
											</button>';
										  
											   $html .= '<ul class="dropdown-menu xs pull-right" role="menu">
												   <li><a href="'.$addurl.'"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;'.__('Add Sub Category').'</a></li>
												   <li>'.$html1.'</li>                                         
												</ul>
											  </div>';
				}
          return $html;
	//}
        
    }
}
