<?php defined('SYSPATH') OR die('No direct script access.');
$_clinic = $this->_getClinic();
$_department = $_clinic->getDepartments();
$_insurancess = $_clinic->getInsurance();
$session = App::model('store/session');
$_insuranceids = array();
foreach($_insurancess as $d) {
	$_insuranceids[] = $d->getInsuranceId();
	 
}

$_department_ids = array();
$filterdeps = array();
foreach($_department as $d) {
	$_department_ids[] = $d->getDepartmentId();
	$filterdeps[$d->getDepartmentId()] = array('id' => $d->getDepartmentId(), 'name' => $d->getDepartmentName());
}
$_doctor = $_clinic->getDoctors(); 
$_doctor_ids = array();
$filterdocs = array();
foreach($_doctor as $d) {
	$_doctor_ids[] = $d->getUserId();
	$filterdocs[$d->getUserId()] = array('id' => $d->getUserId(), 'name' => $d->getFirstName());
}
$_insurance = $this->getInsurance(); 
?>
<div class="row">	
	<div class="col-md-12">
<!-- Nav tabs -->
<ul class="nav nav-tabs"></ul>
<form method="post" id="clinic_form" class="tab-form attribute_form" action="<?php echo $this->getUrl('clinic/saveclinic',$this->getRequest()->query());?>" accept-charset="UTF-8" enctype="multipart/form-data" > 
<input type="hidden" name="clinic_id" value="<?php echo $this->getRequest()->query('id');?>" />
<input type="hidden" name="type" value="<?php echo $this->getRequest()->query('type');?>" />
	<div class="tab-content mb30">
	<div class="tab-pane active" id="home3">
		
		<?php echo $this->setElementAttrs(array('class'=>'form-control','field_label' => App::registry('place_name').' '.__('Name')))->render('clinic_name'); ?>
		 <?php echo $this->setElementAttrs(array('class'=>'form-control'))->render('sub_text'); ?>
		 
		 
		
		<?php echo $this->childView('countrycityarea',array('country_id'=> $this->_getClinic()->getCountry(),'city_id'=> $this->_getClinic()->getCity(),'area_id' => $this->_getClinic()->getArea())); ?>
		
		<div class="form-group">
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo __('Address');?></label>
				<div class="col-sm-10"> 
						<textarea type="text" class="form-control" rows="7"  name="address" id="content"><?php echo $this->_getClinic()->getAddress();?></textarea>  
				</div>
			</div>
		</div>
		
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
		<input name="insurance[]" type='hidden' value ='<?php echo $session->getInsuranceId(); ?>'>
		<?php /*
		<div class="form-group">
			<label class="col-sm-2 control-label "><?php echo __("Insurance");?></label>
			<div class="col-sm-10">
			<select id="insu-multi" name="insurance[]" data-placeholder="Choose One" multiple class="width300">
				<?php foreach($_insurance as $in):?>
					
					<option value="<?php echo Arr::get($in,'insurance_id');?>" <?php echo (in_array(Arr::get($in,'insurance_id'),$_insuranceids))?"selected" :"" ;?>><?php echo Arr::get($in,'insurance_name');?></option>
				<?php endforeach;?>
			</select>
			</div> 
		</div>
		*/ ?>	 
		
		 <?php echo $this->setElementAttrs(array('class'=>'form-control'))->render('about'); ?>
		 
		
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo __('Phone number');?></label>
			<div class="col-sm-10">
			  <input type="text" name="phone"  maxlength="255" placeholder="<?php echo __('Phone number');?>"  class="form-control" value="<?php echo $this->_getClinic()->getPhone();?>" />
			  <span class="help-block">Add Phone number(s) in comma seperated. <br>For example: 9790110251,9005000500</span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2"></label>
			<div class="col-sm-10">
				<div id="doctor_idlist" class="select2-container select2-container-multi category_id"></div>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo __('Doctors');?></label>
			<div class="col-sm-10">
				<input type="hidden" name="doctor_id" id="doctor_id" value="" /> 
				<input type="text" id="associated-doctor-tree-search" class="form-control" placeholder="Search..." autocomplete="off" spellcheck="false" dir="auto"> 
			</div>
		</div>
		
		<div class="form-group">
			<?php  if($this->_getClinic()->isLabs()):?>
				<label class="col-sm-2 control-label"><?php echo __('Tests');?></label>
			<?php else:?>
				<label class="col-sm-2 control-label"><?php echo __('Services');?></label>
			<?php endif;?>
			<div class="col-sm-10">
				<input name="services" id="servicetags" class="form-control" value="<?php echo $this->_getClinic()->getServices();?>" />
			</div>
		</div><!-- form-group -->
		 
		
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo __('Facilities');?></label>
			<div class="col-sm-10">
				<input name="facilities" id="facilitytags" class="form-control" value="<?php echo $this->_getClinic()->getFacilities();?>" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo __('Tags');?></label>
			<div class="col-sm-10">
				<input name="tags" id="tags" class="form-control" value="<?php echo $this->_getClinic()->getTags();?>" />
			</div>
		</div>
		
		<div class="form-group">
		  <label  class="col-sm-2 control-label"><?php echo __('Status');?></label>
			<div class="col-sm-10">			 
			 <?php $checked = "checked"; if($this->getRequest()->query('id')){ 
				if($this->_getClinic()->getClinicStatus()){ $checked = "checked=checked"; } else { $checked = ""; } } ?>
			<input type="checkbox" class="toggle" name="clinic_status" data-size="small" <?php echo $checked;?> data-on-text="<?php echo __('Yes');?>" data-off-text="<?php echo __('No');?>" data-off-color="danger" data-on-color="success" style="visibility:hidden;" value="1" />
			</div>
		</div>    			 							
       </div>
		<div class="panel-footer">
		<button class="btn btn-primary mr5"><?php echo __('Save');?></button>
		<button class="btn btn-primary mr5" name="backto" value="1"><?php echo __('Save & Continue');?></button>
		<button type="reset" class="btn btn-default" onclick="setLocation('<?php echo $this->getUrl('clinic/index',$this->getRequest()->query());?>')"><?php echo __('Cancel');?></button>
		</div>
        </div>
