<?php
$_user = $this->getUsers();
$contactDetails = $this->getUsers()->getContactDetails();
//$mobileblock = $this->getRootBlock()->createBlock('Admin/Users/Edit/Mobile');

$_department = $_user->getDepartments();
$_insurancess = $_user->getInsurance();

$_insuranceids = array();

foreach ($_insurancess as $d) {
    $_insuranceids[] = $d->getInsuranceId();
}


$_department_ids = array();
$filterdeps = array();

foreach ($_department as $d) {
    $_department_ids[] = $d->getDepartmentId();
    $filterdeps[$d->getDepartmentId()] = array('id' => $d->getDepartmentId(), 'name' => $d->getDepartmentName());
}

$_doctor = $_user->getClinics();
$_doctor_ids = array();
$filterdocs = array();
foreach ($_doctor as $d) {
    $_doctor_ids[] = $d->getClinicId();
    $filterdocs[$d->getClinicId()] = array('id' => $d->getClinicId(), 'name' => $d->getClinicName(), 'text' => $d->getClinicTypeText());
}
$_insurance = $this->getInsurance();
?>
<style> 
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
		z-index:9999;
      }
 
    </style>
<div class="general_form">
    <form class="form-horizontal tab-form" method="post" accept-charset="UTF-8" enctype="multipart/form-data" action="<?php echo $this->getUrl('account/updateDoctor', $this->getRequest()->query()); ?>" id="doctor">
        <input type="hidden" name="user_token" value="<?php echo $this->getUsers()->getData('user_token'); ?>" />
        <input type="hidden" name="user_id" value="<?php echo $_user->getUserId(); ?>" />
	<ul id="user_info">
		<li>
		<label class=""><?php echo __('Profile Image'); ?></label>
		<div class="input_fileds">
		    <div id="container_image"></div>
		</div>
	    </li>
	    <li>
		<label class=""><?php echo __('Name'); ?></label>
		<div class="input_fileds">
			<?php if(App::getCurrentLanguageId() == 1){   ?>
			
		    <input type="text" name="first_name[1]"  maxlength="200" placeholder="<?php echo __('Name'); ?>"  class="form-control" value="<?php echo $this->getUsers()->getFirstName(1); ?>" />
		    <input type="hidden" name="first_name[2]"  maxlength="200" placeholder="<?php echo __('Name'); ?>"  class="form-control" value="<?php echo $this->getUsers()->getFirstName(2); ?>" />
		    
		   <?php }else{ ?>
			   
			   <input type="hidden" name="first_name[1]"  maxlength="200" placeholder="<?php echo __('Name'); ?>"  class="form-control" value="<?php echo $this->getUsers()->getFirstName(1); ?>" />
		    <input type="text" name="first_name[2]"  maxlength="200" placeholder="<?php echo __('Name'); ?>"  class="form-control" value="<?php echo $this->getUsers()->getFirstName(2)?$this->getUsers()->getFirstName(2):$this->getUsers()->getFirstName(1); ?>" />
			   
			<?php } ?> 
		    
		    <em><i><?php echo $this->getValidationErrors('first_name'); ?></i></em>
		</div>
	    </li>
	    <li>
		<label class=""><?php echo __('Mobile'); ?></label>
		<div class="input_fileds">
		    <input type="text" name="mobile"  maxlength="200" placeholder="<?php echo __('Mobile'); ?>"  class="form-control" value="<?php echo $this->getUsers()->getData('mobile'); ?>" />
		    <span class="help-block"><?php echo __('Add Phone number(s) in comma seperated.'); ?> <br><?php echo __('For example: 9790110251,9005000500'); ?></span>
		    <em><i><?php echo $this->getValidationErrors('mobile'); ?></i></em>
		</div>
	    </li>
	    <li>
		<label class=""><?php echo __('Date of birth'); ?></label>
		<div class="input_fileds">
		    <input type="text" class="form-control" name="date_of_birth" autocomplete="off" value="<?php echo date("m/d/Y", strtotime($this->getUsers()->getData('date_of_birth'))); ?>" placeholder="mm/dd/yyyy" id="datepicker" readonly>
		    <span class="input-group-addon datepicker-trigger"><i class="glyphicon glyphicon-calendar" id="dob"></i></span>
		</div>
	    </li>
	    <li>
		<label class=""><?php echo __('Gender'); ?></label>
		<div class="input_fileds">
		    <select name="gender" class="form-control">
			<option value="" ><?php echo __('Select Gender'); ?></option>
			<option value="M" <?php echo $this->getUsers()->getData('gender') == 'M' ? "selected" : ""; ?>><?php echo __('Male'); ?></option>
			<option value="F" <?php echo $this->getUsers()->getData('gender') == 'F' ? "selected" : ""; ?>><?php echo __('Female'); ?></option>
		    </select>
		</div>
	    </li>
	    <li><?php echo $this->childView('countrycityarea', array('country_id' => $this->getUsers()->getCountry(), 'city_id' => $this->getUsers()->getCity(), 'area_id' => $this->getUsers()->getArea())); ?></li>
	    <li>
		<label class=""><?php echo __('Qualification'); ?></label>
		<div class="input_fileds">
		    <input type="text" name="qualification"  maxlength="250" placeholder="<?php echo __('Qualification'); ?>"  class="form-control" value="<?php echo $this->getUsers()->getData('qualification'); ?>" />
		</div>
	    </li>
	    <li>
		<label class=""><?php echo __('Experience'); ?></label>
		<div class="input_fileds">
		    <input type="text" name="experience"  maxlength="250" placeholder="<?php echo __('Experience'); ?>"  class="form-control" value="<?php echo $this->getUsers()->getData("experience"); ?>" /><span class="input-group-addon"><i><?php echo __("Year(s)");?></i></span>
		</div>
	    </li>
	    <li>		
		<label class="empty_label">&nbsp;</label>
		<div class="input_fileds">
		    <div id="deparment_idlist" class="select2-container select2-container-multi category_id"></div>
		</div>
	    </li>
	    <li>
		<label class=""><?php echo __("Department"); ?></label>
		<div class="input_fileds">
		    <input type="hidden" name="deparment_id" id="deparment_id" value="<?php echo implode(",", $_department_ids); ?>" /> 
		    <input type="text" id="associated-department-tree-departments-search" class="form-control" placeholder="<?php echo __('Search...'); ?>" autocomplete="off" spellcheck="false" dir="auto">		
		</div>
	    </li>
	    <li>
		<label class="empty_label">&nbsp;</label>
		<div class="input_fileds">
		    <div id="clinic_idlist" class="select2-container select2-container-multi category_id"></div>
		</div>
	    </li>
	    <li>
		<label class=""><?php echo __('Clincs / Hospital / Labs'); ?></label>
		<div class="input_fileds">
		    <input type="hidden" name="clinic_id" id="clinic_id" value="" /> 
		    <input type="text" id="associated-clinics-tree-search" class="form-control" placeholder="<?php echo __('Search...'); ?>" autocomplete="off" spellcheck="false" dir="auto"> 
		</div>
	    </li>
	    <li>
		<label class=""><?php echo __("Insurance"); ?></label>
		<div class="input_fileds">
		    <select id="insu-multi" name="insurance[]" data-placeholder="Choose One" multiple class="width300">
			<?php foreach ($_insurance as $in): ?>			    
    			<option value="<?php echo Arr::get($in, 'insurance_id'); ?>" <?php echo (in_array(Arr::get($in, 'insurance_id'), $_insuranceids)) ? "selected" : ""; ?>><?php echo Arr::get($in, 'insurance_name'); ?></option>
			<?php endforeach; ?>
		    </select>
		</div>
	    </li>
	    <li>
		<label class=""><?php echo __('Venue'); ?></label>
		<div class="input_fileds">
		    <textarea name="venue"><?php echo $this->getUsers()->getData("venue",App::getCurrentLanguageId()); ?></textarea>
			<div style="font: normal 13px/20px OpenSansRegular;" id="direct_address"></div>
			<button type="button" class="btn" id="locate_map_btn"><?php echo $this->getUsers()->getData("latitude") ? __('Located'): __('Locate in map');?></button>
			<input type="hidden" id="latitude" name="latitude" value="<?php echo $this->getUsers()->getData("latitude"); ?>" />
			<input type="hidden" id="longitude" name="longitude" value="<?php echo $this->getUsers()->getData("longitude"); ?>"/>
			<input type="hidden" id="address" name="address" value="<?php //echo $this->getUsers()->getData("longitude"); ?>"/>
			
		</div>
	    </li>
	   <li>
		<label class=""><?php echo __('About'); ?></label>
		<div class="input_fileds">
		    <textarea name="about" ><?php echo $this->getUsers()->getData("about",App::getCurrentLanguageId()); ?></textarea>
		</div>
	    </li>
	    <li>
	    <li>
		<label class="empty_label">&nbsp;</label>
		<div class="input_fileds">
		    <button class="btn btn-primary mr5" type="submit"><?php echo __('Update'); ?></button>
		</div>
	    </li>
	</ul>
    </form>
