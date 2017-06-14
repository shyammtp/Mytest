<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<?php echo $this->addJs('plugins/jquery-1.10.1.min.js');?>
<?php echo $this->addJs('plugins/jquery-migrate-1.2.1.min.js');?>
<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<?php echo $this->addJs('plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js');?>      
<?php echo $this->addJs('plugins/bootstrap/js/bootstrap.min.js');?>
<!--[if lt IE 9]>
<?php echo $this->addJs('plugins/excanvas.min.js');?>
<?php echo $this->addJs('plugins/respond.min.js');?> 
<![endif]-->   
<?php echo $this->addJs('plugins/jquery-slimscroll/jquery.slimscroll.min.js');?>
<?php echo $this->addJs('plugins/jquery.blockui.min.js');?>  
<?php echo $this->addJs('plugins/jquery.cookie.min.js');?>
<?php echo $this->addJs('plugins/uniform/jquery.uniform.min.js');?>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<?php echo $this->addJs('plugins/jquery-validation/dist/jquery.validate.min.js');?>
<?php echo $this->addJs('plugins/backstretch/jquery.backstretch.min.js');?>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<?php echo $this->getAdditionalJs();?>     
<!-- END PAGE LEVEL SCRIPTS --> 
<script>
    jQuery(document).ready(function() {     
      App.init();
      Login.init();
    });
</script>