<?php
$email_template = $this->getEmailTemplate();
?>
<?php $arr=array(); $arr['company']=array('company_name'=>__('Company Name'),'grid_number'=>__('Grid Number'),'box_number'=>__('Box Number'),'polygon_number'=>__('Polygon Number'));$arr['store']=array('store_name'=>__('Store Name'),'grid_number'=>__('Grid Number'),'box_number'=>__('Box Number'),'polygon_number'=>__('Polygon Number'));$arr['education']=array('education_name'=>__('Education Name'),'grid_number'=>__('Grid Number'),'box_number'=>__('Box Number'),'polygon_number'=>__('Polygon Number'));$arr['religious']=array('religious_name'=>__('Religious Name'),'grid_number'=>__('Grid Number'),'box_number'=>__('Box Number'),'polygon_number'=>__('Polygon Number'));$arr['healthcare']=array('healthcare_name'=>__('Healthcare Name'),'grid_number'=>__('Grid Number'),'box_number'=>__('Box Number'),'polygon_number'=>__('Polygon Number'));$arr['garden']=array('garden_name'=>__('Garden Name'),'grid_number'=>__('Grid Number'),'box_number'=>__('Box Number'),'polygon_number'=>__('Polygon Number'));$arr['parking']=array('parking_name'=>__('Parking Name'),'grid_number'=>__('Grid Number'),'box_number'=>__('Box Number'),'polygon_number'=>__('Polygon Number')); ?>
<div class="row">
    <div class="pull-right">
        <?php if($email_template->getTemplateId() && !$email_template->getIsSystem()):?> 
                <a href="<?php echo $this->getUrl("admin/template/delete",array('id' => $email_template->getTemplateId()));?>" class="btn btn-danger" title="Delete" onclick="SD.Common.confirm(event,'Are you sure want to delete?');"><i class="fa fa-trash-o"></i></a>
        <?php endif;?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs nav-tabs-simple">
            <li class="active"><a href="#user_info" data-toggle="tab"><strong><?php echo __("From Information");?></strong></a></li>
            <li><a href="#user_social_info" data-toggle="tab"><strong><?php echo __("HTML Content");?></strong></a></li> 
        </ul>
        <div class="row">
        <form class="tab-form" method="post" id="email_form" action="<?php echo $this->getUrl('admin/template/save',$this->getRequest()->query());?>"> 
            <div class="row mt20">
        <div class="col-sm-12">
            <div class="alert alert-info">
                <h4><?php echo __('Info:');?></h4>
                <p>
                    -  <strong><?php echo __('Red');?></strong> <?php echo __('highlighted label will be mandatory.');?><br>
                </p>
            </div>
        </div>
    </div>
        <div class="tab-content  tab-content-simple mb30 no-padding" >
            <div class="tab-pane active" id="user_info">
				
                <div class="form-group">
                    <label class="col-sm-2 control-label required-hightlight"><?php echo __('Reference Name');?></label>
                    <div class="col-sm-6"> 
                            <input type="text" class="form-control" autocomplete="off" name="ref_name" value="<?php echo $email_template->getData('ref_name');?>" id="reference_name">
                            <span class="help-block"><?php echo __('A unique name for this template. This for internal use.');?></span> 
                    </div>
                </div><!-- form-group -->
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('From Name');?></label>
                    <div class="col-sm-6"> 
                            <input type="text" class="form-control" autocomplete="off" name="from" value="<?php echo $email_template->getData('from');?>" id="from">
                            <span class="help-block"><?php echo __('The name this emails comes from (Eg: Bill smith, Rocky)');?></span> 
                    </div>
                </div><!-- form-group -->
                <div class="form-group">
                    <label class="col-sm-2 control-label required-hightlight"><?php echo __('From Email');?></label>
                    <div class="col-sm-6"> 
                            <input type="text" class="form-control" autocomplete="off" name="from_email" value="<?php echo $email_template->getData('from_email');?>" id="from_email">
                            <span class="help-block"><?php echo __('The email address this comes from');?></span>  
                    </div>
                </div><!-- form-group -->
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Reply to');?></label>
                    <div class="col-sm-6"> 
                            <input type="text" class="form-control" autocomplete="off" name="reply_to" value="<?php echo $email_template->getData('reply_to');?>" id="reply_to">
                            <span class="help-block"><?php echo __('The address most directly replies comes to. usually the same as the from email');?></span>  
                    </div>
                </div><!-- form-group -->
                 <div class="form-group">
                    <label class="col-sm-2 control-label required-hightlight"><?php echo __('Subject');?></label>
                    <div class="col-sm-6"> 
                            <textarea type="text" class="form-control" rows="7"  name="subject" id="subject"><?php echo strip_tags($email_template->getData('subject'));?></textarea>
                            <span class="help-block"><?php echo __('Subject line for this email');?></span>  
                    </div>
                </div><!-- form-group -->
            </div>
            <div class="tab-pane" id="user_social_info">
				
				<?php /* <div class="col-sm-4">
					<div class="form-group">
					<label class="control-label"><?php echo __('Select Place');?></label>
						<select name="company" style="width:100%" id="places"  class="form-control" data-placeholder="Choose One"  class="width300" onchange="return place_change(this.value);">
							<option value=""><?php echo __('Select Place');?></option>
							<?php foreach(array_keys($arr) as $value){ ?>
								<option value="<?php echo $value; ?>"><?php echo ucfirst($value); ?></option>
							<?php } ?>
						</select>
					</div>
				</div> 
				
				<div class="col-sm-4">
					<div class="form-group" id="place" >
							<label class="control-label"><?php echo __('Select Values');?></label>
								<select name="values" style="width:100%" class="form-control"  data-placeholder="Choose One"  class="width300">
									<option value=""><?php echo __('Select Place First');?></option>
								</select>
					</div>
				</div> */ ?>

                <div class="form-group"> 
			
                    <div class="col-sm-12"> 
                    		<label class="control-label required-hightlight"><?php echo __('Web Template');?></label>
                            <textarea type="text" class="" rows="7"  name="content" id="content"><?php echo $email_template->getData('content');?></textarea>  
                    </div>
                </div><!-- form-group -->
               <?php /* <div class="form-group"> 
			
                    <div class="col-sm-12"> 
                    		<label class="col-sm-4 control-label required-hightlight"><?php echo __('Mobile Template');?></label>
                    		<div class="col-sm-12">
                            <textarea type="text" style="width:100%;" class="" rows="7"  name="mobile_content" id="mobile_content"><?php echo $email_template->getData('mobile_content');?></textarea>  
                            </div>
                    </div>
                </div> */ ?>
            </div>

            <div class="panel-footer">
                <button class="btn btn-primary" type="submit"><?php echo __('Save');?></button>
                
                <button type="button" onclick="setLocation('<?php echo $this->getUrl("admin/template/email");?>')" class="btn btn-default"><?php echo __('Cancel');?></button>                
               
            </div>
        </div>
        </form>
    </div>
    </div>
