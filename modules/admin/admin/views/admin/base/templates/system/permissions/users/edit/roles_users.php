<?php $this->loadDBData(); ?>
 <?php $deleteurl = App::helper('url')->getUrl('admin/system_permission_users/deleterole_users',array('id' => $this->getRuid())); ?>
 <?php $html = '<a href="'.$deleteurl.'" class="btn btn-danger"  title="'.__('Delete').'" onclick="SD.Common.confirm(event,\'Are you sure want to delete\');"><i class="fa fa-trash-o"></i></a>';  ?>
<div class="row">
 <div class="btn-list pull-right"><?php if($this->getRuid()) {  echo $html; } ?></div>
 </div>
<form method="post" id="roleforms" action="<?php echo App::helper('admin')->getAdminUrl('admin/system_permission_users/save');?>">
<input type="hidden" value="<?php echo $this->getRuid();?>" name="ruid" />

<div class="panel panel-default">
   <div class="panel-heading">
         <div class="panel-btns" style="display: none;">
             <a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="" data-original-title="Minimize Panel"><i class="fa fa-minus"></i></a>
         </div><!-- panel-btns -->
         <h4 class="panel-title"><?php echo __('Users Roles');?></h4>
         <p>-<strong><?php echo __('Red');?></strong> <?php echo __('highlighted label will be mandatory.');?></p>
     </div>
   <div class="panel-body">
      <div class="row">
         <div class="col-md-8 col-sm-8 col-xs-8">
           <div class="form-group">
             <label class="form-label"><?php echo __('Role');?></label>
             <div class="controls">
                  <select name="role_id" id="source" style="width:100%">
                      <?php foreach($this->getRolesList() as $list):?>
                          <option <?php echo $this->getRoleId()==$list['value'] ? "selected":"";?> value="<?php echo $list['value'];?>"><?php echo $list['label'];?></option>
                      <?php endforeach;?>
                  </select>
             </div>
           </div>
         </div>
       </div>

      <div class="row">
         <div class="col-md-8 col-sm-8 col-xs-8">
             <div class="form-group">
               <label class="control-label required-hightlight"><?php echo __('Users');?></label>
               <div class="autocomplete-container">
                   <input type="hidden" name="customer_id" id="" size="150" value="<?php echo $this->getUserId();?>"  />
                   <div id="tags_tagsinput" class="autocompleteinput">
                       <div id="tags_addTag">
                           <?php if($this->getUser()->getUserId()):?>
                              <span class="tag"><?php echo $this->getUser()->getPrimaryEmailAddress();?> <a href="javascript:;" data-id="<?php echo $this->getUser()->getUserId();?>">x</a></span>
                           <?php endif;?>
                           <input type="text" class="" id="customer_id" size="150"/>
                           <div class="tags_clear"></div>
                       </div>
                   </div>
               </div>
               <span class="help-block"><?php echo __('Type atleast 2 keyword to select a user');?></span>
           </div>
         </div>
       </div>
      </div>
      
      <div class="panel-footer">
         <div class="form-actions">
             <div class="pull-right">
               <button class="btn btn-success btn-cons" type="submit"><i class="icon-ok"></i><?php echo __('Save');?></button>
               <button class="btn btn-white btn-cons" type="button" onclick="setLocation('<?php echo $this->getUrl("admin/system_permission_users/index");?>')"><?php echo __('Cancel');?></button>
             </div>
         </div>
      </div>
</div>
</form>
<script>
   $(function() {
      SD.Autocomplete.setType('single').ajax('customer_id','<?php echo $this->getUrl('admin/users/list',array('format'=> 'json','suppressResponseCodes' => 'true'));?>');
   });
</script>
<script>
$(window).load(function(){	
	$('form').preventDoubleSubmission();	
});
</script>
