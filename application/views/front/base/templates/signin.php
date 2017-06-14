<!-- inner box Start -->
<div class="fixed_outer">
    <div class="fixed_inner">	
	<div class="full_white_box">
	    <div class="coln-6">
	    <div class="login_form">
		<div class="login_title">
		    <h2> <?php echo __('Log in'); ?></h2>
		 
		</div>
		<ul>
		<form method="post" id="login_form" class="tab-form attribute_form" action="<?php echo $this->getUrl('login/loginsave',$this->getRequest()->query());?>" accept-charset="UTF-8" enctype="multipart/form-data" > 
				<input type="hidden" name="return_url" value="<?php echo Request::detect_uri();?>" />
				<input type="hidden" name="return_query_param" value="<?php echo base64_encode(json_encode($this->getRequest()->query()));?>" />
		    <li>
			<label class="manditory"><?php echo __('User Email'); ?></label>
			<div class="login_fileds">
			    <input type="text" name="email" placeholder="<?php echo __('Enter your Email'); ?>" value= "<?php echo $this->getFormData('email'); ?>" />
			    <em><i><?php echo $this->getValidationErrors('email'); ?></i></em>
			</div>
		    </li>
		    <li>
			<label class="manditory"><?php echo __('Password'); ?></label>
			<div class="login_fileds">
			     <input type="Password" name="password" placeholder="<?php echo __('Enter your Password'); ?>" value= "<?php echo $this->getFormData('password'); ?>" />
			     <em><i><?php echo $this->getValidationErrors('password');  ?></i></em>
			</div>
		    </li>
		    <li>
			<label class="empty_label">&nbsp;</label>
			<div class="login_fileds">
			     <input type="checkbox" name="rememberme" id="checkbox_id" /> 
			     <label for="checkbox_id"><?php echo __('Remember me'); ?></label>
			</div>
		    </li>
		    <li>
			<label class="empty_label">&nbsp;</label>
			<div class="login_fileds">
			    <button class="btn btn-primary mr5"><?php echo __('Sign In');?></button>
			    
			    <a href="<?php echo $this->getUrl('login/forgetpassword');?>" title="" class="forget"><?php echo __('Forget Password'); ?> ?</a>
			</div>
		    </li>
		</form>
		</ul>
	    </div>    
	    </div>
	    
	</div>
    </div>
</div>
