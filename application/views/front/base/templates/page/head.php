<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<title><?php echo $this->getTitle();?></title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta content="<?php echo $this->getMetaDescription();?>" name="description" />
<meta content="<?php echo $this->getMetaKeywords();?>" name="keywords" />
<?php $enviroment = '';
if(isset($_SERVER['KOHANA_ENV'])) {
	$enviroment = $_SERVER['KOHANA_ENV'];
} ?>
<meta data-pt="<?php echo $this->_getThemePath();?>" data-en="<?php echo $enviroment;?>" id="metapt" />

<?php echo $this->addThemeCss('css/bootstrap.min.css');?>
<?php echo $this->addThemeCss('css/font-awesome.min.css');?>

<?php if(App::getCurrentLang()->isRTL()):?>
<?php echo $this->addThemeCss('css/style_rtl.css');?>
<?php echo $this->addThemeCss('css/responsive_ar.css');?>
<?php else:?>
<?php echo $this->addThemeCss('css/style.css');?>
<?php echo $this->addThemeCss('css/responsive_en.css');?> 
<?php endif;?>

<?php  echo $this->addThemeJs('js/new/jquery-1.11.2.js');?>
<?php  echo $this->addThemeJs('js/bootstrap.js');?>
<?php  echo $this->addThemeJs('js/new/owl.carousel.js');?>


<?php echo $this->addThemeCss('css/cus.css');?> 
<?php  
	if(App::model('user/session')->isLoggedIn()) { 
		$customer = App::model('user/session')->getCustomer(); 
		$sessionid = $customer->getData('user_id');
		$usertoken = $customer->getData('user_token');
		$username = $customer->getData('first_name');		
	}
?> 
<script> 
    var sitedefaulturls = <?php echo json_encode(App::model('core/website')->getDefaultWebsiteUrls()); ?>;
    var sitedata = {};
    sitedata.FRONTEND = sitedefaulturls[2]; 
    sitedata.API = sitedefaulturls[3];
    sitedata.LANGUAGE = '<?php echo App::getCurrentLanguageId(); ?>';
<?php if (App::model('user/session')->isLoggedIn()) { ?>    		
    	var usertoken = '<?php echo $usertoken; ?>';		
    	var username  = '<?php echo $username; ?>';
    	sitedata.ISLOGGEDIN = true;
<?php } else { ?>		
    	    var usertoken = '';
    	    var username  = '';
    	    sitedata.ISLOGGEDIN = false;
<?php } ?>	  
  
function goToByScroll(id){ 
   $('html,body').stop().animate({scrollTop: $("#"+id).offset().top - $("#nav").height() },'500');
}
</script>

<style>
	.cancelfileinputclass i {color:white!important;margin-right: 3px;}
	.custom-drop {border-top-right-radius: 0px;border-top-left-radius: 0;border-bottom-right-radius: 0;}
</style>
<?php  echo $this->addThemeJs('js/site.js');?>
<?php echo $this->getAdditionalJs();?> 
<?php echo $this->getAdditionalCss(); ?>
