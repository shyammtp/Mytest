<div class="row">
	<div class="col-md-12">
		<div class="alert alert-info">
            <h4><?php echo __('Info:');?></h4>
                <p>-  <strong><?php echo __('Red');?></strong> <?php echo __('highlighted label will be mandatory.');?></p>
            </div>
            <?php $templates = $this->_getTemplates(); ?> 
            <?php $subjecttype = $this->_getSubjectTypes(); ?> 
<!-- Nav tabs -->
<ul class="nav nav-tabs">
</ul>
<form method="post" id="banner_form" class="form-horizontal tab-form" action="<?php echo $this->getUrl('admin/settings/savesubject',$this->getRequest()->query());?>" accept-charset="UTF-8" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php echo $this->getRequest()->query('id');?>" />

        <div class="tab-content mb30 no-padding">
        <div class="tab-pane active" id="home3">
			
			<?php /* ?><div class="form-group">
			<label class="col-sm-2 control-label required-hightlight"><?php echo __('Subject Title');?></label>
			 <div class="col-sm-10">	
				<?php $i = 0; foreach($this->getLanguage() as $langid => $language):?>
				  <div class="input-group translatable_field language-<?php echo $langid;?>" <?php if($i > 0):?>style="display: none;"<?php endif;?>>                       
						<input type="text" maxlength="90" class="form-control"   name="subject[<?php echo $langid;?>]" id="suffix_<?php echo $langid;?>"  placeholder="<?php echo __('Subject Title (:language)',array(':language'=> $language->getName()));?>" class="form-control"  value="<?php echo $this->_getSubjectSettings()->getLabel('subject',$langid);?>" />
						<div class="input-group-btn">
							<button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><?php echo $language->getName();?> <span class="caret"></span></button>
							<ul class="dropdown-menu pull-right">
								<?php foreach($this->getLanguage() as $sublangid => $sublanguage):?>
									<li><a href="javascript:SD.Language.fieldchange(<?php echo $sublangid;?>)"> <?php echo $sublanguage->getName();?></a></li>
								<?php endforeach;?>
							</ul>
						</div>
					</div>
					<?php $i++; endforeach;?>																
					</div>
			</div>
			<?php */ ?>
			
            
            <div class="form-group">
                <label class="col-sm-2 control-label required-hightlight"><?php echo __('Subject Type');?></label>
                <div class="col-sm-10">
					<select class="width300 select2-offscreen" id="subject_type" style="width:100%" name="subject_type">		
						<option value="">Choose Subject Type</option>
						<?php foreach($subjecttype as $key => $value) { ?>
							<option value="<?php echo $key.'|'.$value; ?>" <?php echo ($this->_getSubjectSettings()->getData('subject_type') == $key) ? "selected='selected'" : ''; ?>><?php echo __($value); ?></option>
						<?php } ?>
					</select>	                 
                </div>
            </div>
            
			                                   
            <div class="form-group">
                <label class="col-sm-2 control-label required-hightlight"><?php echo __('Template Type');?></label>
                <div class="col-sm-10">
				<select class="width300 select2-offscreen" id="template_id" style="width:100%" name="template_id">		
					<option value="">Choose Template Type</option>			
					<?php foreach($templates as $template) { ?>						
						<option value="<?php echo $template['template_id']; ?>" <?php echo ($this->_getSubjectSettings()->getTemplateId() == $template['template_id']) ? "selected='selected'" : ''; ?>><?php echo __($template['ref_name']); ?></option>
					<?php } ?>					
				</select>			                  
                </div>
            </div>
        <div class="form-group">		
			<label  class="col-sm-2 control-label required-hightlight"><?php echo __('Color Code');?></label>
			<div class="col-sm-10">
				<input type="text" name="color_code" class="form-control colorpicker-input" placeholder="#000000" id="colorpicker3" value="<?php echo $this->_getSubjectSettings()->getColorCode();?>" />
				<div class="clearfix"></div><br />
				<span id="colorpickerholder"></span>
			</div>        
        </div> 
           <div class="form-group">
				<label  class="col-sm-2 control-label"><?php echo __('Status');?></label>
			<div class="col-sm-10">
			<?php $checked = "";
			 if($this->_getSubjectSettings()->getStatus()){ $checked = "checked=checked"; }?>
				<input type="checkbox" class="toggle" name="status" data-size="small" <?php echo $checked;?> data-on-text="<?php echo __('Yes');?>" data-off-text="<?php echo __('No');?>" data-off-color="danger" data-on-color="success" style="visibility:hidden;" value="1" />
			</div>
		</div>
		

		<div class="panel-footer ">
            <button class="btn btn-primary mr5"><?php echo __('Save');?></button>
            <button class="btn btn-primary mr5" name="backto" value="1"><?php echo __('Save & Continue');?></button>
            <button type="reset" class="btn btn-default"   onclick="setLocation('<?php echo $this->getUrl('admin/settings/email_subject');?>')" ><?php echo __('Cancel');?></button>
        </div>
        </div>
</form>
</div></div>
<script>
$(window).load(function(){	
	$('#banner_form').preventDoubleSubmission();	
	$("#subject_type").select2();
	$("#template_id").select2();
	jQuery('#colorpickerholder').ColorPicker({
                    flat: true,
                    onChange: function (hsb, hex, rgb) {
			jQuery('#colorpicker3').val('#'+hex);
                    }
                });

});
</script>
