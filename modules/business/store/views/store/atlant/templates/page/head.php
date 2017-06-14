<meta charset="utf-8" />
<title><?php echo $this->getTitle();?></title>
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<script>
    var assestspath = '<?php echo $this->getAssetsPath();?>';
    var baseUrl = '<?php echo App::getBaseUrl();?>';
</script>
<!-- BEGIN PLUGIN CSS -->
<!-- BEGIN PLUGIN CSS -->
<?php $theme = App::getConfig('THEMES_COLOR',App::instance()->getPlace()->getId());?>

<?php echo $theme ? $this->addThemeCss('css/'.$theme) : $this->addThemeCss('css/theme-default.css') ;?>
<!-- END CORE CSS FRAMEWORK -->


<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<?php //echo $this->getAdditionalCss();?>

<script>	
    var currentlanguage = '<?php echo App::getCurrentLanguageId();?>';
</script>
<?php echo $this->addThemeJs('js/plugins/jquery/jquery.min.js');?>
<?php echo $this->addJs('translate.js');?>
<?php echo $this->addJs('admin.js');?>
<script> 
    var sitedefaulturls = <?php echo json_encode(App::model('core/website')->getDefaultWebsiteUrls());?>; 
    sitedata.FRONTEND = sitedefaulturls[2]; 
    sitedata.API = sitedefaulturls[3];
	$(function(){
		SD.Language.fieldchange(currentlanguage);
	});
</script>

<?php echo $this->getAdditionalJs();?>
<!-- END PAGE LEVEL STYLES -->
<link rel="shortcut icon" href="favicon.ico" />
