<?php 
$contactDetails = $this->getUsers()->getContactDetails();
?>

<form class="form-horizontal tab-form" method="post" action="<?php echo $this->getUrl('users/saveprofile',$this->getRequest()->query());?>" id="user">
<input type="hidden" name="user_token" value="<?php echo $this->getUsers()->getData('user_token');?>" />
<div class="tab-content  tab-content-simple mb30 no-padding" >
	<div class="tab-pane active" id="user_info">
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo __('Social Title');?></label>
			<div class="col-sm-10">
				<select name="social_title" class="form-control">
					
					<option value="Mr." <?php echo $this->getUsers()->getData('social_title') == 'Mr.'? "selected":"";?>><?php echo __('Mr.');?></option>
					<option value="Mrs." <?php echo $this->getUsers()->getData('social_title') == 'Mrs.'? "selected":"";?>><?php echo __('Mrs.');?></option>
					<option value="Ms." <?php echo $this->getUsers()->getData('social_title') == 'Ms.'? "selected":"";?>><?php echo __('Ms.');?></option>
				</select>
			</div>
		</div><!-- form-group -->
		<?php echo $this->setElementAttrs(array('class'=>'form-control'))->render('first_name'); ?>

		<div class="form-group">
			<label class="col-sm-2 control-label required-hightlight"><?php echo __('Email');?></label>
			<div class="col-sm-6">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
					<input disabled type="email" name="primary_email_address" class="form-control" value="<?php echo $this->getUsers()->getData('primary_email_address');?>">
				</div>
			</div>
			<div class="col-sm-2">
				<span class="control-label"><?php echo __('Primary');?></span>
			</div>
		</div><!-- form-group -->

		<div class="form-group">
		   <label class="col-sm-2 control-label <?php if(!$this->getUsers()->getUserId()):?>required-hightlight<?php endif;?>"><?php echo __('Password');?></label>
		   <div class="col-sm-10">
			   <div class="input-group">
				   <input type="text" class="form-control" name="user_password" autocomplete="off" value="" placeholder="">
				   <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
			   </div><!-- input-group -->
			   <span class="help-text"><?php echo __('Password length must be between 5 to 32 characters');?></span>
		   </div>
	   </div><!-- form-group -->

		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo __('Mobile');?></label>
			<div class="col-sm-10">
			  <input type="text" name="mobile"  maxlength="200" placeholder="<?php echo __('Mobile');?>"  class="form-control" value="<?php echo $this->getUsers()->getMobile();?>" />
			  <span class="help-block">Add Phone number(s) in comma seperated. <br>For example: 9790110251,9005000500</span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo __('Gender');?></label>
			<div class="col-sm-10">
				<select name="gender" class="form-control">
					<option value="" ><?php echo __('Select Gender');?></option>
					<option value="M" <?php echo $this->getUsers()->getData('gender') == 'M'? "selected":"";?>><?php echo __('Male');?></option>
					<option value="F" <?php echo $this->getUsers()->getData('gender') == 'F'? "selected":"";?>><?php echo __('Female');?></option>
				</select>
			</div>
		</div>

		 <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo __('Date of birth');?></label>
			<div class="col-sm-3">
				<div class="input-group">
					<input type="text" class="form-control" name="date_of_birth" autocomplete="off" value="<?php echo date("m/d/Y",strtotime($this->getUsers()->getData('date_of_birth')));?>" placeholder="mm/dd/yyyy" id="datepicker" readonly>
					<span class="input-group-addon datepicker-trigger"><i class="glyphicon glyphicon-calendar" id="dob"></i></span>
				</div><!-- input-group -->
			</div>
		</div><!-- form-group -->



		<!-- form-group -->

		<?php echo $this->setElementAttrs(array('class'=>'form-control'))->render('identification_number'); ?>

		
		<?php echo $this->childView('countrycityarea',array('country_id'=> $this->getUsers()->getCountry(),'city_id'=> $this->getUsers()->getCity(),'area_id' => $this->getUsers()->getArea())); ?>
	
		
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo __('Profile Image');?></label>
			<div class="col-sm-6">
				<div class="input-group">
					<div id="container_image"></div>
				</div><!-- input-group -->
			</div>
		</div><!-- form-group -->
		
		<div class="form-group" style='display:none'>
                    <label class="col-sm-2 control-label"><?php echo __('Status');?></label>
                    <div class="col-sm-10">
                        <?php $checked = "";
                         if($this->getUsers()->getStatus()){ $checked = "checked=checked"; }?>
                        <input type="checkbox" class="toggle" name="status" data-size="small" <?php echo $checked;?> data-on-text="<?php echo __('Yes');?>" data-off-text="<?php echo __('No');?>" data-off-color="danger" data-on-color="success" style="visibility:hidden;" value="1" />
                    </div>
                </div>
                
                 <div class="form-group" style='display:none'>
                    <label class="col-sm-2 control-label"><?php echo __('Is Verified');?></label>
                    <div class="col-sm-10">
                        <?php $checked = "";
                         if($this->getUsers()->getIsVerified()){ $checked = "checked=checked"; }?>
                        <input type="checkbox" class="toggle" name="is_verified" data-size="small" <?php echo $checked;?> data-on-text="<?php echo __('Yes');?>" data-off-text="<?php echo __('No');?>" data-off-color="danger" data-on-color="success" style="visibility:hidden;" value="1" />
                    </div>
                </div>
		
		
	</div>
	
	<div class="panel-footer">
		<button class="btn btn-primary mr5" type="submit"><?php echo __('Submit');?></button>
		<?php if(!$this->getUsers()->getMode()):?>
		<button type="button" onclick="setLocation('<?php echo $this->getUrl("store/users/index");?>')" class="btn btn-default"><?php echo __('Cancel');?></button> 
		<?php endif;?>
	</div>
