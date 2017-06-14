<?php
$_city = $this->getCity();
$_sitelocation = App::getConfig('GOOGLE_LATLONG',Model_Core_Place::ADMIN); 
$_siteaddress = App::getConfig('SITE_CONTACT_ADDRESS',Model_Core_Place::ADMIN);
$session = App::model('user/session');
$customer = $session->getCustomer();
$formdata = $this->getData('form_data');
if($formdata['city']){
	$city_data = $formdata['city'];
}else{
	$city_data = $customer->getCity();
}
?> 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
<div class="fixed_outer">
    <div class="fixed_inner">	
	<div class="full_white_box">
	    <div class="login_title">
		<h2> <?php echo __('Contact Us'); ?></h2>		 
	    </div>
	   <div class="coln-6">
	    <div class="login_form">		
	    <form method="post" id="login_form" class="tab-form attribute_form" action="<?php echo $this->getUrl('home/savecontactus',$this->getRequest()->query());?>" accept-charset="UTF-8" enctype="multipart/form-data" > 
		<ul>
		    <li>
			<label class="manditory"><?php echo __('Name'); ?></label>
			<div class="login_fileds">
			    <input type="text" name="name" placeholder="<?php echo __('Enter your Name'); ?>" value="<?php echo isset($formdata['name'])?$formdata['name']:$customer->getFirstName(); ?>" />
			    <em><i><?php echo $this->getValidationErrors('name'); ?></i></em>
			</div>
		    </li>
		     <li>
			<label class="manditory"><?php echo __('Email'); ?></label>
			<div class="login_fileds">
			    <input type="text" name="email" placeholder="<?php echo __('Enter your Email'); ?>" value="<?php echo isset($formdata['email'])?$formdata['email']:$customer->getPrimaryEmailAddress(); ?>"/>
			    <em><i><?php echo $this->getValidationErrors('email');  ?></i></em>
			</div>
		    </li>
		     <li>
			<label class="manditory"><?php echo __('Phone Number'); ?></label>
			<div class="login_fileds">
			    <input type="text" name="mobile" placeholder="<?php echo __('Enter your mobile number'); ?>"  value="<?php echo isset($formdata['mobile'])?$formdata['mobile']:$customer->getMobile(); ?>"/>
			    <em><i><?php echo $this->getValidationErrors('mobile'); ?></i></em>
			</div>
		    </li>
		     <li>
			<label class="manditory"><?php echo __('City'); ?></label>
			<div class="login_fileds">
			     <select name="city">
					<option value=""><?php echo ' - '.__('Select City').' - ';?></option>
					<?php if($_city) { foreach($_city as $city):?> 
						<option data-url="<?php echo Arr::get($city,'url');?>" <?php if($customer->getCity()==Arr::get($city,'city_id')){ ?> selected <?php } ?> value="<?php echo Arr::get($city,'city_id');?>"><?php echo Arr::get($city,'city_name');?></option>
					<?php endforeach; } ?>
				</select>
				<em><i><?php echo $this->getValidationErrors('city'); ?></i></em>
			</div>
		    </li>
		     <li>
			<label class="manditory"><?php echo __('Area'); ?></label>
			<div class="login_fileds">
			    <select name="area" id="area">
						<option value=""><?php echo ' - '.__('Select Area').' - ';?></option>
					</select>
					<em><i><?php echo $this->getValidationErrors('area'); ?></i></em>
			</div>
		    </li>
		    <li>
			<label class="manditory"><?php echo __('Message'); ?></label>
			<div class="login_fileds">
			    <textarea name="message"><?php echo Arr::get($formdata,'message'); ?></textarea>
			    <em><i><?php echo $this->getValidationErrors('message'); ?></i></em>
			</div>
		    </li>
		   
		    <li>
			<label class="empty_label">&nbsp;</label>
			<div class="login_fileds">
			    <button class="btn btn-primary mr5"><?php echo __('Submit');?></button>
			   
			</div>
		    </li>
		    
		</ul>
		</form>
	    </div>    
	    </div>
	    <div class="coln-6">
		<?php if($_sitelocation):?>
		<div class="map_contact">
			<div id="mapCanvas" style=" width: 100%; height:400px;"></div> 
		</div>
		<?php endif;?>
		<?php if($_siteaddress):?>
		<div class="contact_address">
		    <address>
				<p><?php echo nl2br($_siteaddress);?></p> 
		    </address>
		</div>
		<?php endif;?>
	    </div>
	</div>
    </div>
</div>
<script>
<?php if($_sitelocation):?>
function initialize() {
  var latLng = new google.maps.LatLng(<?php echo Arr::get($_sitelocation,'latitude',31.0770538);?>,<?php echo Arr::get($_sitelocation,'longitude',36.2038197);?>);
  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
    zoom: 14,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  var marker = new google.maps.Marker({
    position: latLng,
    title: 'Point A',
    map: map
  }); 
}

// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);
<?php endif;?>
	var cityurl, dataset = {};
	<?php if(App::model('user/session')->isLoggedIn() && $customer->getCity()){ ?>
		dataset['city_id'] = <?php echo $customer->getCity(); ?>;
		area_id = <?php echo $customer->getArea(); ?>;
			cityurl = $('option:selected',this).data('url');
			$.ajax({
				url : '<?php echo $this->getUrl('search/area');?>',
				type : 'get',
				data : dataset,
				dataType: 'json',
				success : function(res){ 
					var option = '<option value=""><?php echo __('- Select area -');?></option>';
					$.each(res, function(k,f){
						option += '<option '+(f.id == area_id ? 'selected':'')+' data-url="'+f.url+'" value="'+f.id+'">'+f.name+'</option>';
					});
					$("#area").html(option);
				}
			});
	<?php }else{ ?>
	$("select[name='city']").change(function(){
		dataset['city_id'] = $(this).val();
		cityurl = $('option:selected',this).data('url');
		$.ajax({
			url : '<?php echo $this->getUrl('search/area');?>',
			type : 'get',
			data : dataset,
			dataType: 'json',
			success : function(res){ 
				var option = '<option value=""><?php echo __('- Select area -');?></option>';
				$.each(res, function(k,f){
					option += '<option '+(f.selected ? 'selected':'')+' data-url="'+f.url+'" value="'+f.id+'">'+f.name+'</option>';
				});
				$("#area").html(option);
			}
		});
	});
	<?php } ?>
	
	$("select[name='area']").on('change',function(){
		cityurl += "~"+$('option:selected',this).data('url');
	});
	
</script>	
