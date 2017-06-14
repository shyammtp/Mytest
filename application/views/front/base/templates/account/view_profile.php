
<?php  if(App::model('user/session')->isLoggedIn()) { ?>
<?php $customer = App::model('user/session')->getCustomer(); 
$contactDetails = $this->getUsers()->getContactDetails();
$countryData = App::model('location/country',false)->getCountryInfoForOther(App::getCurrentLanguageId());
$countrycode = array(); 
foreach($countryData->as_array() as $country) {
	$countrycode[$country['country_id']] = array('name' => $country['country_name']."(+".$country['country_code'].")",'iso_code' => $country['iso_code_short'],'country_code' => $country['country_code']);
} ?>
<div id="minheight"> 
	 <!-- Profile Middle --> 
			<?php echo $this->getRootBlock()->createBlock('Front/Account/Progressbar')->setTemplate('account/progress_bar')->setUsers($this->getUsers())->toHtml();?> 
	 <div class="profile_inner">
	 <div class="profile_heads">
		<h3 id="username"><?php echo $customer->getData('first_name'); ?></h3> 
		<a class="edit_sym fa fa-pencil" title="<?php echo __('Edit'); ?>" id="edit_username" href="#editprofile"></a>
	 </div>
	 <div class="clearfix"></div>
	 <div class="profile_images">
	
		<div class="epfset"  style="height:210px;">
			<div id="viewform" class="box-transition viewform"><?php echo __('Loading...'); ?></div> 
			<div id="editform" class="box-transition edform hideme"><?php echo __('Loading...'); ?></div> 
			<div id="change_password" class="cpform box-transition hideme"><?php echo __('Loading...'); ?></div>
		</div>

		 </div>
	 </div> 
	 <!-- Profile Middle -->
	 
	 
	<?php } ?>				
</div>

<?php $profileimage = $this->getUsers()->getProfileImageUrl(200,200);
$profileimage = ($profileimage) ? $profileimage : $this->getAssetsPathUrl('images/default_avatar_male.jpg'); ?>
<script>
	require(['edit_profile'], function (site) {
		require(['Controller:account/viewprofile'],function(mae){
			
				var token = {'token':'<?php echo $this->getUsers()->getData("user_token");?>'};
				var user_id = {'user_id':'<?php echo $this->getUsers()->getUserId();?>'};
				var view = new mae.ved($.extend(token,{'router':mae.route})), cview = new mae.vch($.extend(token,{'router':mae.route,'user_id':'<?php echo $this->getUsers()->getUserId();?>'}));
				cview.renders();
				view.model.fetch({
					success:_.bind(function(response){ 
				
						view.model.set("date_of_birth" ,'<?php echo Date::formatted_time($this->getUsers()->getDateOfBirth(),'Y/m/d');?>'); 
						view.model.set("first_name" ,{'1': '<?php echo $this->getUsers()->getData('first_name',1);?>'});
						view.model.set("countrycode",<?php echo json_encode($countrycode);?>);
						view.model.set("profession",<?php echo json_encode($this->getUserProfessionOptions());?>);
						view.model.set("city",<?php echo json_encode($this->getUserCityOptions());?>);
						view.model.set("profileimage",<?php echo json_encode($profileimage);?>);
						console.log(response);
						var view_profile= new mae.vp({model:view.model});
						view_profile.render();
						require(['upload'], function (site) {
							new AjaxUpload('#files11', {
								action:'<?php echo $this->getUrl('account/profile_picture/',array('user_token'=>$this->getUsers()->getData('user_token'),'id'=>$this->getUsers()->getUserId(),'imagename'=>'profile_picture'));?>',
								name: 'profile_picture',
								autoSubmit: true,
								responseType: 'json',
								data:{},
								onChange: function(file, extension){
								},
								onSubmit: function(file, extension) {
								var allowedextension = ['jpg','jpeg','gif','png'];
								if(allowedextension.indexOf(extension.toLowerCase()) < 0)
									{
									require(['NotificationFX'],function(n){ n.notify('allowed extension jpg, jpeg, gif, png','error').show(); })
									return false;
									}
								},
								onComplete: function(file, response) {
									var img = "<?php echo App::getBaseUrl('uploads').'cache/uploads/cache/';?>thumb_200x200/uploads/user/profile/"+response.file+"";
									$('#profile_images').attr("src",img);
									require(['NotificationFX'],function(n){ n.notify(response.json,'success').show(); })
								}
							});
						}); 
						view.renders();      
						$('#switch-accc').popover({
							html : true,
							container:'body',
							title:'',
							template : '<div class="popover switch-acc-content accont_proff" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
							content: function() {
								return $("#switch-acc-contentt").html();
							}
						});		
						$('#addmobile').on('click', function(ev) {
								alert('in');
						});
						$('#datepicker').datepicker({								
							yearRange: '<?php echo date("Y")-100;?>:<?php echo date("Y")-10;?>',
							changeMonth: true,
							changeYear: true
						});
						/*$('#datepicker').datepicker().on('changeDate', function(ev) {
							$('#datepicker').val = new Date(ev.date);
						});
						*/
						
						 
					}
					,view.model) 
				});  
				Backbone.history.start();
				});
				require(['View:account/progressbar'],function(mae){
					var progressview = new mae();
					progressview.model.set('users',<?php echo json_encode($this->getUsers()->getData());?>)
				    progressview.renders();
				});
			});
			 function addAdditionalMobile()
			 { 
				 var mobile = $('#additional_mobile_number').val();
				 alert(mobile); 
			 } 
</script>
	      <div id="switch-acc-contentt" style="display:none;">
		<div id="ademail-popover-head">
		<?php echo __('Add more mobile numbers');?>
        </div>
        <form method="post" id="additional_mobile_form">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-sm-12">
							<input class="form-control" type="text" id="additional_mobile_number" name="additional_mobile_number">
                         <div class="ame errors"></div>
                        </div>
                    </div><!-- form-group -->
                </div>

            </div>
            <div class="row">
                <div class="pull-right">
                    <span class="no-display" id="loader-addmobile"><img alt="" src=""></span>
                    <button class="btn btn-primary mr5 add-mobile" id="addmobile" onclick="addAdditionalMobile();" type="button"><?php echo __('Save'); ?></button>
                    <button type="button"  class="btn btn-default" onclick="$('#switch-accc').popover('hide');"><?php echo __('Cancel'); ?></button>
                </div>
            </div>
        </form>
	</div> 



