<?php
$_city = $this->getCity();
$_choosedCity = $this->getChoosedCity();
$_choosedArea = $this->getChoosedArea();
$areas = array();
if($_choosedCity && $_choosedCity->getId()) {
	$areas[] = $_choosedCity->getUrl();	
}
if($_choosedArea && $_choosedArea->getId()) {
	$areas[] = $_choosedArea->getUrl();	
} 
?>
<div class="home_right_side_search">
	<h3><?php echo __('Search');?></h3>
		    <p><?php echo __('Appointments in Seconds');?></p>
		    <form action="/search/submitsearch" method="post" id="searchform">
			<ul>
			    <li class="styled-select">
				<select name="city">
					<option value=""><?php echo '--'.__('Select City').'--';?></option>
					<?php if($_city) { foreach($_city as $city):?> 
						<option data-url="<?php echo Arr::get($city,'url');?>"  value="<?php echo Arr::get($city,'city_id');?>" <?php echo $_choosedCity->getId() == Arr::get($city,'city_id')?"selected":"";?>><?php echo Arr::get($city,'city_name');?></option>
					<?php endforeach; } ?>
				</select>
			    </li>
			    <li class="styled-select">
				<select name="area" id="area">
						<option value=""><?php echo '--'.__('Select Area').'--';?></option>
					</select>
			    </li>
			    <li>
					<input type="hidden" name="type" id="type" value="<?php echo $this->getRequest()->param('type');?>" />
				<input type="text" name="keyword" id="search-keyword" value="<?php echo $this->getTerm();?>" placeholder="<?php echo __('Search Doctors, Clinics, Labs....');?>" />
			 
			    </li>
			    <li>
				<input type="submit" value="<?php echo __('Search'); ?>" />
			    </li>
			</ul>
		    </form>
		</div>

<script>
	
	var types = {1: '<?php echo __("Speciality");?>', 2: '<?php echo __("Services");?>', 3: '<?php echo __("Clinic");?>', 4: '<?php echo __("Doctor");?>',5: '<?php echo __("Labs");?>',6 : '<?php echo __("Pharmacy");?>',7 : '<?php echo __("Optics");?>',8 : '<?php echo __("Hospital");?>'};
	var cityurl, dataset = {},urlset = [];
	<?php if(count($areas)):?>
		cityurl = '<?php echo implode("~",$areas);?>';
	<?php endif;?>
	<?php if($_choosedArea && $_choosedArea->getId()):?>
		dataset['area_id'] = <?php echo $_choosedArea->getId();?>; 
	<?php endif;?>
	$("select[name='city']").change(function(){
		dataset['city_id'] = $(this).val(); 
		cityurl = $('option:selected',this).data('url'); 
		$.ajax({
			url : '<?php echo $this->getUrl('search/area');?>',
			type : 'get',
			data : dataset,
			dataType: 'json',
			beforeSend: function(){
				$('#area option:first').text('<?php echo __("Loading").'...'; ?>');
			},
			success : function(res){ 
				var option = '<option value=""><?php echo __('- Select area -');?></option>';
				$.each(res, function(k,f){
					option += '<option '+(f.selected ? 'selected':'')+' data-url="'+f.url+'" value="'+f.id+'">'+f.name+'</option>';
				});
				$("#area").html(option);
			}
		});
	});
	$("select[name='area']").on('change',function(){ 
		cityurl += "~"+$('option:selected',this).data('url');
	});
	<?php if($_choosedCity && $_choosedCity->getId()):?>
		$("select[name='city']").change();
	<?php endif;?>
	$('#search-keyword').autocompletesingle({	  
		valueKey:'term',
		titleKey:'term',
		fortabibakjo : true,
		source:[{
			url:'<?php echo $this->getUrl("search/suggestions");?>?q=%QUERY%',	 
			type:'remote',
			getTitle:function(item){	 		
				return item['term']
			},
			getValue:function(item){ 
				return item['term']
			}
		}],
		itemStyle: {
			'font':'normal 12px/20px OpenSansRegular'
		},
		render : function (item, source, pid, query) {
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
								<?php if(App::getCurrentLang()->getId() == 1){ ?>
									highlighted += '<b>';
								<?php } ?>
							} else if (h === '>') {
								<?php if(App::getCurrentLang()->getId() == 1){ ?>
									highlighted += '</b>';
								<?php } ?>	
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
							' </span><span class="wh-type">'+(types[item['type']]!== 'undefined' ? types[item['type']].toUpperCase():'OTHER')+'</span>'+
						'</div>';
			}
		}).on('selected.xdsoft',function(e,datum){
		  
			var urltype = '';
			switch(datum.type) {
				case "1": 
				case "4":
					urltype='doctor';
				break;
				case "3":
					urltype='clinic';
				break;
				case "6":
					urltype='pharmacy';
				break;
				case "5":
					urltype='labs';
				break;
				case "7":
					urltype='optics';
				break;
				case "8":
					urltype='hospital';
				break;
			}
			var url = sitedata.FRONTEND+'search/';
			<?php if(count($areas)):?>
				url+= '<?php echo implode("~",$areas);?>/';
			<?php else:?> 
				if (typeof cityurl!=='undefined') {
					url += cityurl+"/";
				}
				
			<?php endif;?> 
			if (urltype) {
				url += urltype+"/";
			} 
			url +='q/'+datum.url;
			window.location.href = url; 
	});
	$("#searchform").submit(function(){
		if ($("#search-keyword").val() == '') {
			$("#search-keyword").focus();
			return false;
		}
	});
</script>
