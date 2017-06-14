<?php  //print "<pre>"; 
	//print_r($this->_getCity()->getLabel()); ?>
<div class="row">	
	<div class="col-md-12">
<!-- Nav tabs -->
<ul class="nav nav-tabs"></ul>
<form method="post" id="country_form" class="tab-form attribute_form" action="<?php echo $this->getUrl('admin/settings/savecountry',$this->getRequest()->query());?>" accept-charset="UTF-8" enctype="multipart/form-data" >
<?php $this->loadFormErrors(); ?>
<input type="hidden" name="country_id" value="<?php echo $this->getRequest()->query('id');?>" />
	<div class="tab-content mb30">
	<div class="tab-pane active" id="home3">
		
		<?php echo $this->renderField('text',array('attribute_code' => 'country_name','is_required' => true,'label' => __('Country'),'value' => $this->_getCountry()->getCountryName()));?>
		<?php /* <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo __('Country');?></label>
			<div class="col-sm-10">
			  <input type="text" name="country_name"  maxlength="255" placeholder="<?php echo __('Country');?>"  class="form-control" value="<?php echo $this->_getCountry()->getCountryName();?>" />
			</div>
		</div> */?>
		
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo __('Country Code');?></label>
			<div class="col-sm-10">
			  <input type="text" name="country_code"  maxlength="255" placeholder="<?php echo __('Country Code');?>"  class="form-control" value="<?php echo $this->_getCountry()->getCountryCode();?>" />
			</div>
		</div>
		
		<div class="form-group">
		  <label  class="col-sm-2 control-label"><?php echo __('Status');?></label>
			<div class="col-sm-10">			 
			 <?php $checked = "checked"; if($this->getRequest()->query('id')){ 
				if($this->_getCountry()->getCountryStatus()){ $checked = "checked=checked"; } else { $checked = ""; } } ?>
			<input type="checkbox" class="toggle" name="country_status" data-size="small" <?php echo $checked;?> data-on-text="<?php echo __('Yes');?>" data-off-text="<?php echo __('No');?>" data-off-color="danger" data-on-color="success" style="visibility:hidden;" value="1" />
			</div>
		</div>    			 							
       </div>
		<div class="panel-footer">
		<button class="btn btn-primary mr5"><?php echo __('Save');?></button>
		<button class="btn btn-primary mr5" name="backto" value="1"><?php echo __('Save & Continue');?></button>
		<button type="reset" class="btn btn-default" onclick="setLocation('<?php echo $this->getUrl('admin/settings/countrysettings');?>')"><?php echo __('Cancel');?></button>
		</div>
        </div>
</form>
</div></div>
<script>
$(window).load(function(){	
	$('#country_form').preventDoubleSubmission();	
});
</script>
