<div class="row">
	<div class="col-md-12">
		<div class="alert alert-info">
            <h4><?php echo __('Info:');?></h4>
                <p>-  <strong><?php echo __('Red');?></strong> <?php echo __('highlighted label will be mandatory.');?></p>
            </div>
<!-- Nav tabs -->
<ul class="nav nav-tabs">
</ul>
<form method="post" id="banner_form" class="form-horizontal tab-form" action="<?php echo $this->getUrl('admin/settings/savebanner',$this->getRequest()->query());?>" accept-charset="UTF-8" enctype="multipart/form-data">
<input type="hidden" name="banner_setting_id" value="<?php echo $this->getRequest()->query('id');?>" />

        <div class="tab-content mb30 no-padding">
        <div class="tab-pane active" id="home3">
			<?php echo $this->renderField('text',array('field_length' => 60, 'attribute_code' => 'banner_title','is_required' => true, 'label' => __('Main Title'),'value' => $this->_getBannerSettings()->getBannerTitle()));?>
			 
            <?php echo $this->renderField('text',array('field_length' => 60, 'attribute_code' => 'banner_subtitle', 'label' => __('Subtitle'),'value' => $this->_getBannerSettings()->getBannerSubtitle()));?>
			  
            
			<div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('Image');?></label>
                <div class="col-sm-10">
                  <input type="file" name="banner_image"  maxlength="255" placeholder="<?php echo __('Image');?>"  class="" value="" />
               <?php if($this->getRequest()->query('id')) { ?>   
					<?php if($this->_getBannerSettings()->getBannerImage()) { ?>               
						<div class="row media-manager" style="margin-top:10px;">
							<div class="col-xs-6 col-sm-4 col-md-3 image">
							  <div class="thmb">                 
									<div class="thmb-prev" style="height: auto; overflow: hidden;">
									  <a href="<?php echo App::getBaseUrl('uploads').$this->_getBannerSettings()->getBannerImage();?>" target="_blank">
										<img src="<?php echo App::getBaseUrl('uploads').$this->_getBannerSettings()->getBannerImage();?>" class="img-responsive" alt="">
									  </a>
									</div>                      
							  </div>
							</div>
						</div>
					<?php } ?>
			 <?php } ?>
				
			</div>	
         </div>                                                                                                                                                                                                      
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('Link');?></label>
                <div class="col-sm-10">
                  <input type="text" name="banner_link"  maxlength="255" placeholder="<?php echo __('Link');?>"  class="form-control" value="<?php echo $this->_getBannerSettings()->getBannerLink();?>" />
                </div>
            </div>
           <?php if($this->getRequest()->query('id') == 1){?> 
			
				<input type="hidden" name="status" value="1" />
				
			<?php }else{ ?>
				
				<div class="form-group">
						<label  class="col-sm-2 control-label"><?php echo __('Status');?></label>
					<div class="col-sm-10">
					<?php $checked = "";
					 if($this->_getBannerSettings()->getStatus()){ $checked = "checked=checked"; }?>
						<input type="checkbox" class="toggle" name="status" data-size="small" <?php echo $checked;?> data-on-text="<?php echo __('Yes');?>" data-off-text="<?php echo __('No');?>" data-off-color="danger" data-on-color="success" style="visibility:hidden;" value="1" />
					</div>
				</div>
			<?php } ?>
        </div>

		<div class="panel-footer ">
            <button class="btn btn-primary mr5"><?php echo __('Save');?></button>
            <button class="btn btn-primary mr5" name="backto" value="1"><?php echo __('Save & Continue');?></button>
            <button type="reset" class="btn btn-default"   onclick="setLocation('<?php echo $this->getUrl('admin/settings/banner_settings');?>')" ><?php echo __('Cancel');?></button>
        </div>
        </div>
</form>
</div></div>
<script>
$(window).load(function(){	
	$('#banner_form').preventDoubleSubmission();	
});
</script>
