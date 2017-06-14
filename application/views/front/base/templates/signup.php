<?php 
$session = App::model('user/session'); 
?>
<div class="fixed_outer">
    <div class="fixed_inner">	
	<div class="full_white_box">
	    <div class="coln-6 ">
	    <div class="login_form">
		<div class="login_title">
		    <h2><?php echo __('Sign Up'); ?></h2>
		    <?php /*<p><?php echo __('Are you a Doctor'); ?>? <a href="<?php echo $this->getUrl('signup/doctor');?>" title="Click Here"><?php echo __('Click Here'); ?></a></p> */ ?>
		</div>
		<form method="post" id="login_form" class="tab-form attribute_form" action="<?php echo $this->getUrl('signup/save',$this->getRequest()->query());?>" accept-charset="UTF-8" enctype="multipart/form-data" >
		<input type="hidden" name='usertype' value='2'/>
		<input type="hidden" name="return_url" value="<?php echo Request::detect_uri();?>" />
		<input type="hidden" name="return_query_param" value="<?php echo base64_encode(json_encode($this->getRequest()->query()));?>" />
		<ul>
		    <li>
			<label class="manditory"><?php echo __('Name'); ?></label>
			<div class="login_fileds">
			    <input type="text" name='first_name' value="<?php echo $this->getFormData('first_name');?>" placeholder="<?php echo __('Enter your name'); ?>" />
			    <em><i><?php echo $this->getValidationErrors('first_name'); ?></i></em>

			</div>
		    </li>
		     <li>
			<label class="manditory"><?php echo __('Email'); ?></label>
			<div class="login_fileds">
			    <input type="text" name='email' value="<?php echo $this->getFormData('email');?>"  placeholder="<?php echo __('Enter your email'); ?>" />
			    <em><i><?php echo $this->getValidationErrors('email'); ?></i></em>
			</div>
		    </li>
		    <li>
			<label class="manditory"><?php echo __('Password'); ?></label>
			<div class="login_fileds">
			     <input type="Password" name='password' placeholder="<?php echo __('Enter your password'); ?>" />
			     <em><i><?php echo $this->getValidationErrors('password'); ?></i></em>
			</div>
		    </li>
		     <li>
			<label class="manditory"><?php echo __('Mobile'); ?></label>
			<div class="login_fileds">
			     <input type="text" name='mobile' value="<?php echo $this->getFormData('mobile');?>"  placeholder="<?php echo __('Enter your mobile number'); ?>" />
			     <em><i><?php echo $this->getValidationErrors('mobile'); ?></i></em>
			</div>
		    </li>
		    <li>
			<label class="empty_label">&nbsp;</label>
			<div class="login_fileds">
			    <input type="checkbox" name='agree' checked /><span class="terms_click">
					<?php echo __('By creating an Account you agree to'); ?> 
					<a href="<?php echo $this->getUrl('terms'); ?>" title="<?php echo __('Terms & conditions'); ?>"><?php echo __('Terms & conditions'); ?></a></span>
					<em><i><?php echo $this->getValidationErrors('agree'); ?></i></em>
			</div>
		    </li>
		    <li>
			<label class="empty_label">&nbsp;</label>
			<div class="login_fileds">
			    <button class="btn btn-primary mr5"><?php echo __('Sign Up');?></button>		   
			</div>
		    </li>
		    
		</ul>
		</form>
	    </div>    
	    </div>
	    <?php if($session->getData('session_form_data')): ?>
	    <div class="coln-6 signup_right">
			<form method="post" id="login_form" class="tab-form attribute_form" action="<?php echo $this->getUrl('signup/resendEmail',$this->getRequest()->query());?>" accept-charset="UTF-8" enctype="multipart/form-data" >
			    <h2><?php echo __("Confirmation email for registration has been sent to your mail. In case you din't receive any confirmation email, click to the below button to resend the confirmation email."); ?></h2>
			    <button ><?php echo __('Resend');?></button>	
			</form>
		</div>
		<?php endif; ?>
	</div>
    </div>
</div>
