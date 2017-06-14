<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE JS FRAMEWORK-->
<?php echo $this->addThemeJs('js/plugins/bootstrap/bootstrap.min.js');?>
<?php echo $this->addThemeJs('js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js');?>
<?php echo $this->addThemeJs('js/plugins.js');?>
<?php echo $this->addThemeJs('js/actions.js');?> 
<!-- END CORE TEMPLATE JS -->
 

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<?php echo $this->getAdditionalJs();?>
<!-- END PAGE LEVEL SCRIPTS -->
<?php echo $this->childView();?>