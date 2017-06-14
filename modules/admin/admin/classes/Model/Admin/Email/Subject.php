<?php defined('SYSPATH') OR die('No direct script access.');
/*
    * @Override Model
*/
class Model_Admin_Email_Subject extends Model_Core_Subject {
    
    public function validate($data)
    { 		
        $validate = Validation::factory($data);
        $validate->label('subject_type','Subject Type')
				 ->label('template_id','Template')
				 ->label('color_code','Color Code')
				 ->rule('subject_type','not_empty')
				 //->rule('subject_type','language_not_empty',array(':value',array(Model_Core_Language::DEFAULT_LANGUAGE)))
				 ->rule('template_id','not_empty')
				 ->rule('color_code','not_empty');   
		$subjectid = '';
        if(isset($data['id'])) {
           $subjectid = $data['id'];
        }		 
		$validate->rule('subject_type',array($this,'_validateSubjectType'),array(':value',$subjectid));		                     
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }
        return $this;
    }
    
    public function _validateSubjectType($value,$subjectid = '')
    { 	
		$subject_type = explode('|',$value);
        $db = DB::select(array(DB::expr('count(main_table.id)'),'total'))->from(array(App::model('core/subject')->getTableName(),'main_table'))
                    ->where('main_table.subject_type','=',$subject_type[0]);
        if($subjectid) {
            $db->where('main_table.id','!=',$subjectid);
        }
        $select = $db->execute()->get('total');
        return $select > 0 ? false: true;

    }
    
    public function getSubjectType() {
		return array(
			'user_assignment' => 'User Assignment',
			'order_receipt' => 'Order Receipt',
			'order_pickup' => 'Order Pickup',
			'delivery_confirmation' => 'Delivery Confirmation',				
			'payment_receipt' => 'Payment Receipt',
			'payment_transfer' => 'Payment Transfer',
			'order_cancellation' => 'Order Cancellation',
			'goods_return' => 'Goods Return',
			'requirement_post' => 'Requirement Post',
			'product_review' => 'Product Review',
			'people_review' => 'People Review',
			'place_review' => 'Place Review',
			'product_service_add_confirmation' => 'Product / Service Add Confirmation',
			'new_product_service' => 'New Product / Service',
			'point_new_entry' => 'New Point Entry',
			'mail' => 'Mail',		
			'shortlist' => 'Shortlist',
			'appointment' => 'Appointment',	
			'subscription' => 'Subscription',
			'review_report_abuse'=>'Review Report Abuse',
			'admin_requirement_post' => 'Admin Post Requirements',	
			'item_cancellation'=>'Item Cancellation',
			'return_request'=>'Return Request'
		);
	}
	
	public function saveSubject()
    {		
        $request = Request::current();  
        App::dispatchEvent('Email_Subject_Save_Before',array('post'=> $request->post(),'subject' => $this));
        parent::save();
        App::dispatchEvent('Email_Subject_Save_After',array('post'=> $request->post(),'subject' => $this));
        return $this;
    }
    
    public function getLabel($fieldname, $languageid = 1)
    { 
        $select = App::model('admin/email_subject/label')->getSubjectLabels($languageid,$this->getId());
        return $select->getData($fieldname);
    }
}
