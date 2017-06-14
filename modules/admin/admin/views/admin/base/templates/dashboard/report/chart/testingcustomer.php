<?php 
        $admin_users=0;
		$frontend_users=0;
		$facebook_users=0;
		$google_users=0; 
		if(count($this->_getTotalcustomer())){
		foreach($this->_getTotalcustomer() as $customer) {
			 if($customer->user_login_type == 1 ) {
				 $admin_users ++;
			 } 
			 if($customer->user_login_type == 2 ) {
				 $frontend_users ++;
			 } 
			 if($customer->user_login_type == 3 ) {
				 $facebook_users ++;
			 }
			 if($customer->user_login_type == 4 ) {
				 $google_users ++;
			 }  
		} 
}   	?>                         

<div id="basicflot" class="flotChart"></div>
<script>
	jQuery(document).ready(function(){
		var dataSet = [
		{label: "Admin Created Users", data: <?php echo $admin_users;?>, color: "#005CDE" },
		{ label: "Website Users", data: <?php echo $frontend_users;?>, color: "#00A36A" },
		{ label: "Facebook Users", data: <?php echo $facebook_users;?>, color: "#7D0096" },
		{ label: "Google Users", data: <?php echo $google_users;?>, color: "#992B00" }
		];

		var options = {
			series: {
				pie: {
					show: true,
					innerRadius: 0.5,
					label: {
						show: true
					}
				}
			}
		};
		$.plot($("#basicflot"), dataSet, options);
					$('#datepicker3').datepicker({
				yearRange: '1910:<?php echo date("Y");?>',
				changeMonth: true,
				changeYear: true
			});
			$('#datepicker4').datepicker({
				yearRange: '1910:<?php echo date("Y");?>',
				changeMonth: true,
				changeYear: true
			});
			

		
    });
</script>