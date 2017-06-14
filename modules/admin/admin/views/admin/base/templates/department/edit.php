<?php  //print "<pre>"; 
	//print_r($this->_getCity()->getLabel()); ?>
<div class="row">	
	<div class="col-md-12">
<!-- Nav tabs -->
<ul class="nav nav-tabs"></ul>
<form method="post" id="department_form" class="tab-form attribute_form" action="<?php echo $this->getUrl('admin/department/savedepartment',$this->getRequest()->query());?>" accept-charset="UTF-8" enctype="multipart/form-data" >
<?php $this->loadFormErrors(); ?>
<input type="hidden" name="department_id" value="<?php echo $this->getRequest()->query('id');?>" />
	<div class="tab-content mb30">
	<div class="tab-pane active" id="home3">
		
		<?php echo $this->renderField('text',array('attribute_code' => 'department_name','label' => __('Department Name'), 'field_length' => 255,'is_required' => true,'value' => $this->_getDepartment()->getDepartmentName()));?> 
		
		<?php echo $this->renderField('textarea',array('attribute_code' => 'description','label' => __('Description'), 'field_length' => 255,'value' => $this->_getDepartment()->getDescription()));?> 
		 
		
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo __('Department Type');?></label>
			<div class="col-sm-10">
			  <select name="department_type" class="form-control">
				<option value="1" <?php echo $this->_getDepartment()->getDepartmentType() == 1 ? "selected":"";?>><?php echo __('Doctors / Clinics / Hospital');?></option>
				<option value="2" <?php echo $this->_getDepartment()->getDepartmentType() == 2 ? "selected":"";?>><?php echo __('Labs');?></option>
			  </select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo __('Show on frontslide');?></label>
			<div class="col-sm-10">
			  <select name="show_frontend" class="form-control"> 
				<option value="0" <?php echo $this->_getDepartment()->getShowFrontend() == 0 ? "selected":"";?>><?php echo __('Hide');?></option>  
				<option value="1" <?php echo $this->_getDepartment()->getShowFrontend() == 1 ? "selected":"";?>><?php echo __('Show');?></option>
			  </select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo __('Icon');?></label>
			<div class="col-sm-10">
			  <input type="file" name="icon" />
			  <?php if($logo = $this->_getDepartment()->getIcon()):?>
			  <img src="<?php echo $logo;?>" />
			  <?php endif;?>
			  <span>(For better site appearence upload icon images)</span>
			</div>
			
		</div>
		
		<div class="form-group">
		  <label  class="col-sm-2 control-label"><?php echo __('Status');?></label>
			<div class="col-sm-10">			 
			 <?php $checked = "checked"; if($this->getRequest()->query('id')){ 
				if($this->_getDepartment()->getDepartmentStatus()){ $checked = "checked=checked"; } else { $checked = ""; } } ?>
			<input type="checkbox" class="toggle" name="department_status" data-size="small" <?php echo $checked;?> data-on-text="<?php echo __('Yes');?>" data-off-text="<?php echo __('No');?>" data-off-color="danger" data-on-color="success" style="visibility:hidden;" value="1" />
			</div>
		</div>    			 							
       </div>
		<div class="panel-footer">
		<button class="btn btn-primary mr5"><?php echo __('Save');?></button>
		<button class="btn btn-primary mr5" name="backto" value="1"><?php echo __('Save & Continue');?></button>
		<button type="reset" class="btn btn-default" onclick="setLocation('<?php echo $this->getUrl('admin/department/index');?>')"><?php echo __('Cancel');?></button>
		</div>
        </div>
</form>
</div></div>
<script>
$(window).load(function(){	
	$('#department_form').preventDoubleSubmission();	
});
</script>
