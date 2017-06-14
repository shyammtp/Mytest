<li>
    <label class=""><?php echo __('Country'); ?></label>
    <div class="input_fileds">
	<select name="country_id"  id="country-changecity" data-placeholder="Choose One" c>
	    <?php foreach ($this->_getCountryInfo() as $countryid => $countryname): ?>
    	    <option <?php echo $this->getCountryId() == $countryid ? "selected" : ""; ?> value="<?php echo $countryid; ?>"><?php echo ucfirst($countryname); ?></option>
	    <?php endforeach; ?>
	</select>
    </div>

</li>
<li>
<div id='citylists' ></div>
</li>
<li>
<div id='arealists' ></div>
</li>

<script>
    $(window).load(function(){
	if($('#country-changecity').length) {
	    $('#country-changecity').select2();
	    $("#country-changecity").change(function(){
		var countryid = $(this).val();
		var cityid = "<?php echo $this->getCityId(); ?>"
		var areaid = "<?php echo $this->getAreaId(); ?>"
		$.ajax({
		    url: '<?php echo $this->getUrl("account/getcity"); ?>',
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