</div>


<div id="locate_on_map" class="modal fade" role="dialog">
	    <div class="modal-dialog">
	<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	<!-- Modal content-->
	<div class="modal-content"> 
	    <div class="modal-body"> 
		<div class="appoinment_popup_title">
		    <h2><?php echo __('Locate Your place'); ?></h2> 
		</div>
		<div class="popup_form">
			  <input id="pac-input" class="controls" type="text" placeholder="Search Box">
		    <div id="map_locate" style="height:400px; width:100%;"></div>
		</div>   				
	    </div>		
	</div>	    
    </div>

</div>

<?php $thumbimage = $this->getUsers()->getProfileImageUrl('w400', 'w400'); ?>
 <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&key=<?php echo App::getConfig('GOOGLE_MAP_APIKEY',Model_Core_Place::ADMIN);?>"></script>
 <script>
     var map;
	var marker;
	var myLatlng = new google.maps.LatLng(31.956573,35.9106744);
	var geocoder = new google.maps.Geocoder();
	var infowindow = new google.maps.InfoWindow();
	function initialize(){
		if ($('#latitude').val() && $('#longitude').val()) {
			myLatlng = new google.maps.LatLng($('#latitude').val(),$('#longitude').val());
		}
		var mapOptions = {
			zoom: 18,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		map = new google.maps.Map(document.getElementById("map_locate"), mapOptions);
		var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
		
		 // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });
		marker = new google.maps.Marker({
			map: map,
			position: myLatlng,
			draggable: true 
		}); 
		searchBox.addListener('places_changed', function() {
		var bounds = new google.maps.LatLngBounds();
          var places = searchBox.getPlaces();
		  if (places.length == 0) {
            return;
          }
		  //marker.setMap(null);
		  places.forEach(function(place) {
			marker.setPosition(place.geometry.location);
			
		  });
		  google.maps.event.trigger(marker, 'dragend');
		  bounds.extend(marker.getPosition()); 
			map.fitBounds(bounds);
		});
		geocoder.geocode({'latLng': myLatlng }, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) {
				$('#latitude,#longitude').show();
				$("#direct_address").text(results[0].formatted_address);
				$('#address,#pac-input').val(results[0].formatted_address);
				$('#latitude').val(marker.getPosition().lat());
				$('#longitude').val(marker.getPosition().lng());
				infowindow.setContent(results[0].formatted_address);
				infowindow.open(map, marker);
				$("#locate_map_btn").text('<?php echo __("Located");?>');
				}
			}
		});
		
		google.maps.event.addListener(marker, 'dragend', function() { 
			geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
					$('#address').val(results[0].formatted_address);
					$("#direct_address").text(results[0].formatted_address);
					$('#latitude').val(marker.getPosition().lat());
					$('#longitude').val(marker.getPosition().lng());
					infowindow.setContent(results[0].formatted_address);
					infowindow.open(map, marker); 
					$("#locate_map_btn").text('<?php echo __("Located");?>');
					}
				}
			});
		});
		
	}
    </script>
