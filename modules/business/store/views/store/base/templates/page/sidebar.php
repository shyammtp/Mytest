<!-- BEGIN MINI-PROFILE --> 
<?php 
$store_data = App::model('store/session');
$customer = $store_data->getCustomer(); 
$Insurance_Data = App::model('insurance',false)->load($store_data->getData('insurance_id'));
$profileimage = $customer->getProfileImageUrl();  ?>

<div class="media profile-left">
<a class="pull-left profile-thumb">
		<?php if($profileimage):?>
		<span class="sidebar-profile-thumb-circle" style="background-image:url('<?php echo $profileimage;?>')"></span>
		<!--<img class="img-circle" src="<?php echo $profileimage;?>" alt="" >-->
		<?php else:?>
		<img class="img-circle" src="<?php echo $this->getAssetsPathUrl('images/default_avatar_male.jpg');?>" alt="" >
		<?php endif;?>
	</a>
	<div class="media-body">
		<h4 class="media-heading"><?php echo $customer->getFirstName();?></h4>	  
	</div>
	<strong><?php echo $Insurance_Data->getInsuranceName();?>	</strong>
</div><!-- media -->

<h5 class="leftpanel-title"><?php echo __('Navigation');?></h5>
<ul class="nav nav-pills nav-stacked">
<?php echo $this->getMenuLevel($this->getMenuConfig());?> 

</ul>
<?php
$html = '';
$profileimage100 = $customer->getProfileImageUrl(100,100);
?>
<div id="switch-acc-content" style="display:none;">
	<?php if($customer->isOwner()):?>
	<div class="acc-hi">
		<?php echo $customer->getEntityName(App::instance()->getPlace()->getPlaceId());?>
	</div>
	<?php else:?>
	<div class="acc-md">
		<p><?php echo __('This account is managed by');?> <b><?php echo $customer->getEntityName(App::instance()->getPlace()->getPlaceId());?></b></p>
	</div>
	<?php endif;?>
	<div class="profile-info">
		<div class="row">
			<div class="col-sm-4">
				<div class="profile_picture">
				<?php if($profileimage):?>
					<img class="img-circle" src="<?php echo $profileimage100;?>" width="100" alt="">
				<?php else:?>
					<img class="img-circle" src="<?php echo $this->getAssetsPathUrl('images/default_avatar_male.jpg');?>"  width="100"  alt="" > 
				<?php endif;?>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="profile_cont">
					<h5><?php echo $customer->getFirstName();?></h5>
					<p><?php echo $customer->getPrimaryEmailAddress();?></p>
					<button class="btn btn-default btn-sm" onclick="setLocation('<?php echo $this->getUrl('admin/users/editprofile',array('id'=> $customer->getUserId()));?>')"><?php echo __('Edit Profile');?></button>
				</div>
			</div>
		</div> 
	</div>
	<div class="associated_stores">
		<ul>
			<?php echo $html;?>
		</ul>
	</div>
</div>
<script>
	$(function() {
		$('#switch-acc').popover({
			html : true,
			container:'body',
			title:'',
			template : '<div class="popover switch-acc-content" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
			content: function() {
				return $("#switch-acc-content").html();
			}
		});
		$('html').on('mouseup', function(e) {
			if(!$(e.target).closest('.popover').length) {
				$('.popover').each(function(){
					$(this.previousSibling).popover('hide');
				});
			}
		});
		$(document).on('click','.admin-accounts',function(){
			var ses = $(this).data('session');
			var conf = true;
			var type = (ses == '0') ? '_blank' : '';
			if (ses == 1) {
				conf = confirm("<?php echo __('This will overrides the current session. Are you sure?');?>");	
			}  
			if (conf) {
				OpenInNewTab($(this).data('url'),type);
			}
		});
		$(document).on('click','.role-accounts',function(){
			var ses = $(this).data('session');
			var conf = true;
			var type = (ses == 0) ? '_blank' : '';
			if (ses == 1) {
				conf = confirm("<?php echo __('This will overrides the current session. Are you sure?');?>");	
			} 
			if (conf) {
				OpenInNewTab($(this).data('url'),type);
			}
		})
	});
	function OpenInNewTab(url,typ) {
		if (!typ) {
			window.location.href=url;
		} else {
			var win = window.open(url, typ);
			win.focus();
		}
	  }
</script>
