<div class="theme-settings">
	<div class="ts-themes">
		<a href="#" class="<?php echo $this->_getValue() == 'theme-default.css' ? 'active' : '';?> thems" data-theme="theme-default.css"><img src="<?php echo $this->getAssetsPathUrl('img/themes/default.jpg');?>"></a>
		<a href="#" class="<?php echo $this->_getValue() == 'theme-forest.css' ? 'active' : '';?> thems"  data-theme="theme-forest.css"><img src="<?php echo $this->getAssetsPathUrl('img/themes/forest.jpg');?>"></a>
		<a href="#" class="<?php echo $this->_getValue() == 'theme-dark.css' ? 'active' : '';?> thems" data-theme="theme-dark.css" class="active"><img src="<?php echo $this->getAssetsPathUrl('img/themes/dark.jpg');?>"></a>
		<a href="#" class="<?php echo $this->_getValue() == 'theme-night.css' ? 'active' : '';?> thems" data-theme="theme-night.css"><img src="<?php echo $this->getAssetsPathUrl('img/themes/night.jpg');?>"></a>
		<a href="#" class="<?php echo $this->_getValue() == 'theme-serenity.css' ? 'active' : '';?> thems" data-theme="theme-serenity.css"><img src="<?php echo $this->getAssetsPathUrl('img/themes/serenity.jpg');?>"></a>
		<a href="#" class="<?php echo $this->_getValue() == 'theme-default-head-light.css' ? 'active' : '';?> thems" data-theme="theme-default-head-light.css"><img src="<?php echo $this->getAssetsPathUrl('img/themes/default-head-light.jpg');?>"></a>
		<a href="#" class="<?php echo $this->_getValue() == 'theme-forest-head-light.css' ? 'active' : '';?> thems" data-theme="theme-forest-head-light.css"><img src="<?php echo $this->getAssetsPathUrl('img/themes/forest-head-light.jpg');?>"></a>
		<a href="#" class="<?php echo $this->_getValue() == 'theme-dark-head-light.css' ? 'active' : '';?> thems" data-theme="theme-dark-head-light.css"><img src="<?php echo $this->getAssetsPathUrl('img/themes/dark-head-light.jpg');?>"></a>
		<a href="#" class="<?php echo $this->_getValue() == 'theme-night-head-light.css' ? 'active' : '';?> thems" data-theme="theme-night-head-light.css"><img src="<?php echo $this->getAssetsPathUrl('img/themes/night-head-light.jpg');?>"></a>
		<a href="#" class="<?php echo $this->_getValue() == 'theme-serenity-head-light.css' ? 'active' : '';?> thems" data-theme="theme-serenity-head-light.css"><img src="<?php echo $this->getAssetsPathUrl('img/themes/serenity-head-light.jpg');?>"></a>
	</div>
</div>
<input type="hidden" name="<?php echo $this->getName();?>" value="<?php echo $this->_getValue();?>" id="themes-color" />
<script type="text/javascript">
	
	$(".ts-themes a").click(function(e){
		e.preventDefault();
		var theme = $(this).attr('data-theme');
		$("#themes-color").val(theme);
		$(".thems").removeClass('active');
		$(this).addClass('active');
	})
</script>