<script>
	function decodeHtml(html) {
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}

    $(function(){
		
		$("#locate_map_btn").click(function(){
			$("#locate_on_map").modal();
		});
		$('#locate_on_map').on('shown.bs.modal', function() {
			if (!map) { 
				initialize();
			}
		});
	$('#department').select2();
	$('#clinic').select2(); 
	$('#laboratory').select2();
	$('#insu-multi').select2();
        
        $("#container_image").PictureCut({
	    Extensions					  : ["jpg","png","gif","jpeg"],
            InputOfImageDirectory         : "image",
            PluginFolderOnServer          : "/assets/js/media/picturecut/",
            FolderOnServer                : "/uploads/user/profile/",
            EnableCrop                    : true,
            CropWindowStyle               : "Bootstrap",
            DefaultImageAttrs           :      {src:'<?php echo $thumbimage; ?>'},
            InputOfImageDirectory : 'profile_image',
            MinimumWidthToResize: 350,
            MinimumHeightToResize : 350,
            ImageButtonCSS                :{'border' :'2px dashed rgb(204, 204, 204)','padding':'2px'},
            InputOfImageDirectoryAttr       :{value:'<?php echo $this->getUsers()->getProfileImage(); ?>'}
        });
    });
    
    $(window).load(function(){
        $('#user').preventDoubleSubmission();


        $('#datepicker').datepicker({								
            yearRange: '<?php echo date("Y") - 100; ?>:<?php echo date("Y"); ?>',
            maxDate: new Date(),
            changeMonth: true,
            changeYear: true
        });
        
        $(".datepicker-trigger").on("click", function() {
	    $("#datepicker").datepicker("show");
	});
               
        $("select[name='social_title']").change(function(){
            if ($(this).val() =='Mrs.' || $(this).val() =='Ms.') {
                $("select[name='gender']").val("F");
            }
            if ($(this).val() =='Mr.') {
                $("select[name='gender']").val("M");
            }
        }); 
    });
    
    var filterdep = <?php echo $filterdeps ? json_encode($filterdeps) : '{}'; ?>, filterdepids = <?php echo json_encode($_department_ids); ?>;
