<?php if(App::hasTask('admin/system_permission_users/edit')){ ?><button type="button" class="btn btn-primary btn-cons" onclick="window.location='<?php echo App::helper('admin')->getAdminUrl('admin/system_permission_users/new');?>'"><?php echo __('Add a user role');?> </button> <?php } ?>
<div class="row">
    <div class="col-md-12">
        <?php echo $this->childView('users_list_grid');?>
    </div>
</div>
