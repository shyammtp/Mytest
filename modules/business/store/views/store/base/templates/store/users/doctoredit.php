<?php
$_user = $this->getUsers();
$contactDetails = $this->getUsers()->getContactDetails();
$mobileblock = $this->getRootBlock()->createBlock('Store/Users/Edit/Mobile');

$_department = $_user->getDepartments();

$session = App::model('store/session');


$_department_ids = array();
$filterdeps = array();
foreach($_department as $d) {
	$_department_ids[] = $d->getDepartmentId();
	$filterdeps[$d->getDepartmentId()] = array('id' => $d->getDepartmentId(), 'name' => $d->getDepartmentName());
}

$_doctor = $_user->getClinics(); 
$_doctor_ids = array();
$filterdocs = array();
foreach($_doctor as $d) {
	$_doctor_ids[] = $d->getClinicId();
	$filterdocs[$d->getClinicId()] = array('id' => $d->getClinicId(), 'name' => $d->getClinicName(),'text' => $d->getClinicTypeText());
}
 

?>
<?php if(!$this->getUsers()->getMode()):?>
<?php $saveac = 'users/save'; ?>
<?php else:?>
<?php $saveac = 'users/saveprofile'; ?>
<?php endif;?>
        <form class="form-horizontal tab-form" method="post" action="<?php echo $this->getUrl($saveac,$this->getRequest()->query());?>" id="user">
        <input type="hidden" name="user_token" value="<?php echo $this->getUsers()->getData('user_token');?>" />
        <div class="tab-content  tab-content-simple mb30 no-padding" >
            <div class="tab-pane active" id="user_info">
               <?php /* <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Social Title');?></label>
                    <div class="col-sm-10">
                        <select name="social_title" class="form-control">
                            <option value="Dr." <?php echo $this->getUsers()->getData('social_title') == 'Dr.'? "selected":"";?>><?php echo __('Dr.');?></option>
                            <option value="Mr." <?php echo $this->getUsers()->getData('social_title') == 'Mr.'? "selected":"";?>><?php echo __('Mr.');?></option>
                            <option value="Mrs." <?php echo $this->getUsers()->getData('social_title') == 'Mrs.'? "selected":"";?>><?php echo __('Mrs.');?></option>
                            <option value="Ms." <?php echo $this->getUsers()->getData('social_title') == 'Ms.'? "selected":"";?>><?php echo __('Ms.');?></option>
                        </select>
                    </div>
                </div><!-- form-group --> */ ?>
                <?php  echo $this->setElementAttrs(array('class'=>'form-control'))->render('first_name'); ?>
				
				<?php /*  <div class="form-group">
                    <label class="col-sm-2 control-label required-hightlight"><?php echo __('Email');?></label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                            <?php if($this->getRequest()->query('id')){ ?>
                            <input disabled  type="email"  class="form-control" value="<?php echo $this->getUsers()->getData('primary_email_address');?>">
                            <input type="hidden" name="primary_email_address" class="form-control" value="<?php echo $this->getUsers()->getData('primary_email_address');?>">
                            <?php }else{ ?>
							<input  type="email" name="primary_email_address" class="form-control" value="<?php echo $this->getUsers()->getData('primary_email_address');?>">
							<?php } ?>
                        </div>
                    </div>
                    
                </div><!-- form-group -->
				
				<div class="form-group">
                   <label class="col-sm-2 control-label <?php if(!$this->getUsers()->getUserId()):?>required-hightlight<?php endif;?>"><?php echo __('Password');?></label>
                   <div class="col-sm-4">
                       <div class="input-group">
                           <input type="password" class="form-control" name="user_password" autocomplete="off" value="" placeholder="">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                       </div><!-- input-group -->
                       <span class="help-text"><?php echo __('Password length must be between 5 to 32 characters');?></span>
                   </div>
               </div><!-- form-group -->
			   
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo __('Qualification');?></label>
					<div class="col-sm-10">
					  <input type="text" name="qualification"  maxlength="250" placeholder="<?php echo __('Qualification');?>"  class="form-control" value="<?php echo $this->getUsers()->getData('qualification');?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo __('Experience');?></label>
					<div class="col-sm-10">
					<div class="input-group">	
					  <input type="text" name="experience"  maxlength="250" placeholder="<?php echo __('Experience');?>"  class="form-control" value="<?php echo $this->getUsers()->getData("experience");?>" /><span class="input-group-addon"><i>Year(s)</i></span>
                    </div>
					  
					</div>
				</div>
			
				 <?php  echo $this->setElementAttrs(array('class'=>'form-control'))->render('about'); ?>
				 */	?>
				 
				  <?php  echo $this->setElementAttrs(array('class'=>'form-control'))->render('address'); ?>
				 
				<div class="form-group">
					<label class="col-sm-2"></label>
					<div class="col-sm-10">
						<div id="deparment_idlist" class="select2-container select2-container-multi category_id"></div>
					</div>
				</div>
				
				<div class="form-group">
						<label class="col-sm-2 control-label"><?php echo __("Department");?></label>
						<div class="col-sm-10">
							<input type="hidden" name="deparment_id" id="deparment_id" value="<?php echo implode(",",$_department_ids);?>" /> 
							<input type="text" id="associated-department-tree-departments-search" class="form-control" placeholder="Search..." autocomplete="off" spellcheck="false" dir="auto">		
																	
						</div> 
				</div>
				<?php /*
				<div class="form-group">
					<label class="col-sm-2"></label>
					<div class="col-sm-10">
						<div id="clinic_idlist" class="select2-container select2-container-multi category_id"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo __('Clinics / Hospital / Labs');?></label>
					<div class="col-sm-10">
						<input type="hidden" name="clinic_id" id="clinic_id" value="" /> 
						<input type="text" id="associated-clinics-tree-search" class="form-control" placeholder="Search..." autocomplete="off" spellcheck="false" dir="auto"> 
					</div>
				</div>
				*/ ?>
				<input type='hidden' name='insurance[]' value='<?php echo $session->getInsuranceId(); ?>'>
				
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo __('Mobile');?></label>
					<div class="col-sm-4">
					  <input type="text" name="mobile"  maxlength="200" placeholder="<?php echo __('Mobile');?>"  class="form-control" value="<?php echo $this->getUsers()->getData('mobile');?>" />
					  <span class="help-block">Add Phone number(s) in comma seperated. Give only 10 digits mobile number.<br>For example: 9790110251,9005000500</span>
					</div>
				</div>
				
				<input type="hidden" class="form-control" name="date_of_birth" autocomplete="off" value="<?php echo date("m/d/Y",strtotime($this->getUsers()->getData('date_of_birth')));?>" placeholder="mm/dd/yyyy" id="datepicker" readonly>
				
				<?php /*
                 <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Date of birth');?></label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="type" class="form-control" name="date_of_birth" autocomplete="off" value="<?php echo date("m/d/Y",strtotime($this->getUsers()->getData('date_of_birth')));?>" placeholder="mm/dd/yyyy" id="datepicker" readonly>
                            <span class="input-group-addon datepicker-trigger"><i class="glyphicon glyphicon-calendar" id="dob"></i></span>
                        </div><!-- input-group -->
                    </div>
                </div><!-- form-group -->
				
				<div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Profile Image');?></label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <div id="container_image"></div>
                        </div><!-- input-group -->
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Gender');?></label>
                    <div class="col-sm-2">
                        <select name="gender" class="form-control">
							<option value="" ><?php echo __('Select Gender');?></option>
                            <option value="M" <?php echo $this->getUsers()->getData('gender') == 'M'? "selected":"";?>><?php echo __('Male');?></option>
                            <option value="F" <?php echo $this->getUsers()->getData('gender') == 'F'? "selected":"";?>><?php echo __('Female');?></option>
                        </select>
                    </div>
                </div><!-- form-group -->
				*/ ?>
				<?php  echo $this->childView('countrycityarea',array('country_id'=> $this->getUsers()->getCountry(),'city_id'=> $this->getUsers()->getCity(),'area_id' => $this->getUsers()->getArea())); ?>
				
				
            
            <!-- form-group -->
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Status');?></label>
                    <div class="col-sm-10">
                        <?php $checked = "";
                         if($this->getUsers()->getStatus()){ $checked = "checked=checked"; }?>
                        <input type="checkbox" class="toggle" name="status" data-size="small" <?php echo $checked;?> data-on-text="<?php echo __('Yes');?>" data-off-text="<?php echo __('No');?>" data-off-color="danger" data-on-color="success" style="visibility:hidden;" value="1" />
                    </div>
                </div>
                
                 <div class="form-group" >
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
                <button type="button" onclick="setLocation('<?php echo $this->getUrl("users/index");?>')" class="btn btn-default"><?php echo __('Cancel');?></button>               
                
                <?php endif;?>
            </div>
        </div>
        </form>

