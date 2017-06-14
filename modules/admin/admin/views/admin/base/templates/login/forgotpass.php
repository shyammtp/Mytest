
 <!-- BEGIN LOGO -->
<?php $return_url = $this->getRequest()->query('return_url');?>
<section>
	<div class="panel panel-signin">

<div class="logo text-center" style="position: absolute;background: rgb(255, 255, 255);border: 1px solid rgb(238, 238, 238);padding: 10px;z-index: 999;margin: -26px;border-radius: 7px;">
				<img src="<?php echo App::getBaseUrl().App::getConfig('ADMIN_LOGO');;?>" alt="Chain Logo" width="80" >
			</div>
		<div class="panel-body">

			<br />
			<p class="text-center"><?php echo __('Forgot Password');?></p>
			  <p class="p-b-20 arrange-forget"><?php echo __('You will get your new password to your registered email.');?></p>

			<div class="mb30"></div>

			<form id="frm_forgot" method="post" class="animated fadeIn" action="<?php echo App::helper('admin')->getAdminUrl('admin/index/postforgotpassword');?>">  
			 			
			<input type="hidden" name="return_url" value="<?php echo Request::detect_uri();?>" />
				<div class="input-group mb15">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					 <input name="email" id="login_username" type="text"  class="form-control" placeholder="Email">
				</div><!-- input-group -->

<div class="pull-right">
                        <button type="submit" class="btn btn-primary btn-cons" id="login_toggle"><?php echo __('Submit');?></button>
                        <button type="button" class="btn btn-default btn-cons" id="login_toggle" onclick="setLocation('<?php echo App::helper('admin')->getAdminUrl('admin/index/login');?>')"><?php echo __('Cancel');?></button>
                      </div>
			</form>
		</div><!-- panel-body -->
		<div class="panel-footer">
			<?php echo App::getConfig('COPYRIGHTS',Model_Core_Place::ADMIN);?>
		</div><!-- panel-footer -->
	</div><!-- panel -->

</section>