</div>

<script type="text/javascript">
    $(window).load(function(){
        tinymce.init({
            menubar : false,statusbar : true,plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak code",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar1: "code | insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image preview | forecolor backcolor | fontsizeselect",
            height:'450px',
            selector: "textarea#content"
         });         

    });
    var variable_fields=<?php echo json_encode($arr); ?>;
    function place_change(place){
		if(place == ''){ var place = -1;  }
		if(place!=-1){
			var fileds = variable_fields[place];
			var html = '<div class="form-group"><label class="control-label"><?php echo __('Select Values');?></label><select name="values" style="width:100%" id="place_value" class="form-control" data-placeholder="Choose One"  class="width300">';
			$.each(fileds, function(k,v){

				html+='<option value='+k+'>'+v+'</option>';
				
			});
				html+='</select></div><div class="add_place"><button type="button" name="add_place" class="btn btn-primary"><?php echo __('Add');?></button></div>';
				$('#place').html(html);		
		}else {		
			var html='<div class="form-group" id="place" ><label class="control-label"><?php echo __('Select Values');?></label><select name="values" style="width:100%" class="form-control"  data-placeholder="Choose One"  class="width300"><option value=""><?php echo __('Select Place First');?></option></select></div>';
				$('#place').html(html);	
		}	

	}
	$(function() {
		$(".add_place" ).live( "click", function() {	
			var place = $('#places').val(); 
			var val = $('#place_value').val(); 
			var final_value= '$'+'{'+place+'.'+val+'}'; 
			tinymce.activeEditor.execCommand('mceInsertContent', false, final_value);
		});
	});

</script>
<script>
$(window).load(function(){	
	$('#email_form').preventDoubleSubmission();	
});
</script>
