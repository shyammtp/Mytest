<div class="row">
	<div class="col-md-12">
		<div class="grid simple ">
			<div class="grid-title no-border">
				<h4><?php echo __('Cache Storage Management');?></h4>
				<div class="tools">	<a href="javascript:;" class="collapse"></a>
					 
				</div>
			</div>
			<div class="grid-body no-border">
				  <?php echo $this->childView('cache_grid_list');?> 
			</div>
		</div>
	</div>
</div>