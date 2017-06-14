<div class="row">	
	<div class="col-md-12">
<!-- Nav tabs -->
<ul class="nav nav-tabs"></ul>
<form method="post" id="city_form" class="tab-form attribute_form" action="<?php echo $this->getUrl('admin/settings/savecity',$this->getRequest()->query());?>" accept-charset="UTF-8" enctype="multipart/form-data" >
<?php $this->loadFormErrors(); ?>
<input type="hidden" name="city_id" value="<?php echo $this->getRequest()->query('id');?>" />
	<div class="tab-content mb30">
	<div class="tab-pane active" id="home3">
		
		<div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('Country');?></label>
                <div class="col-sm-10">
						<select name="country_id" style="width:100%" id="select-basic" data-placeholder="Choose One" class="width300">
						<?php foreach($this->_getCountryInfo() as $countryid => $countryname):?>
						<option <?php echo $this->_getCity()->getCountryId()==$countryid ? "selected":"";?> value="<?php echo $countryid;?>"><?php echo ucfirst($countryname);?></option>
						<?php endforeach;?>
						</select>
                </div>
            </div>
		
		<?php echo $this->renderField('text',array('attribute_code' => 'city_name','is_required' => true,'label' => __('City'),'value' => $this->_getCity()->getCityName()));?>
		<?php /* <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo __('City');?></label>
			<div class="col-sm-10">
			  <input type="text" name="city_name"  maxlength="255" placeholder="<?php echo __('City');?>"  class="form-control" value="<?php echo $this->_getCity()->getCityName();?>" />
			</div>
		</div> */ ?>
		
		<div class="form-group">
		  <label  class="col-sm-2 control-label"><?php echo __('Status');?></label>
			<div class="col-sm-10">			 
			 <?php $checked = "checked"; if($this->getRequest()->query('id')){ 
				if($this->_getCity()->getCityStatus()){ $checked = "checked=checked"; } else { $checked = ""; } } ?>
			<input type="checkbox" class="toggle" name="city_status" data-size="small" <?php echo $checked;?> data-on-text="<?php echo __('Yes');?>" data-off-text="<?php echo __('No');?>" data-off-color="danger" data-on-color="success" style="visibility:hidden;" value="1" />
			</div>
		</div>    			 							
       </div>
		<div class="panel-footer">
		<button class="btn btn-primary mr5"><?php echo __('Save');?></button>
		<button class="btn btn-primary mr5" name="backto" value="1"><?php echo __('Save & Continue');?></button>
		<button type="reset" class="btn btn-default" onclick="setLocation('<?php echo $this->getUrl('admin/settings/citysettings');?>')"><?php echo __('Cancel');?></button>
		</div>
        </div>
</form>
</div></div>
<script>
$(window).load(function(){	
	$('#city_form').preventDoubleSubmission();	
});
</script>
