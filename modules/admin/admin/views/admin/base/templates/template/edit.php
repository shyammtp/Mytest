<?php
$email_template = $this->getEmailTemplate(); 
?>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs nav-tabs-simple">
            <li class="active"><a href="#user_info" data-toggle="tab"><strong><?php echo __("From Information");?></strong></a></li>
            <li><a href="#user_social_info" data-toggle="tab"><strong><?php echo __("HTML Content");?></strong></a></li> 
        </ul>
        <form class="form-horizontal tab-form" id="template-form" method="post" action="<?php echo $this->getUrl('admin/template/save',$this->getRequest()->query());?>"> 
        <div class="tab-content  tab-content-simple mb30 no-padding" >
            <div class="tab-pane active" id="user_info">
                <div class="form-group">
                    <label class="col-sm-2 control-label red-highlight"><?php echo __('Reference Name');?></label>
                    <div class="col-sm-6"> 
                            <input type="text" class="form-control" autocomplete="off" name="ref_name" value="<?php echo $email_template->getData('ref_name');?>" id="reference_name">
                            <span class="help-block"><?php echo __('A unique name for this template. This for internal use.');?></span> 
                    </div>
                </div><!-- form-group -->
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('From Name');?></label>
                    <div class="col-sm-6"> 
                            <input type="text" class="form-control" autocomplete="off" name="from_name" value="<?php echo $email_template->getData('from');?>" id="from_name">
                            <span class="help-block"><?php echo __('The name this emails comes from (Eg: Bill smith, Rocky)');?></span> 
                    </div>
                </div><!-- form-group -->
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('From Email');?></label>
                    <div class="col-sm-6"> 
                            <input type="text" class="form-control" autocomplete="off" name="from_email" value="<?php echo $email_template->getData('from_email');?>" id="from_email">
                            <span class="help-block"><?php echo __('The email address this comes from');?></span>  
                    </div>
                </div><!-- form-group -->
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Reply to');?></label>
                    <div class="col-sm-6"> 
                            <input type="text" class="form-control" autocomplete="off" name="reply_to" value="<?php echo $email_template->getData('reply_to');?>" id="reply_to">
                            <span class="help-block"><?php echo __('The address most directly replies comes to. usually the same as the from email');?></span>  
                    </div>
                </div><!-- form-group -->
                 <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Subject');?></label>
                    <div class="col-sm-6"> 
                            <textarea type="text" class="form-control" rows="7"  name="subject" id="subject"><?php echo $email_template->getData('subject');?></textarea>
                            <span class="help-block"><?php echo __('Subject line for this email');?></span>  
                    </div>
                </div><!-- form-group -->
            </div>
            <div class="tab-pane" id="user_social_info">
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Content');?></label>
                    <div class="col-sm-6"> 
                            <textarea type="text" class="form-control" rows="7"  name="subject" id="content"><?php echo $email_template->getData('content');?></textarea>  
                    </div>
                </div><!-- form-group -->
            </div>

            <div class="panel-footer">
                <button class="btn btn-primary mr5" type="submit"><?php echo __('Submit');?></button>
                <?php /* if(!$this->getTemplate()->getMode()):?>
                <button type="button" onclick="setLocation('<?php echo $this->getUrl("admin/users/index");?>')" class="btn btn-default"><?php echo __('Cancel');?></button>               
                <button type="reset" class="btn btn-default"><?php echo __('Reset');?></button>
                <?php endif; */?>
            </div>
        </div>
        </form>

    </div>
</div>
<script>
$(window).load(function(){	
	$('#template-form').preventDoubleSubmission();	
});
</script>
