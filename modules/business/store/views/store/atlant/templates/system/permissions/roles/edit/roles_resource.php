<?php $deleteurl = $this->getUrl('admin/system_permission_roles/deleterole', array('id' => $this->getRequest()->query('id'))); ?>
<?php $html = '<a href="' . $deleteurl . '" class="btn btn-danger"  title="' . __('Delete') . '" onclick="SD.Common.confirm(event,\'' . __("Are you sure want to delete?") . '\');"><i class="fa fa-trash-o"></i></a>'; ?>
<div class="back_delete_icon"><?php if ($this->getRequest()->query('id')) {
    echo $html;
} ?></div>
<form method="post" id="role-permission" action="<?php echo $this->getUrl('admin/system_permission_roles/save', $this->getRequest()->query()); ?>">
    <input type="hidden" name="role_id" value="<?php echo $this->getRequest()->query('id'); ?>" />      
    <input type="hidden" name="updated_date" value="<?php echo date("Y-m-d H:i:s", time()); ?>" />
    <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-8">
	    <div class="form-group">
		<label class="form-label"><?php echo __('Role Name'); ?></label>
		<div class="controls">
		    <input type="text" maxlength="45" name="role_name" class="form-control mb10" id="role_name" value="<?php echo $this->getRole()->getRoleName(); ?>" />
		    <span id="role_tag_prev" class="label label-default"><?php echo $this->getRole()->getRoleName(); ?></span>
		</div>
	    </div>

	    <div class="form-group">
		<label class="col-sm-2 control-label required-hightlight"><?php echo __('Api Key'); ?></label>
		<div class="col-sm-6">
		    <div class=""> 
			<input type="text" name="apires[app_key]" class="form-control" maxlength="36" value="<?php echo $this->getRole()->getApi()->getData('app_key'); ?>">
		    </div>

		</div>
		<div class="col-sm-2">
		    <button class="btn btn-primary" type="button" id="generate_app_key"><?php echo __('Generate'); ?></button>
		</div>
	    </div><!-- form-group -->
	    <div class="form-group">
		<label class="form-label"><?php echo __('Tag Background Color'); ?></label>
		<div class="controls">
		    <input type="text" name="tag_bg_color" class="form-control colorpicker-input" placeholder="#000000" id="colorpicker" value="<?php echo $this->getRole()->getTagBgColor(); ?>" />
		    <span id="colorSelector" class="colorselector"><span>
			    </div>
			    </div>

			    <div class="form-group">
				<label class="form-label"><?php echo __('Tag Font Color'); ?></label>
				<div class="controls">
				    <input type="text" name="tag_text_color" class="form-control colorpicker-input" placeholder="#000000" value="<?php echo $this->getRole()->getTagTextColor(); ?>" id="colortextpicker" />
				    <span id="colortextSelector" class="colorselector"><span>
					    </div>
					    </div>
					    </div>
					    </div>
<?php echo $this->getRoleTasks(); ?>
					    <div class="form-actions">
						<div class="pull-left">
						    <button class="btn btn-success btn-cons" type="submit" id="roleform"><i class="icon-ok"></i><?php echo __('Save'); ?></button>
						    <button class="btn btn-white btn-cons" type="button" onclick="setLocation('<?php echo $this->getUrl("admin/system_permission_roles/index"); ?>')"><?php echo __('Cancel'); ?></button>
						</div>
					    </div>
					    </form>
					    <script>
						//<![CDATA[
						$(window).load(function(){
						    $("#role_name").keyup(function(){
							$("#role_tag_prev").text($(this).val());
						    });
<?php if ($this->getRole()->getTagBgColor()): ?>
    								jQuery('#colorSelector span').css('backgroundColor', '<?php echo $this->getRole()->getTagBgColor(); ?>');
    								$("#role_tag_prev").css('backgroundColor', '<?php echo $this->getRole()->getTagBgColor(); ?>');
<?php endif; ?>

<?php if ($this->getRole()->getTagTextColor()): ?>
    								jQuery('#colortextSelector span').css('backgroundColor', '<?php echo $this->getRole()->getTagTextColor(); ?>');
    								$("#role_tag_prev").css('color', '<?php echo $this->getRole()->getTagTextColor(); ?>');
<?php endif; ?>

								if(jQuery('#colorpicker').length > 0) {
								    jQuery('#colorSelector').ColorPicker({
									onShow: function (colpkr) {
									    jQuery(colpkr).fadeIn(500);
									    return false;
									},
									onHide: function (colpkr) {
									    jQuery(colpkr).fadeOut(500);
									    return false;
									},
									onChange: function (hsb, hex, rgb) {
									    jQuery('#colorSelector span').css('backgroundColor', '#' + hex);
									    jQuery('#colorpicker').val('#'+hex);
									    $("#role_tag_prev").css('backgroundColor', '#' + hex);
									}
								    });
								}

								if(jQuery('#colortextpicker').length > 0) {
								    jQuery('#colortextSelector').ColorPicker({
									onShow: function (colpkr) {
									    jQuery(colpkr).fadeIn(500);
									    return false;
									},
									onHide: function (colpkr) {
									    jQuery(colpkr).fadeOut(500);
									    return false;
									},
									onChange: function (hsb, hex, rgb) {
									    jQuery('#colortextSelector span').css('backgroundColor', '#' + hex);
									    jQuery('#colortextpicker').val('#'+hex);
									    $("#role_tag_prev").css('color', '#' + hex);
									}
								    });
								}
								$("#generate_app_key").click(function(){
								    var string = randomString(32, '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ');
								    $("input[name='apires[app_key]']").val(string);
								});
			
								$(".parentcheckbox").click(function(){
								    var id = $(this).val();
								    if ($(this).is(":checked")) {
									$("#"+id).find('input.toggle').bootstrapSwitch('state',true);
								    } else {
									$("#"+id).find('input.toggle').bootstrapSwitch('state',false);
								    }
				
								});
								$("input.toggle").on('switchChange.bootstrapSwitch',function(){ 
								    checkanduncheck($(this).parents("table")); 
								})
								$("form#role-permission").find('table').each(function(){
								    checkanduncheck($(this));
								});
			
							    })
							    function randomString(length, chars) {
								var result = '';
								for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
								return result;
							    }
		
							    function checkanduncheck(tablelement) {
								var totalchecked = tablelement.find('input.toggle:checked').length;
								if (totalchecked > 0) {
								    tablelement.find('.parentcheckbox').attr('checked',true);
								} else {
								    tablelement.find('.parentcheckbox').attr('checked',false);
								} 
							    }
							    //]]>
					    </script>
					    <script>
						$(window).load(function(){	
							$('#role_name').focus(); 
						    $('form').preventDoubleSubmission();	
						});
					    </script>
