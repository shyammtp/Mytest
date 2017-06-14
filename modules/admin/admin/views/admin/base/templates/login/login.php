<!-- BEGIN LOGO -->
<?php $return_url = $this->getRequest()->query('return_url');?>
<?php 
$session = App::model('admin_session');
$formdata = $session->getData('form-data'); 
?>
<section>
	<div class="panel panel-signin">

<div class="logo text-center" style="position: absolute;background: rgb(255, 255, 255);border: 1px solid rgb(238, 238, 238);padding: 10px;z-index: 999;margin: -26px;border-radius: 7px;">
				<img src="<?php echo App::getBaseUrl('uploads').App::getConfig('ADMIN_LOGO');?>" alt="Chain Logo" width="80" >
			</div>
		<div class="panel-body">

			<br />
			<p class="text-center"><?php echo __('Sign in to your account');?></p>

			<div class="mb30"></div>

			<form id="frm_login" method="post" class="animated fadeIn" action="<?php echo App::helper('admin')->getAdminUrl('admin/index/postlogin',$this->getRequest()->query());?>">
				<input type="hidden" name="return_url" value="<?php echo Request::detect_uri();?>" />
				<input type="hidden" name="return_query_param" value="<?php echo base64_encode(json_encode($this->getRequest()->query()));?>" />
 				<div class="input-group mb15">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo ($formdata) ? $formdata['email'] : '';?>">
				</div><!-- input-group -->
				<div class="input-group mb15">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input type="password" class="form-control" name="password" placeholder="Password" value="<?php echo ($formdata) ? $formdata['password'] : '';?>" >
				</div><!-- input-group -->

				<div class="clearfix">
					<div class="pull-left">
						<div class="ckbox ckbox-primary mt10">
							<input type="checkbox" name="rememberme" id="rememberMe" value="1">
							<label for="rememberMe"><?php echo __('Remember Me');?></label>
						</div>
					</div>
					<div class="pull-right">
						<button type="submit" class="btn btn-magenta"><?php echo __('Sign In');?> <i class="fa fa-angle-right ml5"></i></button>
					</div>

				</div>
			</form>
			<div class="pull-left trouble">
				<a href="<?php echo App::helper('admin')->getAdminUrl('admin/index/forgot');?>"><?php echo __('Trouble login?');?></a>
			</div>

		</div><!-- panel-body -->		
		<div class="panel-footer">
			<?php echo App::getConfig('COPYRIGHTS',Model_Core_Place::ADMIN);?>
		</div><!-- panel-footer -->
	</div><!-- panel -->

</section>
