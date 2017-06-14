<div class="contentpanel">					
	<div class="row">
	<div class="col-md-12">
<!-- Nav tabs -->
<ul class="nav nav-tabs"></ul>

	<form method="post" id="mail-form" class="form-horizontal tab-form" action="<?php echo $this->getUrl('admin/system/mailsend',$this->getRequest()->query());?>" accept-charset="UTF-8">
	<div class="tab-content mb30">

	<div class="tab-pane active" id="home3">
	<?php $customer = App::model('store/session')->getCustomer();?>
		<div class="form-group">
					<label class="col-sm-2 control-label required-hightlight"><?php echo __('To');?></label>
					<div class="col-sm-10">
						<div class="autocomplete-container">
                   <input type="hidden" name="user_id" id="" size="150" value="<?php echo $this->getUserId();?>"  />
                   <div id="tags_tagsinput" class="autocompleteinput">
                       <div id="tags_addTag">
                           <?php if($this->getUser()->getUserId()):?>
                              <span class="tag"><?php echo $this->getUser()->getPrimaryEmailAddress();?> <a href="javascript:;" data-id="<?php echo $this->getUser()->getUserId();?>">x</a></span>
                           <?php endif;?>
                           <?php if($this->_getMessageBlock()->getEmail()):?>
								<?php foreach($this->_getMessageBlock()->getEmail() as $key => $value) { ?>
									<span class="tag"><?php echo $value;?> <a href="javascript:;" data-id="<?php echo $key;?>">x</a></span>
								<?php } ?> 
								 <?php $userids = array_keys($this->_getMessageBlock()->getEmail()); ?>
								 <input type="hidden" name="user_id" id="" size="150" value="<?php echo implode(',',$userids);?>"  />
							   <?php endif;?>
                           <input type="text" autofocus="on" placeholder="<?php echo __('To');?>"  id="user_id" size="150"/>
                           <div class="tags_clear"></div>
                       </div>
                   </div>
                   <span class="help-block"><?php echo __('Type atleast 2 keyword to select a user');?></span>
               </div>						
					</div>
		</div>
		<div class="form-group">
					<label class="col-sm-2 control-label required-hightlight"><?php echo __('Subject');?></label>
					<div class="col-sm-10">
						<input maxlength="250" type="text" name="subject" id=""  placeholder="<?php echo __('Subject');?>" class="form-control" value="<?php echo $this->_getMessageBlock()->getSubject(); ?>" />
					</div>
		</div>
		<div class="form-group">
					<label class="col-sm-2 control-label required-hightlight"><?php echo __('Message');?></label>
					<div class="col-sm-10">
						<textarea type="text" class="" rows="7"  name="message" id="message"><?php echo $this->_getMessageBlock()->getMessage(); ?></textarea> 
					</div>
		</div>
		<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo __('Priority');?></label>
					<div class="col-sm-10">
						<select name="priority" style="width:100%" data-placeholder="Choose One"  class="no-changes form-control input-sm mb5 ">
								<option value="error" <?php echo ($this->_getMessageBlock()->getPriority() == 'error') ? 'selected' : ''; ?>><?php echo __('Error'); ?></option>
								<option value="urgent" <?php echo ($this->_getMessageBlock()->getPriority() == 'urgent') ? 'selected' : ''; ?>><?php echo __('Urgent'); ?></option>
								<option value="important" <?php echo ($this->_getMessageBlock()->getPriority() == 'important') ? 'selected' : ''; ?>><?php echo __('Important'); ?></option>
								<option value="normal" <?php echo ($this->_getMessageBlock()->getPriority() == 'normal') ? 'selected' : ''; ?>><?php echo __('Normal'); ?></option>
							</select>
					</div>
		</div>
		
        </div>
			<div class="panel-footer">
				<button class="btn btn-primary mr5"><i class="fa fa-send mr5"></i><?php echo __('Send');?></button>            
			</div>
        </div>
     </form>   
</div>
</div>
</div>
<script>
$(window).load(function(){
        tinymce.init({
            menubar : false,statusbar : true,plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak code",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar1: "code | insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image preview | forecolor backcolor",
            height:'250px',
            selector: "textarea#message"
         });

});
/*jQuery.validator.addMethod(
    "multiemail",
    function (value, element) {
        var email = value.split(/[,]+/); 
        valid = true;
        for (var i in email) {
            value = email[i];
            valid = valid && jQuery.validator.methods.email.call(this, $.trim(value), element);
        }
        return valid;
    },
    jQuery.validator.messages.multiemail
);
$('#mail-form').validate({
        rules: {
            to: {
                required: true,
                multiemail: true
            },            
        },
        messages: {
            to: {
                required: "Please enter email",
                multiemail: "Please enter valid email"
            },            
        },      
        
});*/
$(function() {
      SD.Autocomplete.setType('multiple').ajax('user_id','<?php echo $this->getUrl('admin/api/list',array('format'=> 'json','suppressResponseCodes' => 'true'));?>');
});
</script>
<style>
label[for=to] {
	color:#F97242;
}
</style>
<script>
$(window).load(function(){	
	$('form').preventDoubleSubmission();	
});
</script>
