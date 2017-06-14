<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE JS FRAMEWORK-->
<?php echo $this->addThemeJs('js/jquery-migrate-1.2.1.min.js');?>
<?php echo $this->addThemeJs('js/bootstrap.min.js');?>
<?php echo $this->addThemeJs('js/modernizr.min.js');?>
<?php echo $this->addThemeJs('js/pace.min.js');?>
<?php echo $this->addThemeJs('js/retina.min.js');?>
<?php echo $this->addThemeJs('js/jquery.cookies.js');?>
<!-- END CORE TEMPLATE JS -->


<?php echo $this->addThemeJs('js/flot/jquery.flot.min.js');?>
<?php echo $this->addThemeJs('js/flot/jquery.flot.min.js');?>
<?php echo $this->addThemeJs('js/flot/jquery.flot.resize.min.js');?>
<?php echo $this->addThemeJs('js/flot/jquery.flot.spline.min.js');?>
<?php echo $this->addThemeJs('js/jquery.sparkline.min.js');?>
<?php echo $this->addThemeJs('js/morris.min.js');?>
<?php echo $this->addThemeJs('js/raphael-2.1.0.min.js');?>
<?php echo $this->addThemeJs('js/bootstrap-wizard.min.js');?>
<?php echo $this->addThemeJs('js/select2.min.js');?>

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<?php echo $this->getAdditionalJs();?>
<!-- END PAGE LEVEL SCRIPTS -->
<?php echo $this->childView();?>