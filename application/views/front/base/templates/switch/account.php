<?php  if(App::model('user/session')->isLoggedIn()) { ?>
<?php $customer = App::model('user/session')->getCustomer(); 
$profileimage = $customer->getProfileImageUrl(80,80);  
$profileimage = ($profileimage) ? $profileimage : $this->getAssetsPathUrl('images/default_avatar_male.jpg'); ?>
<div id="switch-acc" data-placement="bottom" href="#"><label class="margr5"><?php echo App::model('user/session')->getCustomer()->getData('first_name'); ?></label><div class="img_outer widt30"><div class="img_inner"><img src="<?php echo $profileimage;?>" alt="" width="30" ></div></div></div>			
<?php
$html = '';
$placeinfoset = array();
$owner = $customer->getOwner($customer->getData('user_id'),false);
if($owner) {	
	$html .= '<ul>';
	$ownerplaceids = array_map(function($s){
		return $s['place_id'];
	},$owner->as_array());
	$placeinfoset = $customer->getPlaceInfoset(Arr::merge($ownerplaceids,array(App::instance()->getPlace()->getId()))); 
	foreach($owner as $owns) {
		$entityplace = Arr::get($placeinfoset,$owns['place_id'],new Kohana_Core_Object(array())); 
		$website = App::model('core/website')->getWebsitesById($owns['website_id']);
		$query = array();
		$same = 0; 
		
		//if(App::instance()->getWebsite()->getWebUrl() == $website->getWebUrl()) {
			//$query['destroy'] = 1;
			$same = 1;
 		//}
		$query['website_id'] = $owns['website_id'];
		$query['place_id'] = $owns['place_id'];		
		$query['auth_user'] = $customer->getUserToken();
		$url = $this->getUrl('user/AccountChooser/switch',$query);
		if($owns['place_id'] == App::instance()->getPlace()->getPlaceId()) {
			continue;
		}
		$image = '<i class="fa fa-building-o" style="font-size: 40px;"></i>';
		$placelogo = App::getConfig('STOREADMIN_LOGO',$owns['place_id']);
		if($placelogo!="" && file_exists(DOCROOT.$placelogo)) {
			 
			$image = '<img src="/'.$placelogo.'" width="40"/>';
		}
		$html .= '<li class="admin-accounts"  data-url="'.$url.'" data-session="'.$same.'"><div class="row">
					<div class="col-sm-4">
						<div class="place-pic">							
							'.$image.'
						</div>
					</div>
					<div class="col-sm-8">
						<h3>'.__('Administrator').'</h3>
						';
		if(isset($owns['place_id']) && $owns['place_id'] > 0) {

		   $html .= '<p>'.$entityplace->getPlaceName()."</p>";
		}
		$html .= '</div>
				</div></li>'; 
				 
	}

} else  {
	$placeinfoset = $customer->getPlaceInfoset(array(App::instance()->getPlace()->getId()));
	$entityplace = Arr::get($placeinfoset,App::instance()->getPlace()->getPlaceId(),new Kohana_Core_Object(array())); 
}
if($roleset = App::model('core/role')->getRolesForCustomer($customer->getUserId())) {	
	
	foreach($roleset as $roles) {
		if($roles['place_id'] == App::instance()->getPlace()->getPlaceId()) {
			continue;
		} 
		$website = App::model('core/website')->getWebsitesById($roles['website_id']);
		$query = array();
		$same = 0;
		if(App::instance()->getWebsite()->getWebUrl() == $website->getWebUrl()) {
			//$query['destroy'] = 1;
			$same = 1;
 		}
		$query['website_id'] = $roles['website_id'];
		$query['place_id'] = $roles['place_id'];
		$query['auth_user'] = $customer->getUserToken();
		
		$url = $this->getUrl('user/AccountChooser/switch',$query);
		$placelogo = '';
		if($query['place_id']) { 
			$placelogo = App::getConfig('STOREADMIN_LOGO',$query['place_id']);
		}
		if($query['place_id'] == Model_Core_Place::ADMIN) {
			$placelogo = App::getConfig('ADMIN_LOGO',$query['place_id']);
		}
		$image = '<i class="fa fa-building-o" style="font-size: 40px;"></i>';
		if($placelogo!="" && file_exists(DOCROOT.$placelogo)) {			 
			$image = '<img src="/'.$placelogo.'" width="40"/>';
		}
		$tagbgcolor =
		$tagtextcolor = '';
		if(isset($roles['tag_bg_color']) && $roles['tag_bg_color']) {
			$tagbgcolor = 'border-top-color:'.$roles['tag_bg_color'].";";
		}
		if(isset($roles['tag_text_color']) && $roles['tag_text_color']) {
			$tagtextcolor = 'color:'.$roles['tag_text_color'].";";
		}
		$html .= '<li class="role-accounts" data-url="'.$url.'" data-session="'.$same.'"><div class="row" style="'.$tagbgcolor.'">
							<div class="col-sm-4"><div class="place-pic">'.$image.'</div></div>
							<div class="col-sm-8">
								<h3>'.$roles['role_name'].'</h3>
								<p>'.$roles['place_name'].'</p>
							</div>
					</div></li>'; 
	}
}
	$html .= '</ul>';	
	$html .= '<a href="'.$this->getUrl('login/logout').'"><button class="btn btn-default btn-sm">'.__("Sign Out").'</button></a>';	
$profileimage100 = $customer->getProfileImageUrl(100,100);
?>

<div id="switch-acc-content" style="display:none;"> 
	<div class="profile-info">
		<div class="row">
			<div class="col-sm-4">
				<div class="profile_picture">
					<div class="img_outer widt100">
						<div class="img_inner">						
						<?php if($profileimage):?>
							<img class="" src="<?php echo $profileimage100;?>" width="100" alt="">
						<?php else:?>
							<img class="" src="<?php echo $this->getAssetsPathUrl('images/default_avatar_male.jpg');?>"  width="100"  alt="" > 
						<?php endif;?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="profile_cont">
					<h3><?php echo $customer->getFirstName();?></h3>
					<p><?php echo $customer->getPrimaryEmailAddress();?></p>
					<a href="<?php echo $this->getUrl('account/viewprofile',array('user'=> Encrypt::instance()->encode($customer->getUserId()), 'mode' => 'epf')).'#editprofile'; ?>" class="color_chan1 margb5 disp"><?php echo __('Edit'); ?></a>
					<button class="btn btn-default2 btn-sm" onclick="setLocation('<?php echo $this->getUrl('account/viewprofile',array('user'=> Encrypt::instance()->encode($customer->getUserId()), 'mode' => 'epf'));?>')"><?php echo __('View Profile');?></button>					
				</div>
			</div>
		</div> 
	</div>
	<div class="associated_stores">
			<?php echo $html;?>
	</div>
</div>

<script>
	$(function() {
		/*$('[data-toggle="popover"]').popover();
		$('#switch-acc').popover({
			html : true,
			container:'body',
			title:'',
			template : '<div class="popover switch-acc-content accont_proff" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
			content: function() {
				return $("#switch-acc-content").html();
			}
		});*/
		
		/*$('html').on('mouseup', function(e) {
			if(!$(e.target).closest('.popover').length) {
				$('.popover').each(function(){
					$(this.previousSibling).popover('hide');
				});
			}
		});*/
		$(document).on('click','.admin-accounts',function(){ 
			var ses = 0;
			var conf = true;
			var type = (ses == '0') ? '_blank' : ''; 
			if (conf) {
				OpenInNewTab($(this).data('url'),type);
			}
		});
		$(document).on('click','.role-accounts',function(){ 
			var ses = 0;
			var conf = true;
			var type = (ses == 0) ? '_blank' : ''; 
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
function setLocation(url)
{
   window.location = url;
}
</script>
<script type="text/javascript">
$(document).ready(function(){
    $("#switch-acc").click(function(){
        $(".switch-acc-content").toggle();
    }); 
});
$(document).on('click', function(e){
   if (! $(e.target).closest('.switch-acc-content').length &&  (! $(e.target).closest('#switch-acc').length))
       $('.switch-acc-content').hide();
});
</script>
<?php } else { ?>
<a href="javascript:;" class="proff sas" title="<?php echo __('Login');?>"><label><?php echo __('Login');?></label> </a>
<?php } ?>
