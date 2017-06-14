<?php defined('SYSPATH') OR die('No direct script access.');  $attributes=App::model('entity/attributes')->getAttributeByEntity(App::model('user')->getEntity()->getEntityTypeId(),true);  
	$exclude=array('verification_link_expiry_status','password_verification_code','password_verification_key','facebook_profile_id','gplus_profile_id','confirm_email','email_confirmation_status');
	$default=array('number'=>__('Mobile Number'),'date_of_birth'=>__('Date of birth'),'gender'=>__('Gender'),'profile_image'=>__('Profile Picture'),'user_profession_id'=>__('Profession'),'primary_email_address'=>__('Email'));
	$labels=array();
	$code=array();
	foreach($attributes as $key => $val ){
		$label = App::model('entity/attributes_label',false)->getAttributeLabels(App::getCurrentLanguageId(),$val->getAttributeId());
			if(!in_array($val->getAttributeCode(),$exclude)){
				$labels[$val->getAttributeCode()]=$label->getBackendLabel();				
			}
	 }
	 $fields = array_merge($labels,$default);?>
	<?php $datas=$this->_getValue(); foreach($fields as $keys => $values) {  ?>
			<div class="col-sm-3">
			<label class="control-label"><?php echo $values; ?></label>
			</div>
			<div class="col-sm-3">
			  <input type="text" class="form-control total" autocomplete="off" data-attr="<?php echo $keys; ?>" id="dataid-<?php echo $keys; ?>" maxlength='2' name="<?php echo $this->getName();?>[<?php echo $keys; ?>]" value="<?php  if(isset($datas[$keys]) && $datas[$keys]!=''){ echo $datas[$keys]; } else { echo 0; } ?>" style="width:100px;margin-top:10px;">
			</div>
	<?php }    ?>
	
	<script>
	 $(function() {
		$(".total").live('keyup',function(){ 
			var id=$(this).attr("data-attr");
			var total=0;
			$(".total").each(function(){
				var val = $(this).val() || 0;
				total += parseInt(val);
			});
			if(total<=100){
				return true;
			}
			if(total>100) {
				$('#dataid-'+id).val(0)
				return false;
			}
		});
	 });
	</script>
			   
			   
