<?php  if($this->getCategory()->getCategoryParentId()!=0):?>
<?php  $addurl= App::helper('url')->getUrl('admin/category/editcategory',array('id'=>$this->getCategory()->getCategoryParentId()));
$deleteurl = App::helper('url')->getUrl('admin/category/deletecategory',array('id'=>$this->getCategory()->getCategoryParentId(),'category_id'=>$this->getCategory()->getPlaceCategoryId()));   ?>
<div class="row mb20">
    <div class="btn-list pull-right">
        <a class="btn btn-success" onclick="setLocation('<?php echo $addurl;?>')"><i class="fa fa-plus">&nbsp;</i><?php echo __('Add new');?></a>
        <a class="btn btn-danger" href="<?php echo $deleteurl;?>" onclick="SD.Common.confirm(event,'<?php echo __("Are you sure want to delete this category?");?>');"><i class="fa fa-times">&nbsp;</i><?php echo __('Delete');?></a>
    </div>
</div>
<?php endif;?>
<div class="row">
<div class="col-md-12">
<!-- Nav tabs -->
<ul class="nav nav-tabs"></ul>
<form method="post" class="form-horizontal tab-form" action="<?php echo App::helper('url')->getUrl('admin/category/addcategory_post'); ?>"  enctype="multipart/form-data" accept-charset="UTF-8">
<div class="tab-content mb30">
    <input type="hidden" name="parent_id" value="<?php echo $this->getRequest()->query('id'); ?>">
    <input type="hidden" name="category_id" value="<?php echo $this->getCategory()->getPlaceCategoryId();?>">
 <?php echo $this->childView('form');?>
				<div class="panel-footer">
					<button class="btn btn-primary mr5"><?php echo __('Save');?></button>
					<?php $parent_id=App::instance()->getWebsite()->getRootCategoryid();
					if($this->getRequest()->query('id') >0){
					$parent_id=$this->getRequest()->query('id');
					}
					$url=App::helper('url')->getUrl('admin/category/categories',array('id'=>$parent_id)); 
					?>
					<button class="btn btn-primary mr5" name="backto" value="1"><?php echo __('Save & Continue');?></button>
					<button type="reset" class="btn btn-default" onclick="location.href='<?php echo $url;?>'"><?php echo __('Cancel');?></button>
				</div>
			<input type="hidden" name="cateimage" value="<?php echo $this->_getCategory()->getCategoryImageUrl();?>">
</div>
</form>
 
</div>
</div>


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
    });
</script>
