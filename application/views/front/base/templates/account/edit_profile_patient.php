<?php
$_user = $this->getUsers();
?>
<div class="general_form">
    <form class="form-horizontal tab-form" method="post" accept-charset="UTF-8" enctype="multipart/form-data" action="<?php echo $this->getUrl('account/updatePatient', $this->getRequest()->query()); ?>" id="patient">
	<input type="hidden" name="user_token" value="<?php echo $this->getUsers()->getData('user_token'); ?>" />
	<input type="hidden" name="user_id" value='<?php echo $this->getUsers()->getUserId(); ?>'>
	<ul>
		<li>
		<label class=""><?php echo __('Profile Image'); ?></label>
		<div class="input_fileds">
		    <div id="container_image"></div>
		</div>
	    </li>
	    <li>
		<label class=""><?php echo __('Name'); ?></label>
		<div class="input_fileds">
			
			<?php if(App::getCurrentLanguageId() == 1){   ?>
			
		    <input type="text" name="first_name[1]"  maxlength="200" placeholder="<?php echo __('Name'); ?>"  class="form-control" value="<?php echo $this->getUsers()->getFirstName(1); ?>" />
		    <input type="hidden" name="first_name[2]"  maxlength="200" placeholder="<?php echo __('Name'); ?>"  class="form-control" value="<?php echo $this->getUsers()->getFirstName(2); ?>" />
		    
		   <?php }else{ ?>
			   
			<input type="hidden" name="first_name[1]"  maxlength="200" placeholder="<?php echo __('Name'); ?>"  class="form-control" value="<?php echo $this->getUsers()->getFirstName(1); ?>" />
		    <input type="text" name="first_name[2]"  maxlength="200" placeholder="<?php echo __('Name'); ?>"  class="form-control" value="<?php echo $this->getUsers()->getFirstName(2)?$this->getUsers()->getFirstName(2):$this->getUsers()->getFirstName(1); ?>" />
			   
			<?php } ?> 
			
		    <em><i><?php echo $this->getValidationErrors('first_name'); ?></i></em>
		</div>
		
	    </li>
	    <li>
		<label class=""><?php echo __('Mobile'); ?></label>
		<div class="input_fileds">
		    <input type="text" name="mobile"  maxlength="200" placeholder="<?php echo __('Mobile'); ?>"  class="form-control" value="<?php echo $this->getUsers()->getData('mobile'); ?>" />
		    <em><i><?php echo $this->getValidationErrors('mobile'); ?></i></em>
		</div>
		
	    </li>
	    <li>
		<label class=""><?php echo __('Date of birth'); ?></label>
		<div class="input_fileds">
		    <input type="text" class="form-control" name="date_of_birth" autocomplete="off" value="<?php echo date("m/d/Y", strtotime($this->getUsers()->getData('date_of_birth'))); ?>" placeholder="mm/dd/yyyy" id="datepicker" readonly>
		    <em><i><?php echo $this->getValidationErrors('date_of_birth'); ?></i></em>
		</div>
	    </li>
	    <li>
		<label class=""><?php echo __('Gender'); ?></label>
		<div class="input_fileds">
		    <select name="gender" class="form-control">
			<option value="" ><?php echo __('Select Gender'); ?></option>
			<option value="M" <?php echo $this->getUsers()->getData('gender') == 'M' ? "selected" : ""; ?>><?php echo __('Male'); ?></option>
			<option value="F" <?php echo $this->getUsers()->getData('gender') == 'F' ? "selected" : ""; ?>><?php echo __('Female'); ?></option>
		    </select>
		</div>
	    </li>
	    <li>
		<?php echo $this->childView('countrycityarea', array('country_id' => $this->getUsers()->getCountry(), 'city_id' => $this->getUsers()->getCity(), 'area_id' => $this->getUsers()->getArea())); ?>
	    </li>
	    
	    <li>
		<label class="empty_label">&nbsp;</label>
		<div class="input_fileds">
		    <button class="btn btn-primary mr5"><?php echo __('Update'); ?></button>	
		</div>
	    </li>	    
	</ul>

    </form>
</div>


<?php $thumbimage = $this->getUsers()->getProfileImageUrl('w400', 'w400'); ?> 
<script> 
    $(function(){
		
        $("#container_image").PictureCut({
	    Extensions					  : ["jpg","png","gif","jpeg"],
            InputOfImageDirectory         : "image",
            PluginFolderOnServer          : "/assets/js/media/picturecut/",
            FolderOnServer                : "/uploads/user/profile/",
            EnableCrop                    : true,
            CropWindowStyle               : "Bootstrap",
            DefaultImageAttrs           :      {src:'<?php echo $thumbimage; ?>'},
            InputOfImageDirectory : 'profile_image',
            MinimumWidthToResize: 350,
            MinimumHeightToResize : 350,
            ImageButtonCSS                :{'border' :'2px dashed rgb(204, 204, 204)','padding':'2px'},
            InputOfImageDirectoryAttr       :{value:'<?php echo $this->getUsers()->getProfileImage(); ?>'}
        });
    });
    
    

    $(window).load(function(){
        //$('#user').preventDoubleSubmission();


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
    });
    
    
    
</script>

