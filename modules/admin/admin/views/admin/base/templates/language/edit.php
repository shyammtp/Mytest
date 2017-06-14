<div class="row">
	<div class="col-md-12">
		<div class="alert alert-info">
            <h4><?php echo __('Info:');?></h4>
                <p>-  <strong><?php echo __('Red');?></strong> <?php echo __('highlighted label will be mandatory.');?></p>
            </div>
		<!-- Nav tabs -->
		<ul class="nav nav-tabs"></ul>
		<form method="post" class="form-horizontal tab-form" id="language_form" action="<?php echo $this->getUrl('admin/settings/savelanguage',$this->getRequest()->query());?>" accept-charset="UTF-8">
		<?php $this->loadFormErrors(); ?>
		<input type="hidden" name="language_id" value="<?php echo $this->getRequest()->query('id');?>" />
		<div class="tab-content mb30">
			<div class="tab-pane active" id="home3">
				<div class="form-group">
					<label class="col-sm-2 control-label required-hightlight"><?php echo __('Language Name');?></label>
					<div class="col-sm-10">
						<input type="text" name="language_name" id=""  placeholder="<?php echo __('Language Name');?>" class="form-control" value="<?php echo $this->_getLanguageSettings()->getName();?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label required-hightlight"><?php echo __('Language Code');?></label>
					<div class="col-sm-10">
						<input type="text" name="language_code" id=""  placeholder="<?php echo __('Language Code');?>" class="form-control" value="<?php echo $this->_getLanguageSettings()->getLanguageCode();?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo __('Date Format Short');?></label>
					<div class="col-sm-10">
						<input type="text" name="short_date_format" id=""  placeholder="<?php echo __('Date Format Short');?>" class="form-control" value="<?php echo $this->_getLanguageSettings()->getDateFormatShort();?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo __('Date Format Full');?></label>
					<div class="col-sm-10">
						<input type="text" name="full_date_format" id=""  placeholder="<?php echo __('Date Format Full');?>" class="form-control" value="<?php echo $this->_getLanguageSettings()->getDateFormatFull();?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo __('Is Rtl');?></label>
					<div class="col-sm-10">
						 <?php echo $checked = "";
						 if($this->_getLanguageSettings()->getIsRtl()){ $checked = "checked=checked"; }?>
						<input type="checkbox" class="toggle" name="rtl" data-size="small" <?php echo $checked;?> data-on-text="<?php echo __('Yes'); ?>" data-off-text="<?php echo __('No'); ?>" data-off-color="danger" data-on-color="success" value="1">
					</div>
				</div>

			<?php if($this->_getLanguageSettings()->getName() != 'English'){ ?>
				
				 <div class="form-group">
				  <label  class="col-sm-2 control-label"><?php echo __('Status');?></label>
				  <div class="col-sm-10">	
				   <?php echo $checked = "";
					 if($this->_getLanguageSettings()->getStatus()){ $checked = "checked=checked"; }?>
					<input type="checkbox" class="toggle" name="status" data-size="small" <?php echo $checked;?> data-on-text="<?php echo __('Yes'); ?>" data-off-text="<?php echo __('No'); ?>" data-off-color="danger" data-on-color="success" value="1">
				 </div>
				</div>
				 
			<?php }else{  ?>
			
				   <?php echo $checked = "";
					 if($this->_getLanguageSettings()->getStatus()){ $checked = "checked=checked"; }?>
					<input type="hidden"  name="status" data-size="small" <?php echo $checked;?> data-on-text="<?php echo __('Yes'); ?>" data-off-text="<?php echo __('No'); ?>" data-off-color="danger" data-on-color="success" value="1">
					
			<?php } ?>
        	
			<div class="panel-footer">
				<button class="btn btn-primary mr5"><?php echo __('Save');?></button>
				<button class="btn btn-primary mr5" name="backto" value="1"><?php echo __('Save & Continue');?></button>
				<button type="reset" class="btn btn-default" onclick="setLocation('<?php echo $this->getUrl('admin/settings/language_settings');?>')"><?php echo __('Cancel');?></button>
			</div>
		</div>
	    </form>
	</div>
</div>
<script>
$(window).load(function(){	
	$('#language_form').preventDoubleSubmission();	
});
</script>


