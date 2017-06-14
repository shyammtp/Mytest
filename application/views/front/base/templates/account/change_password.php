<?php
$_user = $this->getUsers();
?>
<div class="general_form">
<form class="form-horizontal tab-form" method="post" accept-charset="UTF-8" enctype="multipart/form-data" action="<?php echo $this->getUrl('account/changepasswordupdate', $this->getRequest()->query()); ?>" id="doctor">
<input type='hidden' name='user_id' value="<?php echo $_user->getUserId(); ?>" >
<ul id="user_info">
	<li>
	<label class=""><?php echo __('Old Password'); ?></label>
	<div class="input_fileds">
		<input type="password" name="old_password"  maxlength="250" placeholder="<?php echo __('Old Password'); ?>"  class="form-control" value="" />
		<em><i><?php echo $this->getValidationErrors('old_password'); ?></i></em>
	</div>
	</li>
	<li>
	<label class=""><?php echo __('New Password'); ?></label>
	<div class="input_fileds">
		<input type="password" name="password"  maxlength="250" placeholder="<?php echo __('New Password'); ?>"  class="form-control" value="" />
		<em><i><?php echo $this->getValidationErrors('password'); ?></i></em>
	</div>
	</li>
	<li>
	<label class=""><?php echo __('Re-type Password'); ?></label>
	<div class="input_fileds">
		<input type="password" name="retype_pass"  maxlength="250" placeholder="<?php echo __('Re-type Password'); ?>"  class="form-control" value="" />
		<em><i><?php echo $this->getValidationErrors('retype_pass'); ?></i></em>
	</div>
	</li>
	<li>
	
	<label class="empty_label">&nbsp;</label>
	<div class="input_fileds">
		<button class="btn btn-primary mr5" type="submit"><?php echo __('Update'); ?></button>
	</div>
	</li>
</ul>
</form>
</div>
