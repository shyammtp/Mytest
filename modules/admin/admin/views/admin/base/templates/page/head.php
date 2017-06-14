<meta charset="utf-8" />
<title><?php echo $this->getTitle();?></title>
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" /> 
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<script>
    var assestspath = '<?php echo $this->getAssetsPath();?>';
    var baseUrl = '<?php echo App::getBaseUrl();?>';
</script>
<!-- BEGIN PLUGIN CSS -->
<?php if(App::getCurrentLang()->isRTL()):?>
    <?php echo $this->addThemeCss('css/style.default.rtl.css');?>
    <?php echo $this->addThemeCss('css/stylear-resp.css');?>
<?php else:?>
	<?php $color = App::getConfig('THEMES_COLOR',Model_Core_Place::ADMIN);?>
	<?php if($color):?>
    	<?php echo $this->addThemeCss('css/style.'.$color.'.css');?>
    <?php else:?>
    	<?php echo $this->addThemeCss('css/style.default.css');?>
    <?php endif;?>
    <?php echo $this->addThemeCss('css/style-resp.css');?>
<?php endif;?>
<?php echo $this->addThemeCss('css/select2.css');?>
<!-- END CORE CSS FRAMEWORK -->


<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<?php echo $this->getAdditionalCss();?>

<?php echo $this->addThemeJs('js/jquery-1.11.1.min.js');?>
<?php echo $this->addJs('translate.js');?>
<script>	
    var currentlanguage = '<?php echo App::getCurrentLanguageId();?>';
</script>
<?php echo $this->addJs('admin.js');?> 
<script> 
    var sitedefaulturls = <?php echo json_encode(App::model('core/website')->getDefaultWebsiteUrls());?>; 
    sitedata.FRONTEND = sitedefaulturls[2]; 
    sitedata.API = sitedefaulturls[3];
	$(function(){
		SD.Language.fieldchange(currentlanguage);
	});
	var geoserverurl = sitedata.FRONTEND+'geoserver/itsthere/';	
</script>
<?php echo $this->getAdditionalJs();?>
<!-- END PAGE LEVEL STYLES -->
<link rel="shortcut icon" href="favicon.ico" />
<script type="text/javascript">
$(document).ready(function () {
	$('input[type="text"]').blur(function() {
		var regex = /(<([^>]+)>)/ig;
		var body = $(this).val();		
		var result = body.replace(regex, "");
		$(this).val(result);
	});
	$("form").submit(function(){
		$('input[type="text"]').blur();
	})
	/*$('textarea').blur(function() {
		var regex = /(<([^>]+)>)/ig;
		var body = $(this).val();		
		var result = body.replace(regex, "");
		$(this).val(result);
	});*/
});	
</script>
