<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Appointments_Renderer_Appointmentdate extends Blocks_Core_Widget_List_Column_Renderer_Action
{
    
    public function render(Kohana_Core_Object $row)
    { 
		$html = '<div>'; 
		$html .= '<b>'.Date::formatted_time($row->getData($this->getColumn()->getIndex()),'d, M Y h:i A').'</b>';
		$html .= '<div>';
		if($row->getData('appointment_date') != $row->getData('old_date')) {
			$html .= '<span class="fnt10">'.__('Date has altered by the service provider').'</span>';
		}
		if($row->getData('accept') == 't' && $row->getData('appointment_date') == $row->getData('old_date')) { 
			$html .= '&nbsp;<span class="label label-success">'.__('Accepted').'</span>';
		}
		if($row->getData('accept') == 'f') { 
			$html .= '&nbsp;<span class="label label-danger">'.__('Rejected').'</span>';
		}
		$html .= '</div>';
		if($row->getData('user_accept') == 't') { 
			$html .= '<div class="accept_apt"><i class="glyphicon glyphicon-thumbs-up"></i>&nbsp; '.__('User Accepted').'</div>';
		}
		else if($row->getData('user_accept') == 'f') { 
			$html .= '<div class="reject_apt"><i class="glyphicon glyphicon-thumbs-down"></i>&nbsp; '.__('User Rejected').'</div>';
		} else {
			if($row->getData('accept') == 't') { 
				$html .= '<a href="'.App::helper('url')->getUrl('account/acceptappointment',array('book_id' => $row->getData("booking_id"))).'" class="disp color_chan">'.__('Accept this appointment').'</a>';
			}
		}
		if($row->getData('comment')) { 
			$html .= '<span class="disp marg10"><b>Comments: </b>'.$row->getData('comment').'</span>';
		}
		$html .= '</div>';
		return $html;
	}


}
