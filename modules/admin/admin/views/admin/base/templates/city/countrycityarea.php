<div class="form-group">
<label class="col-sm-2 control-label"><?php echo __('Country');?></label>
<div class="col-sm-10">
		<select name="country_id" style="width:100%" id="country-changecity" data-placeholder="Choose One" class="width300">
		<?php foreach($this->_getCountryInfo() as $countryid => $countryname):?>
		<option <?php echo $this->getCountryId()==$countryid ? "selected":"";?> value="<?php echo $countryid;?>"><?php echo ucfirst($countryname);?></option>
		<?php endforeach;?>
		</select>
</div>
</div>

<div id='citylists' ></div>
<div id='arealists' ></div>

<script>
	$(window).load(function(){
		if($('#country-changecity').length) {
				$('#country-changecity').select2();
				$("#country-changecity").change(function(){
					 var countryid = $(this).val();
					 var cityid = "<?php echo $this->getCityId();?>"
					 var areaid = "<?php echo $this->getAreaId();?>"
					 $.ajax({
						 url: '<?php echo $this->getUrl("admin/settings/getcity");?>',
						 type: 'get',
						 data: {country_id : countryid, city_id : cityid, area_id : areaid},
						 dataType: 'html',
						 success: function(res) { 
							 $("#citylists").html(res);
						 }
					 })
				});
				$("#country-changecity").change();
		}
    });
</script>
