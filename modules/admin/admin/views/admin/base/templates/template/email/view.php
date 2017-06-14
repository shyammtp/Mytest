<link type="text/css" href="<?php echo App::getBaseUrl('');?>assets/admin/base/plugins/switch/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet" />
<div class="row">
		<div class="col-md-12">
				<ul class="nav nav-tabs"></ul>

		<div class="modal-header">
			<button class="close" type="button" onclick="setLocation('<?php echo $this->getUrl('admin/template/email');?>')">×</button>
			<h4 class="modal-title">Preview Template</h4>
		</div>
		<div class="responce"></div>
			 <?php echo $this->_geTemplate()->getContent(); ?>
	  </div>
</div>
