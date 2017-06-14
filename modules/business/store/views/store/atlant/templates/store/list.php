<button type="button" id="add_role" class="btn btn-primary btn-cons" onclick="setLocation('<?php echo $this->getUrl('storeadmin/store/edit');?>')">Add new store</button>
<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">
			<div class="grid-title no-border">
				<h4><?php echo __('Store List');?></h4>
				<div class="tools">	<a href="javascript:;" class="collapse"></a>
					 
				</div>
			</div>
			<div class="grid-body no-border">
				  <?php echo $this->childView('store_management');?> 
			</div>
		</div>
	</div>
</div>