</form>
</div></div>
<script>
	$(document).ready(function(){
		$('#insu-multi').select2(); 
	});
	$(window).load(function(){	
		$('#clinic_form').preventDoubleSubmission();
		jQuery('#servicetags').tagsInput({width:'auto',defaultText : '<?php echo $this->_getClinic()->isLabs() ? "Add Tests":"Add Services";?>'});
		jQuery('#facilitytags').tagsInput({width:'auto',defaultText : 'Add Facilities'});
		jQuery('#tags').tagsInput({width:'auto',defaultText : 'Tags'});
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
    $('#associated-doctor-tree-search').autocompletesingle({	  
		valueKey:'doctor_name',
		titleKey:'doctor_name',
		source:[{
			url:'<?php echo $this->getUrl("clinic/getdoctors");?>&q=%QUERY%',	 
			type:'remote',
			getTitle:function(item){	 		
				return item['doctor_name']
			},
			getValue:function(item){ 
				return item['doctor_name']
			}
	}]}).on('selected.xdsoft',function(e,datum){		
			$(this).val('');
			filterdoc[datum.doctor_id] = {'id' : datum.doctor_id, 'name' : datum.doctor_name};
			if (filterdocpids.indexOf(datum.doctor_id) < 0) {
				filterdocpids.push(datum.doctor_id);
			} 
			addDoclist();
	});
	
    function addDoclist()
    {
        var dlist = ' <ul class="select2-choices" style="border:none;">';
        var deparmentlists = '';
        var i = 0;
        $.each(filterdoc,function(sd,gg){
           dlist += '<li class="select2-search-choice displ">    <span class="prom_nam">'+gg.name+'</span> <a class="select2-search-choice-close select2-search-doctorchoice-close" tabindex="-1" data-id="'+gg.id+'"></a></li>';
        });
        
        dlist +='</div>';
        $("#doctor_id").val(filterdocpids.join(',')); 
        $("#doctor_idlist").html(dlist);
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
