<!-- BEGIN LOGO -->
 
<?php $return_url = $this->getRequest()->query('return_url');
$rolemodel = $this->getRoleModel();
$pass = Encrypt::instance()->decode($this->getRequest()->query('_tir')); 
?> 
<?php 
$session = App::model('store_session');
$formdata = $session->getData('form-data'); 
?>
<section>
	<div class="panel panel-signin">

		<div class="panel-body"> 
				<?php if($panel = $this->getSwitchAccountDatas()->getPanel()): $place = App::model('core/place',false)->load($panel);  ?>
					<?php if($imagesrc = App::helper('image')->getResizeImage('w200',App::getConfig('STOREADMIN_LOGO',$place->getPlaceId())) ):?>
						<div class="logo text-center">
							<img src="<?php echo $imagesrc;?>" alt="<?php echo $place->getPlaceInfo($place->getPlaceId())->getPlaceName();?>" />
						</div>
					<?php else:?>
						<div class="text-center">
							<?php echo __('Welcome to');?>&nbsp;<?php echo $place->getPlaceInfo($place->getPlaceId())->getPlaceName();?>
						</div>
					<?php endif;?>
				<?php endif;?>  
			<br />
			<p class="text-center">
				<?php if($rolemodel):?>
					<?php echo __('Choose your place');?> 					
				<?php else:?>
					<?php echo __('Sign in to your account');?>
				<?php endif;?> 
			</p>

			<div class="mb30"></div>

			<form id="frm_login" method="post" class="animated fadeIn" action="<?php echo App::helper('url')->getUrl('admin/index/postlogin',$this->getRequest()->query());?>">
				<input type="hidden" name="return_url" value="<?php echo Request::detect_uri();?>" />
				<?php  if($rolemodel):   ?>
				<input type="hidden" class="form-control" name="email" value="<?php echo $rolemodel->getCustomer()->getPrimaryEmailAddress();?>">
				<div class="mb15">
					<select name="panel" class="form-control">
						<?php  foreach($rolemodel->getAdminPlaces() as $placeid => $placename):?>
							<option value="<?php echo $placeid;?>"><?php echo $placename;?></option>
						<?php endforeach;?>
					</select>
				</div> 
				<?php else:?>
					<div class="input-group mb15">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input type="text" class="form-control" name="email" placeholder="<?php echo __('Email');?>" <?php if($this->getSwitchAccountDatas()->getEmail()):?>readonly="readonly"<?php endif;?> value="<?php echo ($this->getSwitchAccountDatas()->getEmail() == '') ? Arr::get($formdata,'email') : $this->getSwitchAccountDatas()->getEmail();?>">
						<?php if($panel = $this->getSwitchAccountDatas()->getPanel()):  ?>
							<input type="hidden" name="panel" value="<?php echo $this->getSwitchAccountDatas()->getPanel();?>" />
						<?php endif;?>
					</div><!-- input-group -->
				<?php endif;?>
				<?php if(!$pass):?>
				<div class="input-group mb15">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input type="password" class="form-control" name="password" value="<?php echo ($this->getSwitchAccountDatas()->getEmail() == '') ? Arr::get($formdata,'password') : Encrypt::instance()->decode($this->getRequest()->query('_tir'));?>" placeholder=<?php echo __("Password"); ?> >
				</div><!-- input-group -->
				<?php else:?>
					<input type="hidden" class="form-control" name="password" value="<?php echo $pass;?>" placeholder="<?php echo __('Password');?>" >
				<?php endif;?>

				<div class="clearfix">
					<?php /*<div class="pull-left">
						<div class="ckbox ckbox-primary mt10">
							<input type="checkbox" name="rememberme" id="rememberMe" value="1">
							<label for="rememberMe"><?php echo __('Remember Me');?></label>
						</div>
					</div> */ ?>
					<div class="pull-right">
						<button type="submit" class="btn btn-magenta"><?php echo __('Sign In');?> <i class="fa fa-angle-right ml5"></i></button>
					</div>

				</div>
			</form>
			<?php /*<div class="row">
					<a href="<?php echo $this->getUrl('admin/index/forgot');?>"><?php echo __('Trouble login in?');?></a>
			</div> */ ?>

		</div><!-- panel-body -->
		<div class="panel-footer">
			<?php echo App::getConfig('COPYRIGHTS',Model_Core_Place::ADMIN);?>
		</div><!-- panel-footer -->
	</div><!-- panel -->

</section>
