<div class='row ques-list'>
		<?php 
		if($this->getRequest()->query('name') == 1) { 
			echo $this->childView('general');
		}elseif($this->getRequest()->query('name') == 2){
			echo $this->childView('patient_edit');
		}elseif($this->getRequest()->query('name') == 3){
			echo $this->childView('admin_edit');
		}
		?>
</div>
</div>
</div>
<script>
$(window).load(function(){		
	$("#type").select2();
	$("#type").change(function() {
		if($(this).val() == 'doctor') {
			window.location.href = '<?php echo App::helper('url')->getUrl('users/edit',array('name'=>1)); ?>';
		}else if($(this).val() == 'patient') {
			window.location.href = '<?php echo App::helper('url')->getUrl('users/edit',array('name'=>2)); ?>';
		} 
	});
});
</script>	
