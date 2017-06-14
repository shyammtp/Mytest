<?php
$css_class_map = array(
	Notice::ERROR      => 'alert-danger',
	Notice::WARNING    => 'alert',
	Notice::VALIDATION => 'alert-danger',
	Notice::INFO       => 'alert-info',
	Notice::SUCCESS    => 'alert-success',
);  
?>

<?php foreach($this->renderMessage() as $type => $set): ?>
	<?php if ( ! empty($set)): ?>
		<?php foreach ($set as $notice): ?>
		<div class="alert <?php echo $css_class_map[$type]; ?>">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button> 

			<?php if ($notice['message'] !== NULL): ?>
			<?php echo HTML::chars($notice['message']); ?>
			<?php endif; ?>

			<?php if ( ! empty($notice['items'])): ?>
			<ul>
				<?php foreach($notice['items'] as $item): ?>
				<li><?php echo HTML::chars($item); ?></li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</div>
		<?php endforeach; ?>
	<?php endif; ?>
<?php endforeach; ?>
<div class="footer_slow">
<?php echo App::getConfig('COPYRIGHTS',Model_Core_Place::ADMIN);?>
</div>
