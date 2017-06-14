<?php
$CityLists = $this->_getCitylists();
?>

    <label class=""><?php echo __('City'); ?></label>
    <div class="input_fileds">
	<select name="city_id"  id="city-changearea" data-placeholder="Choose One" >
	    <?php foreach ($CityLists as $cityid => $cityname): ?>
    	    <option <?php echo $this->getCityId() == $cityid ? "selected" : ""; ?>  value="<?php echo $cityid; ?>"><?php echo ucfirst($cityname); ?></option>
	    <?php endforeach; ?>
	</select>
    </div>


<script>
	
    $(function(){
	$('#city-changearea').select2();
	$("#city-changearea").change(function(){
            var cityid = $(this).val();
            
	    var areaid = "<?php echo $this->getAreaId(); ?>"
            $.ajax({
                url: '<?php echo $this->getUrl("account/getarea"); ?>',
                type: 'get',
                data: {city_id : cityid, area_id : areaid},
                dataType: 'html',
                success: function(res) { 
                    $("#arealists").html(res);
                }
            })
	});
	$("#city-changearea").change();  
    });
	
    $(function(){
        $("#m-multi").select2();
<?php if ($this->getData('all')) { ?>
    		$("#m-multi").on("select2-selecting", function (e) {
    		    if (e.val == '0:all') {
    			$("#m-multi").val('0:all').trigger('change');
    		    }
    		    $("#m-multi :selected").each(function(i,selected) {
    			if ($(this).val() == "0:all"){
    			    $(this).attr('selected',false);
    			    $("#m-multi").trigger('change');
    			}
    		    })
    		});
<?php } ?>
       
	    }); 
</script>
