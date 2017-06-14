<div class="tab-content tab-content-simple mb30">
<form method="post" action="<?php echo $this->getUrl('admin/contacts/addcontact',$this->getRequest()->query());?>" id="company_users" class="form-horizontal form-bordered">
                <div class="form-group">
                    <label class="col-sm-2 control-label required-hightlight"><?php echo __('Email');?></label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                            <input type="email" autofocus="on" name="email_address" class="form-control" >
                        </div>
                    </div>
                </div><!-- form-group -->
                
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Message');?></label>
                    <div class="col-sm-6">

                           <textarea maxlength="250" name="message" class="form-control" id="foo" ></textarea>

                    </div>
                </div><!-- form-group -->
<div class="clearfix"></div>
    <div class="panel-footer clearfix">
            <button class="btn btn-primary mr5" type="submit"><?php echo __('Save');?></button>
            <button class="btn btn-default mr5" type="button" onclick="setLocation('<?php echo $this->getUrl("admin/contacts/index");?>')" ><?php echo __('Cancel');?></button>
        </div>
</form>
</div>
<script>
$(window).load(function(){	
	$('form').preventDoubleSubmission();	
});
</script>
