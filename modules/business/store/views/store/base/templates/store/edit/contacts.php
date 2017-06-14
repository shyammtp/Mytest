<?php if($this->getStore()->getStoreId()):?>
<form method="post" action="<?php echo $this->getUrl('admin/store/save',$this->getRequest()->query());?>" id="store_contact_form" >
    <input type="hidden" value="<?php echo $this->getUrl('admin/store/edit',array('__current' => true,'tab' => 'cont'));?>" name="redirectto" />
    <input name="store_id" id="store_id" type="hidden" class="form-control" value="<?php echo $this->getStore()->getStoreId();?>" />
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-btns" style="display: none;">
                <a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="" data-original-title="Minimize Panel"><i class="fa fa-minus"></i></a>
            </div><!-- panel-btns -->
         <h4 class="panel-title"><?php echo __("Contacts Informations");?></h4>
        </div><!-- panel-heading -->


        <div class="panel-body">
			         <?php if($this->getStore()->getContacts())  {  $contacts = $this->getStore()->getContacts(); $contacts_type = $this->getStore()->getContactsType(); foreach($contacts as $key => $val) { ?>
					
		<div class="row column">
			
			<div class="col-sm-2">
				<div class="form-group">
							<label class="control-label">&nbsp;</label>
					<select name="contacts_type[]" style="width:100%" class="select2-offscreen" data-placeholder="Choose One" >
						<option value="1" <?php if($contacts_type[$key]==1){ echo "selected=selected"; } ?> ><?php echo __('Email'); ?></option>
						<option value="2" <?php if($contacts_type[$key]==2){ echo "selected=selected"; } ?>><?php echo __('Fax'); ?></option>
						<option value="3"  <?php if($contacts_type[$key]==3){ echo "selected=selected"; } ?>><?php echo __('Mobile Number'); ?></option>
						<option value="4"  <?php if($contacts_type[$key]==4){ echo "selected=selected"; } ?>><?php echo __('Skype'); ?></option>
					</select>

				</div>
			</div> 

							
				<div class="col-sm-4">
					<div class="form-group">
				
					<label class="control-label">&nbsp;</label>
					  <input type="text" name="contacts[]"  class="form-control" value="<?php echo $val; ?>" />

					</div>
				</div> 
				 <input type="hidden"  name="contacts_count[]" data-type="single" size="150"/>
				<div class="col-sm-2">
							<div class="form-group">
							<label class="control-label">&nbsp;</label>
								<div class="">
								   <a class="btn btn-primary addcontacts" ><i class="fa fa-plus"></i></a>
								   <?php if($key==!0){ ?>  <a class="btn btn-danger deletescontactsRow" id="add_new_parking<?php echo $key; ?>" ><i class="fa fa-minus"></i></a><?php } ?>
								</div>
							</div>
			  </div>
		</div> 
					
		<?php } } else { ?>
		<div class="contacts-set">
			<div class="row">
				
			<div class="col-sm-2">
				<div class="form-group">
				<label class="control-label">&nbsp;</label>
					<select name="contacts_type[]" style="width:100%" class="form-control" data-placeholder="Choose One" >
						<option value="1" ><?php echo __('Email'); ?></option>
						<option value="2" ><?php echo __('Fax'); ?></option>
						<option value="3" ><?php echo __('Mobile Number'); ?></option>
						<option value="4" ><?php echo __('Skype'); ?></option>
					</select>

				</div>
			</div> 
			
				<div class="col-sm-4">
					<div class="form-group">
				
					<label class="control-label">&nbsp;</label>
					
					  <input type="text" name="contacts[]"  class="form-control" value="" />

					</div>
				</div> 
				 <input type="hidden"  name="contacts_count[]" data-type="single" size="150"/>
				<div class="col-sm-1">
							<div class="form-group">
							<label class="control-label">&nbsp;</label>
								<div class="">
								   <a class="btn btn-primary addcontacts" ><i class="fa fa-plus"></i></a>
								</div>
							</div>
			  </div>
		</div> 
	 </div> 
	 <?php } ?>
	 
	 		 <?php if($this->getStore()->getContacts()){  ?>
				<div class="contacts-set"></div>
             <?php } ?>

            
        </div>

        <div class="panel-footer">
            <button class="btn btn-primary mr5" type="submit"><?php echo __('Save');?></button>
            <button class="btn btn-default mr5" type="button" onclick="setLocation('<?php echo $this->getUrl("admin/dashboard/index");?>')"><?php echo __('Cancel');?></button>
        </div>
    </div>
</form>

<div id="contacttemplate" style="display: none;">
		<div class="row column">
			
						<div class="col-sm-2">
				<div class="form-group">
				<label class="control-label">&nbsp;</label>
					<select name="contacts_type[]" style="width:100%" class="form-control" data-placeholder="Choose One" >
						<option value="1" ><?php echo __('Email'); ?></option>
						<option value="2" ><?php echo __('Fax'); ?></option>
						<option value="3" ><?php echo __('Mobile Number'); ?></option>
						<option value="4" ><?php echo __('Skype'); ?></option>
					</select>

				</div>
			</div> 
			
			
			<div class="col-sm-4">
				<div class="form-group">
	<label class="control-label">&nbsp;</label>
				
				  <input type="text" name="contacts[]"  class="form-control" value="" />

				</div>
			</div> 
			 <input type="hidden"  name="contacts_count[]" data-type="single" size="150"/>
				<div class="col-sm-2">
						<div class="form-group">
						<label class="control-label">&nbsp;</label>
								<div class="">
									 <input type="hidden" name="is_delete[]" class="delete" value="0"/>
									 <a class="btn btn-primary addcontacts" ><i class="fa fa-plus"></i></a>
									 <a class="btn btn-danger deletescontactsRow"><i class="fa fa-minus"></i></a>
									 
								</div>
						</div>
				</div>

		</div>
		</div>



<?php else:?>
<div class="alert alert-warning">
    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
    <strong><?php echo __('Warning!');?></strong>
    <?php echo __('Please add store first');?>
</div>
<?php endif;?>
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
