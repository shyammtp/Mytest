<?php if($this->getStore()->getStoreId()):?>
<form method="post" action="<?php echo $this->getUrl('admin/store/save',$this->getRequest()->query());?>" id="store_product_form" class="form-horizontal form-bordered">
    <input type="hidden" value="<?php echo $this->getUrl('admin/store/edit',array('__current' => true,'tab' => 'tgs'));?>" name="redirectto" />
    <input name="store_id" id="store_id" type="hidden" class="form-control" value="<?php echo $this->getStore()->getStoreId();?>" />
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-btns" style="display: none;">
                <a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="" data-original-title="Minimize Panel"><i class="fa fa-minus"></i></a>
            </div><!-- panel-btns -->
            <h4 class="panel-title"><?php echo __("Tags");?></h4>
        </div><!-- panel-heading -->
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('Add tags for this store');?></label>
                <div class="col-sm-6">
                    <input name="store_tags" id="atgs" class="form-control" value="<?php echo $this->getStore()->getTags()->getTagName();?>" />
                </div>
            </div><!-- form-group -->
        </div>
        <div class="panel-footer">
            <button class="btn btn-primary mr5" type="submit"><?php echo __('Save');?></button>
            <button class="btn btn-default mr5" type="button" onclick="setLocation('<?php echo $this->getUrl("admin/dashboard/index");?>')"><?php echo __('Cancel');?></button>
        </div>
    </div>
</form>
<script>
$(window).load(function() {
    $('#atgs').tagsInput({width:'auto'});
});
</script>
<?php else:?>
<div class="alert alert-warning">
    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
    <strong><?php echo __('Warning!');?></strong>
    <?php echo __('Please add store first');?>
</div>
<?php endif;?>
