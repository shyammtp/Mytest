<?php 
	$peoplemodel = App::model('core/peoples')->load($this->_getAppointmentInfo()->getPeopleId());	
?>
<div class="row">
	<div class="col-md-12">
		<form method="post" id="updateapptform" class="form-horizontal tab-form" action="<?php echo $this->getUrl('admin/appointments/updatedate',$this->getRequest()->query());?>" accept-charset="UTF-8">
<!-- Nav tabs --> 
         <div class="tab-content mb30">
        <div class="tab-pane active" id="home3">
		<div class="form-group">		  
			<div class="col-sm-12">
				<label  class="col-sm-3"><?php echo __('People Name');?></label>
				<label  class="col-sm-9"><?php echo $peoplemodel->getPeopleName(); ?></label>
			 </div>
        </div>
		<div class="form-group">		  
			<div class="col-sm-12">
				<label  class="col-sm-3"><?php echo __('Appointment Name');?></label>
				<label  class="col-sm-9"><?php echo $this->_getAppointmentInfo()->getAppointmentName(); ?></label>
			 </div>
        </div>
        <div class="form-group">		  
			<div class="col-sm-12">
				<label class="col-sm-3"><?php echo __('Info');?></label>
				<label class="col-sm-9"><?php echo $this->_getAppointmentInfo()->getInfo(); ?></label>
			 </div>
        </div>
       
        <div class="form-group">		  
			<div class="col-sm-12">
				<label class="col-sm-3"><?php echo __('Mobile Number');?></label>
				<label class="col-sm-9"><?php echo $this->_getAppointmentInfo()->getMobileNumber(); ?></label>
			 </div>
        </div>
        <div class="form-group">		  
			<div class="col-sm-12">
				<label class="col-sm-3"><?php echo __('Appointment Date');?></label>
				<?php if($this->_getAppointmentInfo()->getAcceptDate() =='') { ?>
				<label class="col-sm-9"><?php echo date("M d Y, h:i A", strtotime($this->_getAppointmentInfo()->getAppointmentDate())); ?></label>
				 <?php } else { ?>
				<label class="col-sm-9"><b><?php echo date("M d Y, h:i A", strtotime($this->_getAppointmentInfo()->getAcceptDate())); ?></b></label>
				 <?php } ?>
			 </div>
        </div>
		<div class="form-group">		  
			<div class="col-sm-12">
				<label class="col-sm-3"><?php echo __('User Accepted');?></label>
				<label class="col-sm-9"><?php if($this->_getAppointmentInfo()->getUserAccept()==''){ echo  __('Pending'); } else {  echo $this->_getAppointmentInfo()->getUserAccept() == "t" ? __('Yes'): __('No'); } ?></label>
			 </div>
        </div>  
        
        
        <?php  if(App::hasTask('admin/appointments/updatedate')){ ?>
			<?php if($this->_getAppointmentInfo()->getAccept() =='') { ?>
			<h3><?php echo __('Update the appointment schedule');?></h3>
			<p><?php echo __('This is a one time update. will not be changed afterwards');?></p>
			<div class="radio">		   
				<label><input type="radio" <?php echo $this->_getAppointmentInfo()->getAccept() == 't' || $this->_getAppointmentInfo()->getAccept() == '' ? "checked":"";?> value="accept" name="updateappt" /><?php echo __('Accept the appointment');?></label>  
			</div>
			<div class="radio">		   
				<label><input type="radio" <?php echo $this->_getAppointmentInfo()->getAccept() == 't' && $this->_getAppointmentInfo()->getData('modified_date') != $this->_getAppointmentInfo()->getAppointmentDate() ? "checked":"";?> value="modify" name="updateappt" /><?php echo __('Modify the appointment date');?></label>
				<div class="inputss" id="modify_inputs"></div>
			</div>
			<div class="radio">		   
				<label><input type="radio" <?php echo $this->_getAppointmentInfo()->getAccept() == 'f' ? "checked":"";?> value="reject" name="updateappt" /><?php echo __('Reject the appointment');?></label>
				<div class="inputss"  id="reject_inputs"></div>
			</div>
			 <div class="buttons">
				<button class="btn btn-primary mr5" id="saveappt" ><?php echo __('Save');?></button> 
				<button type="reset" class="btn btn-default" onclick="setLocation('<?php echo $this->getUrl("admin/appointments/index");?>')"><?php echo __('Cancel');?></button>
			</div>
			 <?php } ?>
		 <?php } ?>
		 
        </div>
        </div>
	</form>
		
</div></div>
<script>
	var modifyinputs = '<div class="input-group" >\
							<input type="text" class="form-control Datepicker" value="<?php echo $this->_getAppointmentInfo()->getModifiedDate();?>" name="modified_date" placeholder="mm/dd/yyyy" id="datepicker">\
							<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>\
						</div><br/>\
						<div class="form-group">\
							<div class="col-sm-12">\
								<textarea name="comment" placeholder="<?php echo __('Comments');?>" class="form-control"><?php echo $this->_getAppointmentInfo()->getComment();?></textarea>\
							</div>\
						</div>';
	var rejectinputs = '<div class="form-group">\
							<div class="col-sm-12">\
								<textarea name="comment" placeholder="<?php echo __('Comments');?>" class="form-control"><?php echo $this->_getAppointmentInfo()->getComment();?></textarea>\
							</div>\
						</div>';
	$(function(){
		$("#saveappt").click(function(){
			$(this).attr('disabled',true);
			$("#updateapptform").submit();
		});
		$('input[type="radio"]').click(function(){
			$(".inputss").html('');
			if ($(this).val() == "modify" ){
				$("#modify_inputs").html(modifyinputs);
				$('.Datepicker').datetimepicker({sideBySide:true,format: 'YYYY-MM-DD HH:mm:ss'});
			} else if ($(this).val() == "reject" ){
				$("#reject_inputs").html(rejectinputs); 
			} else {
				if (typeof $('.Datepicker').data("DateTimePicker") != 'undefined') {					
					$('.Datepicker').data("DateTimePicker").destroy(); 
				}
			}
		});
		 $('input[type="radio"]:checked').each(function(){ 
			$(this).click()
		 });
	});
</script>
