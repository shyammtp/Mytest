     

<div class="panel panel-default" id="role_form" style="display: none;">
	                <form method="post" id="roleforms" action="<?php echo App::helper('url')->getUrl('admin/system_permission_roles/savecompanyrole');?>">
   <div class="panel-heading">
         <div class="panel-btns" style="display: none;">
             <a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="" data-original-title="Minimize Panel"><i class="fa fa-minus"></i></a>
         </div><!-- panel-btns -->
         <h4 class="panel-title"><?php echo __('Users Roles');?></h4>
         <p>- <strong><?php echo __('Red');?></strong> <?php echo __('highlighted label will be mandatory.');?></p>
     </div>

   <div class="panel-body">
	  
<div class="row" >
    <div class="col-md-12">
        <div class="grid">
			
            <div class="grid-title no-border">
                  
                <div class="row">
                  <div class="col-md-8 col-sm-8 col-xs-8">
                    <div class="form-group">
                      <label class="form-label"><?php echo __('Role Name');?></label>
                      <div class="controls">
                            <input maxlength="45" type="text" name="role_name" id="role_name" class="form-control mb10" />
                            <span id="role_tag_prev" class="label label-default"><?php echo __('Role Name');?></span>
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?php echo __('Tag Background Color');?></label>
                        <div class="controls">
                          <input type="text" name="tag_bg_color" class="form-control colorpicker-input" placeholder="#000000" id="colorpicker" />
                          <span id="colorSelector" class="colorselector"><span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><?php echo __('Tag Font Color');?></label>
                        <div class="controls">
                          <input type="text" name="tag_text_color" class="form-control colorpicker-input" placeholder="#000000" id="colortextpicker" />
                          <span id="colortextSelector" class="colorselector"><span>
                        </div>
                    </div>
                  </div>
                </div>

       
            </div>
        </div>
    </div>
</div>
</div>

 <div class="panel-footer">
         <div class="form-actions">
             <div class="pull-right">
		<button class="btn btn-success btn-cons" type="submit"><i class="icon-ok"></i><?php echo __('Save');?></button>
                     <button class="btn btn-white btn-cons" type="button" id="cancel_role"><?php echo __('Cancel');?></button>
             </div>
         </div>
      </div>
      </form>
</div>
 
<?php echo $this->childView('roles_list_grid');?>  
<script>
    $(document).ready(function(){
        $("#add_role").click(function(){
            $("#role_form").fadeIn(500);
            $("#add_role").hide();
        });
        $("#cancel_role").click(function(){
            $("#role_form").fadeOut(10,function(){
                $("#add_role").show();
            });

        });
        $("#role_name").keyup(function(){
            $("#role_tag_prev").text($(this).val());
        });
    });
    $(window).load(function(){
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
    })
</script>
