<div class="fixed_outer">
    <div class="fixed_inner">	
	<div class="full_white_box">
	    
	    <div class="coln-6 ">
	    <div class="login_form">
		<div class="login_title">
		    <h2><?php echo __("Doctor's Sign Up"); ?></h2>
		    <p><?php echo __('Not a Doctor'); ?>? <a href="<?php echo $this->getUrl('signup');?>" title="Click Here"><?php echo __('Click Here'); ?></a></p>
		</div>
		<form method="post" id="login_form" class="tab-form attribute_form" action="<?php echo $this->getUrl('signup/save',$this->getRequest()->query());?>" accept-charset="UTF-8" enctype="multipart/form-data" >
		<input type="hidden" name='usertype' value='1'/> 
		<input type="hidden" name="return_url" value="<?php echo Request::detect_uri();?>" />
		<input type="hidden" name="return_query_param" value="<?php echo base64_encode(json_encode($this->getRequest()->query()));?>" />
		<ul>
		    <li>
			<label class="manditory"><?php echo __('Social Title'); ?></label>
			<div class="login_fileds">
			    <select name='title'>
					<option value = 'Dr.'>Dr.</option>
					<option value = 'Mr.'>Mr.</option>
					<option value = 'Mrs.'>Mrs.</option>
					<option value = 'Ms.'>Ms.</option>
			    </select>
			    <i><?php echo $this->getValidationErrors('title'); ?></i>
			</div>
		    </li>
		    <li>
			<label class="manditory"><?php echo __('User Name'); ?></label>
			<div class="login_fileds">
			    <input type="text" name='name' placeholder="<?php echo __('Your name'); ?>" />
			    <i><?php echo $this->getValidationErrors('name'); ?></i>
			</div>
		    </li>
		     <li>
			<label class="manditory"><?php echo __('Email'); ?></label>
			<div class="login_fileds">
			    <input type="text" name='email' placeholder="<?php echo __('Your email'); ?>" />
			    <i><?php echo $this->getValidationErrors('email'); ?></i>
			</div>
		    </li>
		    <li>
			<label class="manditory"><?php echo __('Password'); ?></label>
			<div class="login_fileds">
			     <input type="Password" name='password' placeholder="<?php echo __('Enter your password'); ?>" />
			     <i><?php echo $this->getValidationErrors('password'); ?></i>
			</div>
		    </li>
		     <li>
			<label class="manditory"><?php echo __('Mobile'); ?></label>
			<div class="login_fileds">
			     <input type="text" name='mobile' placeholder="<?php echo __('Enter your mobile number'); ?>" />
			     <i><?php echo $this->getValidationErrors('mobile'); ?></i>
			</div>
		    </li>
		    <li>
			<label class="empty_label">&nbsp;</label>
			<div class="login_fileds">
			    <input type="checkbox" name='agree'/><span class="terms_click"><?php echo __('By Creating an Account you agree to'); ?> <a href="#" title="Terms & conditions"><?php echo __('Terms & conditions'); ?></a></span>
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
	     <div class="coln-6">
		 <div class="login_right_box" style="margin-top:60px;">
		    <span class="login_right_image">
			<img src="/assets/front/base/images/doctor_icon.png" alt="Patient" />
		    </span>
		   
		</div>
	    </div>
	</div>
    </div>
</div>