<?php $thumbimage = $this->getUsers()->getProfileImageUrl('w400','w400'); ?> 
<script> 
    $(function(){
		$('#department').select2();
		$('#clinic').select2(); 
		$('#laboratory').select2();
		$('#insu-multi').select2();
        
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
    
    var filterdep = <?php echo $filterdeps ? json_encode($filterdeps) : '{}';?>, filterdepids = <?php echo json_encode($_department_ids);?>;
	<?php if(count($_department_ids)):?>
	addDeplist();
	<?php endif;?> 
    $('#associated-department-tree-departments-search').autocompletesingle({	  
		valueKey:'department_name',
		titleKey:'department_name',
		source:[{
			url:'<?php echo $this->getUrl("clinic/getdepartmentlists");?>&q=%QUERY%',	 
			type:'remote',
			getTitle:function(item){	 		
				return item['department_name']
			},
			getValue:function(item){ 
				return item['department_name']
			},	
			ajax:{
				//dataType : 'jsonp'	
			}
	}]}).on('selected.xdsoft',function(e,datum){		
			$(this).val('');
			filterdep[datum.department_id] = {'id' : datum.department_id, 'name' : datum.department_name};
			if (filterdepids.indexOf(datum.department_id) < 0) {
				filterdepids.push(datum.department_id);
			} 
			addDeplist();
	});
	
    function addDeplist()
    {
        var dlist = ' <ul class="select2-choices" style="border:none;">';
        var deparmentlists = '';
        var i = 0;
        $.each(filterdep,function(sd,gg){
           dlist += '<li class="select2-search-choice displ">    <span class="prom_nam">'+gg.name+'</span> <a class="select2-search-choice-close" tabindex="-1" data-id="'+gg.id+'"></a></li>';
        });
        
        dlist +='</div>';
        $("#deparment_id").val(filterdepids.join(','));
        //$("#product_reference_id").val(filterprdref.join(','));
        $("#deparment_idlist").html(dlist);
    }
    $(document.body).on('click','.select2-search-choice-close',function(){
        $(this).fadeOut('slow');
        var id = $(this).attr('data-id');
        if (filterdep.hasOwnProperty(id)) {
            delete filterdep[id];
        }
        var index = filterdepids.indexOf(id);
        if (index > -1) {
            filterdepids.splice(index, 1);
        }        
        addDeplist();
    });
	
	
	
	var filterdoc = <?php echo $filterdocs ? json_encode($filterdocs) : '{}';?>, filterdocpids = <?php echo json_encode($_doctor_ids);?>;
	<?php if(count($_doctor_ids)):?>
	addDoclist();
	<?php endif;?> 
    $('#associated-clinics-tree-search').autocompletesingle({	  
		valueKey:'clinic_name',
		titleKey:'clinic_name',
		source:[{
			url:'<?php echo $this->getUrl("users/getclinics");?>&q=%QUERY%',	 
			type:'remote',
			getTitle:function(item){	 		
				return item['clinic_name']
			},
			getValue:function(item){ 
				return item['clinic_name']
			}
	}]}).on('selected.xdsoft',function(e,datum){		
			$(this).val('');
			filterdoc[datum.clinic_id] = {'id' : datum.clinic_id, 'name' : datum.clinic_name,'text' : datum.clinic_text};
			if (filterdocpids.indexOf(datum.clinic_id) < 0) {
				filterdocpids.push(datum.clinic_id);
			} 
			addDoclist();
	});
	
    function addDoclist()
    {
        var dlist = ' <ul class="select2-choices" style="border:none;">';
        var deparmentlists = '';
        var i = 0;
        $.each(filterdoc,function(sd,gg){
           dlist += '<li class="select2-search-choice displ">    <span class="prom_nam">'+gg.name+' ('+gg.text+')'+'</span> <a class="select2-search-choice-close select2-search-doctorchoice-close" tabindex="-1" data-id="'+gg.id+'"></a></li>';
        });
        
        dlist +='</div>';
        $("#clinic_id").val(filterdocpids.join(',')); 
        $("#clinic_idlist").html(dlist);
    }
    $(document.body).on('click','.select2-search-doctorchoice-close',function(){
        $(this).fadeOut('slow');
        var id = $(this).attr('data-id');
        if (filterdoc.hasOwnProperty(id)) {
            delete filterdoc[id];
        }
        var index = filterdocpids.indexOf(id);
        if (index > -1) {
            filterdocpids.splice(index, 1);
        }        
        addDoclist();
    });
    
</script>

