<link type="text/css" href="<?php echo App::getBaseUrl('');?>assets/admin/base/css/jquery.tagsinput.css" rel="stylesheet" />
<link type="text/css" href="<?php echo App::getBaseUrl('');?>assets/admin/base/plugins/switch/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet" />
<link type="text/css" href="<?php echo App::getBaseUrl('');?>assets/admin/base/css/jquery-ui-1.10.3.css" rel="stylesheet" />
<div class="row">
		<div class="col-md-12">
	<!-- Nav tabs -->
	<ul class="nav nav-tabs"></ul>

		<div class="modal-header">
		<button class="close" type="button" data-dismiss="modal" aria-hidden="true">×</button>
		<h4 class="modal-title"><?php echo __('Category');?></h4>
		</div>
		<div class="responce"></div>
		<form method="post" class="form-horizontal tab-form"  accept-charset="UTF-8"  id="category_form_val_sub" >
		<div class="tab-content">
		<input type="hidden" name="category_id" value="<?php echo $this->getRequest()->query('id');?>" />
		 <?php echo $this->childView('form');?>
				<div class="panel-footer">
					<button type="button" id="category_form_sub" class="btn btn-primary mr5"><?php echo __('Save');?></button>
				</div>
		 </div>
		 
		 </form>
	  </div>
  </div>
<script>
$(function() {
	$( "#category_form_sub" ).click(function( event ) {

		$.ajax({
			url: "<?php echo $this->getUrl('admin/category/addcategory_post',array_merge($this->getRequest()->query(),array('isajax'=>true)));?>",
			type: "post",
			data: $("#category_form_val_sub" ).serialize(),
			dataType:"json",
			success: function(d) {
			var html="";
			if(d.errors){	
				$.each(d.errors,function(k,v){
					html +='<div class="alert alert-danger"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button><ul><li>';
					html +=v;
					html +='</ul></li></div>';
				});
				$('.responce').html(html);
			}
			if(d.sucess){
				html +='<div class="alert alert-success"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button><ul><li>';
				html +=d.sucess;
				html +='</ul></li></div>'; 
				$(".added_category_response").html(html);
				$('#add_new_sub_category_modal').modal('hide');
				$('#category_form_val_sub').trigger("reset");

			}
			
			
			}
		});
	});
});
</script>
<script type="text/javascript" src="<?php echo App::getBaseUrl('');?>assets/admin/base/js/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo App::getBaseUrl('');?>assets/js/media/picturecut/jquery.picture.cut.js"></script>
<script type="text/javascript" src="<?php echo App::getBaseUrl('');?>assets/admin/base/plugins/switch/js/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="<?php echo App::getBaseUrl('');?>assets/admin/base/js/jquery-ui-1.10.3.min.js"></script>
<script type="text/javascript" src="<?php echo App::getBaseUrl('');?>assets/admin/base/js/custom.js"></script>

<?php $thumbimage = $this->_getCategory()->getCategoryImageUrl();?>
<script>
$(function(){
	
        $("#container_image").PictureCut({
            InputOfImageDirectory         : "image",
            PluginFolderOnServer          : "/assets/js/media/picturecut/",
            FolderOnServer                : "/uploads/category/place_category/",
            EnableCrop                    : true,
            CropWindowStyle               : "Bootstrap",
            <?php if($thumbimage):?>
            DefaultImageAttrs           :      {src:'<?php echo $thumbimage;?>'},
            <?php endif;?>
            InputOfImageDirectory : 'category_image',
            MinimumWidthToResize: 350,
            MinimumHeightToResize : 350,
            ImageButtonCSS                :{'border' :'2px dashed rgb(204, 204, 204)','padding':'2px'},
            InputOfImageDirectoryAttr       :{value:'<?php echo $this->getCategory()->getCategoryImage();?>'}
        });
        $('#cstgs').tagsInput({width:'auto'});
    });
</script>