</div>
</form>




<?php $thumbimage = $this->getUsers()->getProfileImageUrl('w200','w200'); ?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
<script> 
    $(function(){
        
        $("#container_image").PictureCut({
			Extensions					  : ["jpg","png","gif","jpeg"],
            InputOfImageDirectory         : "image",
            PluginFolderOnServer          : "/assets/js/media/picturecut/",
            FolderOnServer                : "/uploads/user/profile/",
            EnableCrop                    : true,
            CropWindowStyle               : "Bootstrap",
            DefaultImageAttrs           :      {src:'<?php echo $thumbimage;?>'},
            InputOfImageDirectory : 'profile_image',
            MinimumWidthToResize: 350,
            MinimumHeightToResize : 350,
            ImageButtonCSS                :{'border' :'2px dashed rgb(204, 204, 204)','padding':'2px'},
            InputOfImageDirectoryAttr       :{value:'<?php echo $this->getUsers()->getProfileImage();?>'}
        });
    });

    

    $(window).load(function(){
        $('#user').preventDoubleSubmission();
        SD.Block.init({
                blocks : {
                    'additionalmobile':'<?php echo $this->getUrl('store/users/additionaldata',$this->getRequest()->query());?>',
                    'additionalemail': '<?php echo $this->getUrl('store/users/additionalemaildata',$this->getRequest()->query());?>',
                }
        });
        SD.Block.load('additionalmobile','additionalmobilenumbers');
        SD.Block.load('additionalemail','additionalemails');
        $('#mobile').popover({
            html : true,
            title: function() {
              return $("#popover-head").html();
            },
            content: function() {
              return $("#popover-content").html();
            },
            showCallback : function() {
                $(".add-mobile:not(:disabled)").on('click',this,addAdditionalMobile);
                $(".ame").html('');
            },
        });

        $('#addem').popover({
            html : true,
            title: function() {
              return $("#ademail-popover-head").html();
            },
            content: function() {
              return $("#ademail-popover-content").html();
            },
            showCallback : function() {
                $(".add-email:not(:disabled)").on('click',this,addAdditionalEmail);
                $(".aed").html('');
            },
        });

        $('#datepicker').datepicker({								
            yearRange: '<?php echo date("Y") - 100; ?>:<?php echo date("Y"); ?>',
            maxDate: new Date(),
            changeMonth: true,
            changeYear: true
        });
        
        $(".datepicker-trigger").on("click", function() {
			$("#datepicker").datepicker("show");
		});
               
        $("select[name='social_title']").change(function(){
            if ($(this).val() =='Mrs.' || $(this).val() =='Ms.') {
                $("select[name='gender']").val("F");
            }
            if ($(this).val() =='Mr.') {
                $("select[name='gender']").val("M");
            }
        });
        SD.Pinmap.init('resident_location');
    });
</script>

