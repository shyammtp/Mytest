<?php $this->loadDBData();
$ruid = $this->getRuid();
$useroptions = $this->getUsersOptions();
$places = $this->getPlaces();
$pids = $this->getProductIds(); 
$roleset = $this->getRoleset();
$userid = $this->getRequest()->query('user_id');
$role_id = $this->getRequest()->query('role_id');
$placeid = $this->getRequest()->query('place_id');

?> 
 <?php $deleteurl = App::helper('url')->getUrl('admin/system_permission_users/deleterole_users',array('id' => $this->getRuid())); ?>
 <?php $html = '<a href="'.$deleteurl.'" class="btn btn-danger"  title="'.__('Delete').'" onclick="SD.Common.confirm(event,\''.__("Are you sure want to delete?").'\');"><i class="fa fa-trash-o"></i></a>';  ?>
 <style>
	.fixed-saved {position: fixed; width:80%; margin-left: 230px; transform: translate(0%, 0%);bottom: 0;left: 0;z-index: 999;box-shadow: 0px -7px 4px -9px #444;}
</style>
<div class="row">
 <div class="btn-list pull-right"><?php if($this->getRuid()) {  echo $html; } ?></div>
 </div>
<form method="post" id="roleforms" action="<?php echo $this->getUrl('admin/system_permission_users/saveroleuser',$this->getRequest()->query());?>">
<input type="hidden" value="<?php echo $ruid;?>" name="ruid" />
<input type="hidden" name="placetype" value="<?php echo $this->getRequest()->query('type');?>"/>

<div class="panel panel-default">
   <div class="panel-heading">
         <div class="panel-btns" style="display: none;">
             <a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="" data-original-title="Minimize Panel"><i class="fa fa-minus"></i></a>
         </div><!-- panel-btns -->
         <h4 class="panel-title"><?php echo __('Users Roles');?></h4>
         <p>- <strong><?php echo __('Red');?></strong> <?php echo __('highlighted label will be mandatory.');?></p>
     </div>
   <div class="panel-body">
	
	
	<div class="row">
         <div class="col-md-8 col-sm-8 col-xs-8">
           <div class="form-group">
             <label class="form-label"><?php echo __('Users');?></label>
             <div class="controls">
                  <select name="user_id" id="source2" style="width:100%">
                      <?php foreach($useroptions as $val => $name):?>
                          <option <?php echo $userid==$val ? "selected":"";?> value="<?php echo $val;?>"><?php echo $name;?></option>
                      <?php endforeach;?>
                  </select>
             </div>
           </div>
         </div>
       </div>
	
	<div class="row">
         <div class="col-md-8 col-sm-8 col-xs-8">
           <div class="form-group">
             <label class="form-label"><?php echo __('Places');?></label>
             <div class="controls">
                  <select name="place_id" id="source1" style="width:100%">
					<option value=""><?php echo __('Select Place');?></option>
                      <?php foreach($places as $val => $name):?>
                          <option <?php echo $placeid==$val ? "selected":"";?> value="<?php echo $val;?>" data-type="<?php echo $name['type'];?>"><?php echo $name['name'];?></option>
                      <?php endforeach;?>
                  </select>
             </div>
           </div>
         </div>
       </div>
	
	<div class="row">
	   <div class="col-md-8 col-sm-8 col-xs-8">
		 <div class="form-group">
		   <label class="form-label"><?php echo __('Role');?></label>
		   <div class="controls" id="rolesres">
				<select name="role_id" id="source4" style="width:100%">
					<option value=""><?php echo __('Select Role');?></option>
                      <?php  foreach($roleset as $val => $name):?>
                          <option  <?php echo $role_id==$val ? "selected":"";?> value="<?php echo $val;?>" ><?php echo $name;?></option>
                      <?php endforeach;?>
                  </select>
		   </div>
		 </div>
	   </div>
	 </div>
	<input type="hidden" id="selected_prds" name="cproduct_id" value="<?php echo implode(",",$pids);?>"/>
      </div>
   <?php if($role_id):?>
      <div class="panel-footer fixed-saved">
         <div class="form-actions">
             <div class="pull-right">
               <button class="btn btn-success btn-cons" name="action" value="save" type="submit"><i class="icon-ok"></i><?php echo __('Save');?></button>
               <button class="btn btn-white btn-cons" type="button" onclick="setLocation('<?php echo $this->getUrl("admin/system_permission_users/cusers");?>')"><?php echo __('Cancel');?></button>
             </div>
         </div>
      </div>
	  <?php endif;?>
</div>
</form>

	<?php if($this->getRequest()->query('place_id')):?>
	<?php echo $this->childView('productlist');?>
	<?php endif;?>
<script>
	/*$(function(){
		$("#source1").change();
	});*/
	
    var selectedproducts = <?php echo json_encode($pids);?>;   
	$(".allocateplace").on('click',function(){
		$(".chosepl").modal();
	});
	$("#selected_prds").val(selectedproducts.join(','));
	$(document.body).on('click',".massaction_checkcompany_prdlist",function(){
		var value = $(this).val();
		if ($(this).is(":checked")) { 
			if ($.inArray(value, selectedproducts ) <= -1) {			
				selectedproducts.push(value); 
			}
		} else {
			var index = $.inArray(value, selectedproducts );
			if (index > -1) {
				selectedproducts.splice(index, 1);
			}
		}
		$("#selected_prds").val(selectedproducts.join(','));
	});
	$(".checkallcompany_prdlist").on('click',function(){
		var allcheck = $(this);
		$(".massaction_checkcompany_prdlist").each(function(){
			var value = $(this).val();
			if (allcheck.is(":checked")) {  
				if ($.inArray(value, selectedproducts ) <= -1) {	 		
					selectedproducts.push(value); 
				}
			} else {
				var index = $.inArray(value, selectedproducts );
				if (index > -1) {
					selectedproducts.splice(index, 1);
				}
			}
			$("#selected_prds").val(selectedproducts.join(','));
		});
	});
	$("#source1").change(function(){
		var va = $('option:selected',this).attr('data-type');
		$("input[name='placetype']").val(va);
		$("input[name='action']").attr('disabled',true);
		$("#roleforms").submit(); 
		$("#roleforms").find('input').attr('disabled',true);
		$("#roleforms").find('select').attr('disabled',true);
	});
	$("#source4").change(function(){
		var va = $('option:selected',this).val();
		$("input[name='action']").attr('disabled',true);
		$("#roleforms").submit(); 
		$("#roleforms").find('input').attr('disabled',true);
		$("#roleforms").find('select').attr('disabled',true);
	});
$(window).load(function(){	
	$('#source2').focus();
	$('form').preventDoubleSubmission();
	$("#source2, #source1,#source4").select2();
});
</script>