<?php if (count($_department_ids)): ?>
        addDeplist();
<?php endif; ?> 
    $('#associated-department-tree-departments-search').autocompletesingle({	  
	valueKey:'department_name',
	titleKey:'department_name',
	source:[{
		url:'<?php echo $this->getUrl("account/getdepartmentlists"); ?>&q=%QUERY%',	 
		type:'remote',
		getTitle:function(item){	 		
		    return item['department_name']
		},
		getValue:function(item){ 
		    return item['department_name']
		},	
		ajax:{
		    //dataType : 'jsonp'	
		}
	    }]}).on('selected.xdsoft',function(e,datum){
		 if (datum) { 
			$(this).val('');
			filterdep[datum.department_id] = {'id' : datum.department_id, 'name' : datum.department_name};
			if (filterdepids.indexOf(datum.department_id) < 0) {
				filterdepids.push(datum.department_id);
			} 
			addDeplist();
		 }
    });
	
    function addDeplist()
    {
	var dlist = ' <ul class="select2-choices" style="border:none;">';
	var deparmentlists = '';
	var i = 0;
	$.each(filterdep,function(sd,gg){
	    dlist += '<li class="select2-search-choice displ">    <span class="prom_nam">'+gg.name+'</span> <a class="select2-search-choice-close" tabindex="-1" data-id="'+gg.id+'"></a></li>';
	});
        
	dlist +='</div>';
	$("#deparment_id").val(filterdepids.join(','));
	$("#deparment_idlist").html(dlist);
    }
    $(document.body).on('click','.select2-search-choice-close',function(){
	$(this).fadeOut('slow');
	var id = $(this).attr('data-id');
	if (filterdep.hasOwnProperty(id)) {
	    delete filterdep[id];
	}
	var index = filterdepids.indexOf(id);
	if (index > -1) {
	    filterdepids.splice(index, 1);
	}        
	addDeplist();
    });
	
	
	var types = {1: '<?php echo __("Speciality");?>', 2: '<?php echo __("Services");?>', 3: '<?php echo __("Clinic");?>', 4: '<?php echo __("Doctor");?>',5: '<?php echo __("Labs");?>',6 : '<?php echo __("Pharmacy");?>',7 : '<?php echo __("Optics");?>',8 : '<?php echo __("Hospital");?>'};
    var filterdoc = <?php echo $filterdocs ? json_encode($filterdocs) : '{}'; ?>, filterdocpids = <?php echo json_encode($_doctor_ids); ?>;
