<?php
$css_class_map = array(
    Notice::ERROR => 'alert-danger',
    Notice::WARNING => 'alert',
    Notice::VALIDATION => 'alert-danger',
    Notice::INFO => 'alert-info',
    Notice::SUCCESS => 'alert-success',
);
?>

<?php  foreach ($this->renderMessage() as $type => $set): ?>
    <?php if (!empty($set)): ?>
	<?php foreach ($set as $notice): ?>
	    <?php if (trim($notice['message']) != '' && trim($notice['message']) !== NULL):  ?> 
		<script type="text/javascript">
		    $(document).ready(function(){
			setTimeout(function() {	
				$('.notice_msg').addClass('showing');
			},200);
			setTimeout(function() {
			    $('.notice_msg').removeClass('showing');
			}, 5000);
		    });
		    
		</script>
		<div class='notice_msg <?php echo Arr::get($css_class_map, Arr::get($notice, 'type')); ?>' >
		    <div class="fixed_outer">
			<div class="fixed_inner">
			    <b>  <?php echo HTML::chars($notice['message']); ?>
			    <?php if (isset($notice['items']) && count($notice['items'])): ?>
		    	  
				    <?php foreach ($notice['items'] as $ite): ?>
					<?php echo $ite; ?>
				    <?php endforeach; ?>
		    
			    <?php endif; ?>
				</b>
			</div>
		    </div>
		</div>
	    <?php endif; ?> 
	<?php endforeach; ?>
    <?php endif; ?>
<?php endforeach; ?>

<script>
<?php /* 	
  require(['site'], function(){
  require(['NotificationFX'],function(notification) {
  <?php foreach($this->renderMessage() as $type => $set): ?>
  <?php if ( ! empty($set)): ?>
  <?php foreach ($set as $notice): ?>
  <?php if ($notice['message'] !== NULL): ?>
  notification.notify('<?php echo HTML::chars($notice['message']); ?>','<?php echo $type;?>').show();
  <?php endif; ?>
  <?php endforeach; ?>
  <?php endif; ?>
  <?php endforeach; ?>
  });
  });
 */ ?> 
    
</script>
