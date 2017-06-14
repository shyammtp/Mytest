
<?php $key = $this->getRequest()->query('key'); ?>
<div class="fixed_outer">
    <div class="fixed_inner">	
	<div class="full_white_box">
	   <div class="coln-6">
	    <div class="login_form">
		<div class="login_title">
		    <h2> <?php echo __('Reset Password'); ?></h2>
		 
		</div>
		<form  method="post" id="resetpasswordform">
		<ul>
		    <li>
			<label for="password" class="manditory"><?php echo __('Password'); ?></label>
			<div class="login_fileds">
			    <input type="password" name="password" id="password" class="form-control" required placeholder="<?php echo __('Enter new password');?>"/>
			</div>
		    </li>
		    <li>
			<label for="password" class="manditory"><?php echo __('Confirm Password'); ?></label>
			<div class="login_fileds">
			    <input type="password" name="confirm_password" class="form-control" placeholder="<?php echo __('Re type new password');?>" id="cpassword" required />
			</div>
		    </li>
		    <li>
			<label for="password" class="manditory"><?php echo __('Verification Code'); ?></label>
			<div class="login_fileds">
			    <input type="text" name="verification_code" class="form-control" placeholder="<?php echo __('Enter your verification code');?>" id="code" required />
			</div>
		    </li>
		    <li>
			<label class="empty_label">&nbsp;</label>
			<div class="login_fileds">
			    <input type="hidden" name="key" value="<?php echo $key; ?>" />	
				<button type="button" id="reset_passwordform" class="btn btn-default"><?php echo __('Submit');?></button>
			</div>
		    </li>
		</ul>
		</form> 
	    </div>    
	    </div>
	</div>
    </div>
</div>
	




<script>
$(function() {
	$( "#reset_passwordform" ).click(function( event ) {
		$.ajax({
			url: "<?php echo $this->getUrl('account/savepassword'); ?>",
			type: "post",
			data: $("#resetpasswordform" ).serialize(),
			dataType:"json",
			success: function(d) {
			var html="";
			$('.error').html('');
				if(d.error){	
					$.each(d.error,function(k,v){
						if(k=='password'){
							$('#password').after('<span class="error">'+v+'</span>');
						}
						if(k=='confirm_password'){
							$('#cpassword').after('<span class="error">'+v+'</span>');
						}
						if(k=='verification_code'){
							$('#code').after('<span class="error">'+v+'</span>');
						}
						if(k=='code'){
							$('#code').after('<span class="error">'+v+'</span>');
						}
					});
				}
				if(d.success){
					//require(['NotificationFX'],function(n){ n.notify(d.success,'success').show(); })
					$('#resetpasswordform').trigger("reset");
					window.location = '<?php echo $this->getUrl(); ?>';
					return true;
				}
			
			}
		});
	});
});
</script> 
