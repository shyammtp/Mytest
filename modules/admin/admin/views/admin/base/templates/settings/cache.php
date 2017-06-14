<style>
	.panel-drop { 
   background: white;
   -moz-box-shadow: 3px 3px 0 rgba(12,12,12,0.03);
   -webkit-box-shadow: 3px 3px 0 rgba(12,12,12,0.03);
   box-shadow: 3px 3px 0 rgba(12,12,12,0.03);    border: 1px solid rgba(0,0,0,.15);
   text-align: center;
   }
   .panel-drop h1 {font-size:28px;}
   .panel-drop .panel-heading{ background: white;}
   .panel-drop .panel-icon-p2{font-size:50px; text-align: center;}
</style> 
<script>
	var htm = '<div class="alert alert-info"> \
				<div>Download the sample CSV document by clicking below link <br/>\
				<p class="hint"></p>\
				<a id="sample-xl" download>Download Sample</a></div>\
				</div>';
	$(function(){
		$("#import-sel").select2();
		$("#imp-btn").click(function(e){
			e.preventDefault();
			$("#import-dafo").submit();
			$(this).attr('disabled',true);
		});
		$("#import-sel").change(function(){
			var val = $('option:selected',this).attr('data-file');
			if (val) {
				var html = $(htm);
				$("#import-sam").html(html);
				var href = baseUrl+"uploads/import/samples/"+val+".csv";
				html.find('a').attr('href',href);
				if ($('option:selected',this).attr('data-hint')) {
					html.find('.hint').html($('option:selected',this).attr('data-hint'));
				}
			} else {
				$("#import-sam").html('');
				
			}
		});
	});
	
	
	
</script>
 
<div class="alert alert-info"> 
	<p>Note: Do not do anything here without a administrator knowledge!!!</p>
</div>

<?php
$session = App::model('admin/session');
$errormsg = $session->getData('import_error_msg'); 
$successmsg = $session->getData('import_success_msg');
$session->unsetData('import_error_msg');
$session->unsetData('import_success_msg');
?>
<?php if($errormsg):?>
	<div class="alert alert-info"> 
		<?php echo $errormsg;?>
	</div>
<?php endif;?>

<?php if($successmsg):?>
	<div class="alert alert-info"> 
		<?php echo $successmsg;?>
	</div>
<?php endif;?>
<form method="post" id="import-dafo" enctype="multipart/form-data" action="<?php echo $this->getUrl('admin/import/load',array('_sl' => 'indi','type' => 'Searchfront'));?>">
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"> 
				<h4 class="panel-title"><?php echo __('Import Data');?></h4>
				<p><?php echo __('Import data into the DB Collection');?>.</p>
			</div><!-- panel-heading -->
			<div class="panel-body"> 
					<div class="row row-stat">
						<div class="form-group">
							<div class="controls"> 	 
								<select id="import-sel" name="type" style="width:100%;" title="" class="select2-offscreen" tabindex="-1">
								   <option value="">Select a value</option>
										<option value="user::importData" data-file="user_importData" data-hint="Text Delimiter is ; and Field delimiter is double quotes">Doctor</option>
										<option value="admin_department::importData" data-file="department_importData" data-hint="Text Delimiter is ; and Field delimiter is double quotes">Department</option>
										<option value="admin_insurance::importData" data-file="insurance_importData" data-hint="Text Delimiter is ; and Field delimiter is double quotes">Insurance</option>
										<option value="admin_clinic::importData" data-file="Medical_importData"  data-hint="Text Delimiter is ; and Field delimiter is double quotes">Medical Places</option>
										<option value="core_city::importData" data-file="City_importData"  data-hint="Text Delimiter is ; and Field delimiter is double quotes">City</option>
										<option value="core_area::importData" data-file="Area_importData"  data-hint="Text Delimiter is ; and Field delimiter is double quotes">Area</option>
							   </select> 
							</div>
						</div>
						<div id="import-sam"></div>
						
						<div class="form-group"> 
							<div class="controls"> 	 
								 <input type="file" name="file">
									<span class="help-text">format supported *.csv only</span>
							</div>
						</div>
						
						<div class="form-group"> 
							<div class="clearfix pull-right mt20">
									<button type="submit" id="imp-btn" class="btn btn-primary btn-block" href=""><?php echo __('Upload');?></button>
							</div> 
						</div>
						
					</div>
				</div>
			</div>
		</div>
</div>
</form>
