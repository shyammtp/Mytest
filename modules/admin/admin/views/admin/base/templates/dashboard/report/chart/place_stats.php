<div id="place_chart" ></div>

<?php


	$month_list = array(); $date = ''; $A = array(); $company_val = 0; $B = array(); $store_val = 0; $C = array(); $education_val = 0;
	$company = $this->_getCompany();
	if(count($company) > 0){
		for($i=0;$i<=11;$i++) {
			foreach($company as $val){
				$created_date = strtotime($val->created_date);
				$start = strtotime(date("Y-m-1", strtotime("-$i month", strtotime(date("F") . "1")) )) ;
				$end = strtotime(date("Y-m-t", strtotime("-$i month", strtotime(date("F") . "1")) )) ;
				$date = date("M/Y", strtotime("-$i month", strtotime(date("F") . "1")) ) ;
				if(($start <= $created_date) && ( $end >= $created_date)) {
						$company_val++;
				}
			}
			$A[] = $company_val; 
			$month_list[] = (string)$date;
			$company_val = 0;
		}
	} 
	
	$store = $this->_getStore();
	if(count($store) > 0){
		for($i=0;$i<=11;$i++) {
			foreach($store as $val){
				$created_date = strtotime($val->created_date);
				$start = strtotime(date("Y-m-1", strtotime("-$i month", strtotime(date("F") . "1")) )) ;
				$end = strtotime(date("Y-m-t", strtotime("-$i month", strtotime(date("F") . "1")) )) ;
				$date = date("M/Y", strtotime("-$i month", strtotime(date("F") . "1")) ) ;
				if(($start <= $created_date) && ( $end >= $created_date)) {
						$store_val++;
				}
			}
			$B[] = $store_val; 
			$month_list[] = (string)$date;
			$store_val = 0;
		}
	}
	
	$education = $this->_getEducation();
	if(count($education) > 0){
		for($i=0;$i<=11;$i++) {
			foreach($education as $val){
				$created_date = strtotime($val->created_date);
				$start = strtotime(date("Y-m-1", strtotime("-$i month", strtotime(date("F") . "1")) )) ;
				$end = strtotime(date("Y-m-t", strtotime("-$i month", strtotime(date("F") . "1")) )) ;
				$date = date("M/Y", strtotime("-$i month", strtotime(date("F") . "1")) ) ;
				if(($start <= $created_date) && ( $end >= $created_date)) {
						$education_val++;
				}
			}
			$C[] = $education_val; 
			$month_list[] = (string)$date;
			$education_val = 0;
		}
	}
	
	
	$order_date = array();$BN = 0; $company_val1 = array(); 

	$previous_week = strtotime("-1 week +7 day");
	$start_week = strtotime("last sunday midnight",$previous_week);
	$end_week = strtotime("next saturday",$start_week);
	$from = date("Y-m-d",$start_week);
	$to = date("Y-m-d",$end_week);

	
	
	$weeks = $this->year_month($from,$to);
	foreach($weeks as $y => $week) {
		foreach($week as $val) {
			$dates = $this->getStartAndEndDate($val,$y);
			$datesto = $this->getStartAndEndDate($val,$y,false);
			foreach($this->_getCompany() as $order) {
				$createddate = strtotime($order->created_date);
				if(($dates[0] <= $createddate) && ( $dates[1] >= $createddate)) {
						$BN++;

				}
			}
			$order_date[] = implode(" - ",$datesto);
			$company_val1[] =  $BN; 
			$BN = 0;
		}
	}
?>

<script>
		
	$('#place_chart').highcharts({

		chart: {
			type: 'column'
		},
		title: {
			text: '<?php echo __("Place Statistics"); ?>'
		},
		xAxis: {
			categories: <?php if($this->getRequest()->query('time')==2) {  echo json_encode($order_date); } else {  echo json_encode($month_list); }  ?>,
		},
		yAxis: {
			min: 0,
			title: {
				text: ''
			},
		},
		tooltip: {
			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat:  '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
						  '<td style="padding:0"><b>{point.y:1f}</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
		exporting: { enabled: false },
		credits: { enabled: false },
		series: [{
			name: '<?php echo __("Company"); ?>',
			data:  <?php if($this->getRequest()->query('time')==2) {  echo json_encode($company_val1); } else { echo json_encode($A);  }   ?>
		}
		]
	});
</script>