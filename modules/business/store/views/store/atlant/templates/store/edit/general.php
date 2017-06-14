<?php
$maincategory = $this->getStore()->getStoreMainCategory();
$subcategory = $this->getStore()->getStoreSubCategory();
$companymodel = App::model('company')->load($this->getStore()->getParentId());
?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
<form method="post" action="<?php echo $this->getUrl('admin/store/save',$this->getRequest()->query());?>" id="store_form" >
    <div class="row mt20">
        <div class="col-sm-12">
            <div class="alert alert-info">
                <h4><?php echo __('Info:');?> </h4>
                <p>
                    -  <strong><?php echo __('Red');?></strong> <?php echo __('highlighted label will be mandatory.');?><br>
                    - <?php echo __('Atleast');?> <strong><?php echo __('one');?></strong> <?php echo __('language data need to entered for the mandatory fields.');?>  <br>
                </p>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-btns" style="display: none;">
                <a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="" data-original-title="Minimize Panel"><i class="fa fa-minus"></i></a>
            </div><!-- panel-btns -->
            <h4 class="panel-title"><?php echo __("General Information");?></h4>
        </div><!-- panel-heading -->
        <div class="panel-body">
            <div class="row">


                <div class="row">

                    <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label"><?php echo __('Company');?></label>
                        <div class="">
                               <?php if($this->getStore()->getParentId()){ ?>
                              <?php if($companymodel->getCompanyName()){ ?>
								<input readonly type="text" class="form-control" value="<?php echo $companymodel->getCompanyName(); ?>">
								<?php } ?>
								<?php } ?>
                        </div>
                     </div>
                     </div>
                 </div>
                 
                 <input type="hidden" name="status" value="<?php echo $this->getStore()->getStatus(); ?>">

                <?php echo $this->setElementAttrs(array('class'=>'form-control','data-labelwidth' => false,'data-fieldwidth' => false))->render('store_name'); ?>


            </div><!-- row -->
        </div><!-- panel-body -->
    </div>

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
            <!--<button class="btn btn-primary mr5" type="submit"><?php echo __('Save and Add products');?></button>-->
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
<script>
    $("#store_form").validate({
        onsubmit: true,
    });
    $(window).load(function(){

        $("#select-company").select2();
    });
</script>
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

