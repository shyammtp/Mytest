<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Adverts_Renderer_Actions extends Blocks_Core_Widget_List_Column_Renderer_Text
{
    public function render(Kohana_Core_Object $row)
    {
		$row->getData($this->getColumn()->getIndex())?$status=0:$status=1;		  
        $blockunblockurl = App::helper('url')->getUrl('admin/adverts/blockunblockadvertsblock',array('adverts_id' => $row->getData('adverts_id'),'status'=>$status));   
        if($status){
			$html1 = '<a href="'.$blockunblockurl.'"  title="'.__('UnBlock').'"> <i class="fa fa-lock"></i>&nbsp;&nbsp;'.__('UnBlock').'</a>';
		}else{
			$html1 = '<a href="'.$blockunblockurl.'"  title="'.__('Block').'"><i class="fa fa-unlock"></i>&nbsp;&nbsp; '.__('Block').'</a>';	
		}
		$html = '<div class="btn-group">
                                        <a href="'.App::helper('url')->getUrl('admin/adverts/edit_advert',array('adverts_id' => $row->getData('adverts_id'))).'" class="btn btn-xs btn-white"><i class="fa fa-edit"></i>&nbsp;'.__('Edit').'</a>
                                        <button type="button" class="btn btn-xs btn-white dropdown-toggle" data-toggle="dropdown">
                                          <span class="caret"></span>
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>                  
                                        <ul class="dropdown-menu xs pull-right" role="menu">
											<li>'.$html1.'</li>
                                            <li class="divider"></li>
                                            <li><a  href="'.App::helper('url')->getUrl('admin/adverts/delete_advert',array('adverts_id' => $row->getData('adverts_id'))).'" onclick="SD.Common.confirm(event,\''.__("Are you sure want to delete?").'\');"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;'.__('Delete').'</a></li>
                                        </ul>
                                      </div>';
        return $html;
    }

}
