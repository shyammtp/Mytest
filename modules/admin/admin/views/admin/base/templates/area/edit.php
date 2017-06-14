<div class="row">	
	<div class="col-md-12">
<!-- Nav tabs -->
<ul class="nav nav-tabs"></ul>
<form method="post" id="area_form" class="tab-form attribute_form" action="<?php echo $this->getUrl('admin/settings/savearea',$this->getRequest()->query());?>" accept-charset="UTF-8" enctype="multipart/form-data" >
<?php  $this->loadFormErrors(); ?>
<input type="hidden" name="area_id" value="<?php echo $this->getRequest()->query('id');?>" />
	<div class="tab-content mb30">
	<div class="tab-pane active" id="home3">
		
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo __('Country');?></label>
			<div class="col-sm-10">
					<select name="country_id" style="width:100%" id="country-changecity" data-placeholder="Choose One" class="width300">
					<?php foreach($this->_getCountryInfo() as $countryid => $countryname):?>
					<option <?php echo $this->_getArea()->getCountryId()==$countryid ? "selected":"";?> value="<?php echo $countryid;?>"><?php echo ucfirst($countryname);?></option>
					<?php endforeach;?>
					</select>
			</div>
		</div>
            
		<div id='citylists' ></div>
		
		<?php echo $this->renderField('text',array('attribute_code' => 'area_name','is_required' => true,'label' => __('Area'),'value' => $this->_getArea()->getAreaName()));?>
		 
		
		<div class="form-group">
		  <label  class="col-sm-2 control-label"><?php echo __('Status');?></label>
			<div class="col-sm-10">			 
			 <?php $checked = "checked"; if($this->getRequest()->query('id')){ 
				if($this->_getArea()->getAreaStatus()){ $checked = "checked=checked"; } else { $checked = ""; } } ?>
			<input type="checkbox" class="toggle" name="area_status" data-size="small" <?php echo $checked;?> data-on-text="<?php echo __('Yes');?>" data-off-text="<?php echo __('No');?>" data-off-color="danger" data-on-color="success" style="visibility:hidden;" value="1" />
			</div>
		</div>    			 							
       </div>
		<div class="panel-footer">
		<button class="btn btn-primary mr5"><?php echo __('Save');?></button>
		<button class="btn btn-primary mr5" name="backto" value="1"><?php echo __('Save & Continue');?></button>
		<button type="reset" class="btn btn-default" onclick="setLocation('<?php echo $this->getUrl('admin/settings/areasettings');?>')"><?php echo __('Cancel');?></button>
		</div>
        </div>
</form>
</div></div>
<script>
	$(window).load(function(){	
		$('#a_form').preventDoubleSubmission();	
	});

    $(function(){
	   $('#country-changecity').select2();
       $("#country-changecity").change(function(){
            var countryid = $(this).val();
            $.ajax({
                url: '<?php echo $this->getUrl("admin/settings/getcity");?>',
                type: 'get',
                data: {country_id : countryid},
                dataType: 'html',
                success: function(res) { 
                    $("#citylists").html(res);
                }
            })
       });
       $("#country-changecity").change();  
    });
</script>
