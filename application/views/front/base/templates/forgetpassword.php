<div class="fixed_outer">
    <div class="fixed_inner">	
	<div class="full_white_box">
	   <div class="coln-6">
	    <div class="login_form">
		<div class="login_title">
		    <h2> <?php echo __('Forgot Password'); ?></h2>
		 
		</div>
		<form method="post" id="forget_form" class="tab-form attribute_form" action="<?php echo $this->getUrl('login/forget',$this->getRequest()->query());?>" accept-charset="UTF-8" enctype="multipart/form-data" > 
		<ul>
		    <li>
			<label class="manditory"><?php echo __('User Email'); ?></label>
			<div class="login_fileds">
			    <input type="text" name='email' placeholder="<?php echo __('Enter your Email'); ?>"  value= "<?php echo $this->getFormData('email'); ?>"/>
			    <em><i><?php echo $this->getValidationErrors('email'); ?></i></em>
			</div>
		    </li>
		    <li>
			<label class="empty_label">&nbsp;</label>
			<div class="login_fileds">
			    <input type="submit" value=<?php echo __("Submit"); ?> />
			</div>
		    </li>
		</ul>
		</form> 
	    </div>    
	    </div>
	</div>
    </div>
</div>
	