<?php if (count($_doctor_ids)): ?>
        addDoclist();
<?php endif; ?> 
    $('#associated-clinics-tree-search').autocompletesingle({	  
	valueKey:'clinic_name',
	titleKey:'clinic_name',
	source:[{
		url:'<?php echo $this->getUrl("account/getclinics"); ?>&q=%QUERY%',	 
		type:'remote',
		getTitle:function(item){	 		
		    return item['clinic_name']
		},
		getValue:function(item){ 
		    return item['clinic_name']
		}
	    }],
	render : function (item, source, pid, query) {
		console.log(item);
				 var value = item[this.valueKey],
						title = item[this.titleKey],
					_value = '',
					_query = '',
					_title = '',
					hilite_hints = '',
					highlighted = '',
					c, h, i,
					spos = 0;
					
				if (this.highlight) {
					if (!this.accents) { 
						title = title.replace(new RegExp('('+query+')','i'),'<b>$1</b>');
					}else{ 
						_title = title.toLowerCase().replace(/[<>]+/g, ''),
						_query = query.toLowerCase().replace(/[<>]+/g, '');
						
						hilite_hints = _title.replace(new RegExp(_query, 'g'), '<'+_query+'>');
						for (i=0;i < hilite_hints.length;i += 1) {
							c = title.charAt(spos);
							h = hilite_hints.charAt(i);
							if (h === '<') {
								highlighted += '<b>';
							} else if (h === '>') {
								highlighted += '</b>';
							} else {
								spos += 1;
								highlighted += c;
							}
						}
						title = highlighted;
					}
				}
				 
				return '<div '+(value==query?'class="active"':'')+' data-value="'+encodeURIComponent(value)+'"><span class="left-suggest">' 
							+title+ 
							' </span>('+item['clinic_text']+')&#x200E;'+
						'</div>';
			}
	}).on('selected.xdsoft',function(e,datum){
		 if (datum) { 
	$(this).val('');
	filterdoc[datum.clinic_id] = {'id' : datum.clinic_id, 'name' : datum.clinic_name ,'text' : datum.clinic_text};
	if (filterdocpids.indexOf(datum.clinic_id) < 0) {
	    filterdocpids.push(datum.clinic_id);
	} 
	addDoclist();
		 }
    });
	
    function addDoclist()
    {
	var dlist = ' <ul class="select2-choices" style="border:none;">';
	var deparmentlists = '';
	var i = 0;
	$.each(filterdoc,function(sd,gg){
	    dlist += '<li class="select2-search-choice displ">    <span class="prom_nam">'+gg.name+' ('+gg.text+')&#x200E;'+'</span> <a class="select2-search-choice-close select2-search-doctorchoice-close" tabindex="-1" data-id="'+gg.id+'"></a></li>';
	});
        
	dlist +='</div>';
	$("#clinic_id").val(filterdocpids.join(',')); 
	$("#clinic_idlist").html(dlist);
    }
    $(document.body).on('click','.select2-search-doctorchoice-close',function(){
	$(this).fadeOut('slow');
	var id = $(this).attr('data-id');
	if (filterdoc.hasOwnProperty(id)) {
	    delete filterdoc[id];
	}
	var index = filterdocpids.indexOf(id);
	if (index > -1) {
	    filterdocpids.splice(index, 1);
	}        
	addDoclist();
    });
    
</script>

