
<div class="row">
	<div class="col-md-12">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs"></ul>
		<form method="post" class="form-horizontal tab-form" action="<?php echo $this->getUrl('domain/list/saveurl',$this->getRequest()->query());?>" accept-charset="UTF-8">
		<?php $this->loadFormErrors(); ?>
		<input type="hidden" name="id" value="<?php echo $this->getRequest()->query('id');?>" />
		<div class="tab-content mb30">
			<div class="tab-pane active" id="home3">
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo __('Route Name');?></label>
					<div class="col-sm-10">
						<select name="route_name" style="width:100%" id="select-multi" data-placeholder="Choose One"  class="width300">
							<option value="default" <?php if($this->_getUrlRewrite()->getRouteName()==1){ echo "selected=selected"; } ?>><?php echo __('Default'); ?></option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label required-hightlight"><?php echo __('Request Path');?></label>
					<div class="col-sm-10">
						<input type="text" maxlength="250" name="request_path" id=""  placeholder="<?php echo __('Request Path');?>" class="form-control" value="<?php echo $this->_getUrlRewrite()->getRequestPath();?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label required-hightlight"><?php echo __('Target Path');?></label>
					<div class="col-sm-10">
						<input type="text" maxlength="250" name="target_path" id=""  placeholder="<?php echo __('Target Path');?>" class="form-control" value="<?php echo $this->_getUrlRewrite()->getTargetPath();?>" />
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo __('Website ID');?></label>
					<div class="col-sm-10">
						<select name="website_id" style="width:100%" id="select-multi" data-placeholder="Choose One"  class="width300">
							<?php foreach($this->_getWebsite() as $websiteid):?>
							<option <?php echo $this->_getUrlRewrite()->getWebsiteId()==$websiteid['website_id'] ? "selected":"";?> value="<?php echo $websiteid['website_id'];?>"><?php echo ucfirst($websiteid['website_name']);?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div> 
				
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo __('For');?></label>
					<div class="col-sm-10">
						<select name="for" style="width:100%" id="select-multi" data-placeholder="Choose One"  class="width300">
							<option value="1" <?php if($this->_getUrlRewrite()->getFor()==1){ echo "selected=selected"; } ?>><?php echo __('Admin'); ?></option>
							<option value="2" <?php if($this->_getUrlRewrite()->getFor()==2){ echo "selected=selected"; } ?>><?php echo __('Store'); ?></option>
							<option value="3" <?php if($this->_getUrlRewrite()->getFor()==3){ echo "selected=selected"; } ?>><?php echo __('Frontend'); ?></option>
						</select>
					</div>
				</div>

       <?php if($this->_getUrlRewrite()->getAdditionalParams())  {  $additional = json_decode($this->_getUrlRewrite()->getAdditionalParams()); 
       $i="0";
       foreach($additional as $key => $val) { ?>
       
			<div class="row column">
				<label class="col-sm-2 control-label"><?php if($i==0){ ?> <?php echo __('Additional Params');?> <?php } ?></label>
					<div class="col-sm-4">
						<input type="text" name="name[]" placeholder="<?php echo __('Name');?>" class="form-control" value="<?php echo $key; ?>" />
					</div>
			
					<div class="col-sm-4">
							  <input type="text" name="value[]"  placeholder="<?php echo __('Value');?>" class="form-control" value="<?php echo $val; ?>" />
					</div>
			
					<input type="hidden"  name="contacts_count[]" data-type="single" size="150"/>
						<div class="col-sm-1">
									<div class="form-group">
										<div class="">
										   <a class="btn btn-primary addcontacts" ><i class="fa fa-plus"></i></a>
										    <?php if($i==!0){ ?>  <a class="btn btn-danger deletescontactsRow" ><i class="fa fa-minus"></i></a><?php } ?>
										</div>
									</div>
						</div>
		</div> 

	 
		<?php $i++; }  } else { ?>
				<div class="contacts-set">
			<div class="row">
				<label class="col-sm-2 control-label"><?php echo __('Additional Params');?></label>
					<div class="col-sm-4">
						<input type="text" name="name[]" placeholder="<?php echo __('Name');?>" class="form-control" value="" />
					</div>
			
					<div class="col-sm-4">
							  <input type="text" name="value[]"  placeholder="<?php echo __('Value');?>" class="form-control" value="" />
					</div>
			
					<input type="hidden"  name="contacts_count[]" data-type="single" size="150"/>
						<div class="col-sm-1">
									<div class="form-group">
										<div class="">
										   <a class="btn btn-primary addcontacts" ><i class="fa fa-plus"></i></a>
										</div>
									</div>
						</div>
		</div> 
	 </div> 
		
		 <?php } ?>
		 
		 	 		 <?php if($this->_getUrlRewrite()->getAdditionalParams()){  ?>
							<div class="contacts-set"></div>
					<?php } ?>

        </div>
        	
				<div class="panel-footer">
					<button class="btn btn-primary mr5"><?php echo __('Save');?></button>
					<button class="btn btn-primary mr5" name="backto" value="1"><?php echo __('Save & Continue');?></button>
					<button type="reset" class="btn btn-default" onclick="setLocation('<?php echo $this->getUrl('domain/list/urlrewrite');?>')"><?php echo __('Cancel');?></button>
				</div>
			</div>
	    </form>
	</div>
</div>
</div>

<div id="contacttemplate" style="display: none;">
		<div class="row column">
				<label class="col-sm-2 control-label">&nbsp;</label>
						<div class="col-sm-4">
						<input type="text" name="name[]"  placeholder="<?php echo __('Name');?>" class="form-control" value="" />
					</div>
			
					<div class="col-sm-4">
							  <input type="text" name="value[]" placeholder="<?php echo __('Value');?>" class="form-control" value="" />

							</div>
					
				<div class="col-sm-2">
						<div class="form-group">
				
								<div class="">
									 <input type="hidden" name="is_delete[]" class="delete" value="0"/>
									 <a class="btn btn-primary addcontacts" ><i class="fa fa-plus"></i></a>
									 <a class="btn btn-danger deletescontactsRow"><i class="fa fa-minus"></i></a>
									 
								</div>
						</div>
				</div>

		</div>
		</div>
		
<script>
$(function() {
	
    var specific_count = 1;
    var template = $("#contacttemplate").html();
    $(function(){
         $(".addcontacts").live('click',function(){
           addOption.addRow(specific_count,template);
        });

        $(".deletescontactsRow").live('click',function(){
            addOption.deleteRow(this);
        });
    });
    var addOption = {
        addRow:function(id,template){
            var row = template.replace();
				$(".contacts-set").append(row);
				specific_count++;


        },
        deleteRow:function(element)
        { 	specific_count--;
            $(element).parents('.column').remove();
            $(element).parents('.column').find('.delete').val(1);
        }
    }
    
  
  $('.select2-offscreen').select2();
  });
</script>
<script>
$(window).load(function(){	
	$('form').preventDoubleSubmission();	
});
</script>


