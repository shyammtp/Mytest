<!-- Nav tabs -->
<ul class="nav nav-tabs">
</ul>
<form method="post" class="form-horizontal tab-form" action="<?php echo App::helper('admin')->getAdminUrl('domain/list/savewebsite',array('tab' => 'website'));?>" id="website-form">
<?php $this->loadFormErrors(); ?>
<?php $query = Arr::merge(array('backto' => urlencode($this->getUrl('domain/list/edit',$this->getRequest()->query()))),$this->getRequest()->query());?>
<input type="hidden" name="website_id" value="<?php echo $this->getRequest()->query('id');?>" /> 
<?php echo Form::hidden('form_key', Security::token());?>
	     <div class="tab-content mb30 no-padding">
			<div class="tab-pane active" id="home3">
				
				 <div class="form-group">
				  <label class="col-sm-2 control-label"><?php echo __('Website Code');?></label>
					 <div class="col-sm-10">
					 <input type="text" class="form-control" name="web_index" value="<?php echo $this->_getWebsite()->getWebIndex();?>">
					 <span class="help"><?php echo __('e.g. Unique Code');?></span>
				   </div>
				 </div>
		 
				 <div class="form-group">
					<label class="col-sm-2 control-label"><?php echo __('Website Name');?></label> 
					<div class="col-sm-10">
					 <input type="text" class="form-control" name="name" value="<?php echo $this->_getWebsite()->getWebsiteName();?>">
				   </div>
				 </div>
		 
				 <div class="form-group">
				   <label class="col-sm-2 control-label"><?php echo __('Domain');?></label>
					<div class="col-sm-10">
					 <input type="text" class="form-control" name="web_url" value="<?php echo $this->_getWebsite()->getWebUrl();?>">
					 <span class="help"><?php echo __('e.g. "http://www.example.com/" - complete the url with "/" ');?></span>
				   </div>
				 </div>
				 
				<div class="form-group">
					<label  class="col-sm-2 control-label"><?php echo __('Status');?></label>					
					<div class="col-sm-10">
					<?php $checked ="";
					 if($this->_getWebsite()->getStatus()){ $checked = "checked=checked"; }?>
					<input type="checkbox" class="toggle" name="status" data-size="small" <?php echo $checked;?> data-on-text="<?php echo __('Yes');?>" data-off-text="<?php echo __('No');?>" data-off-color="danger" data-on-color="success" style="visibility:hidden;" value="1" />
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<button class="btn btn-primary mr5"><?php echo __('Save');?></button>
				<button class="btn btn-primary mr5" name="backto" value="1"><?php echo __('Save & Continue');?></button>
				<button type="reset" class="btn btn-default" onclick="setLocation('<?php echo $this->getUrl('domain/list/website');?>')"><?php echo __('Cancel');?></button>
			</div>
        </div>
</form>
<script>
$(window).load(function(){	
	$('form').preventDoubleSubmission();	
});
</script>
