<?php echo $this->getRootBlock()->createBlock('Front/View/Searchbar')->setTemplate('search/bar')->toHtml(); ?> 
<!-- bread Crumb Start -->
<div class="fixed_outer">
    <div class="fixed_inner">	
	<div class="breadcrumb">
	    <ul>
		<li><a href="#" title="Home">Home</a></li>
		<li><p>Clinics Listing</p></li>
	    </ul>
	</div>	
    </div>
</div>
<!-- bread Crumb End -->
<script type="text/javascript">
    $(document).ready(function(){
	$('.grid_list_button ul li a').click(function(){
	    $('.grid_list_button ul li a').removeClass('active');
	    $(this).addClass('active');
	   
	});
	$('.grid_list_button ul li a.grid_btn').click(function(){
	 $('.full_listing_part').addClass('grid_view');
	});
	$('.grid_list_button ul li a.list_btn').click(function(){
	 $('.full_listing_part').removeClass('grid_view');
	});
    });
</script>
<div class="fixed_outer">
    <div class="fixed_inner">	
	<div class="full_white_box">
	    <div class="listing_head_title">
		<div class="list_search_title">
		    <p>223 matches found for	:</p>
		    <h2>Clinics in Jordan</h2>
		</div>
		<div class="grid_list_button">
		    <ul>
			<li><a href="javascript:;" title="List" class="list_btn active">List</a></li>
			<li><a href="javascript:;" title="Grid" class="grid_btn">Grid</a></li>
		    </ul>
		</div>
	    </div>
	    <!--full listing part start-->
	    <div class="full_listing_part">
		<ul>
		    <li>
			<div class="list_left_image">
			    <div class="image_94">
				<img src="/assets/front/base/images/dummy/clinic_image.jpg" alt="List Image" />
			    </div>
			</div>
			<div class="list_mid_content">
			    <div class="list_title">
				<a href="#" title="Dr Mustafa Stetieh">Mind & Brain Clinic</a>
			    </div>
			    <div class="list_sug_tags">
				<ul>
				    <li><a href="#" title="Homeopathy">Homeopathy</a></li>
				    <li><a href="#" title="Dentist">Dentist</a></li>
				    <li><a href="#" title="Ophthalmologist">Ophthalmologist</a></li>
				</ul>
			    </div>
			    <div class="list_experience">
				<p>Sahakaranagar, Bangalore</p>
			    </div>
			    <div class="list_clinic_facility">
				<ul>  
				    <li><a href="#" title="Deaddiction & Rehabilitation">Deaddiction & Rehabilitation</a></li>
				    <li><a href="#" title=" Emotional and Behavioural Problems"> Emotional and Behavioural Problems</a></li>
				    <li><a href="#" title="Child Guidance Clinic">Child Guidance Clinic</a></li>
				    <li><a href="#" title="Suicide Prevention">Suicide Prevention</a></li>
				    <li><a href="#" title="Counselling & Psychotherapy">Counselling & Psychotherapy</a></li>
				    <li><a href="#" title="Seizure Disorder">Seizure Disorder</a></li>				    
				</ul>
			    </div>			    
			</div>
			<div class="list_right_part">
			    <div class="list_available_time">
				<div class="list_open_day">
				    <span>Mon - Sat</span>
				    <p>7:00AM - 8:00PM</p>
				</div>
				<div class="list_open_time">
				    <span>Sun</span>
				    <p>9:00AM - 2:00PM</p>
				</div>
			    </div>
			    <div class="list_book_appoinment">
				<a href="#" title="View Details">View Details</a>
			    </div>
			</div>
		    </li>
		    <li>
			<div class="list_left_image">
			    <div class="image_94">
				<img src="/assets/front/base/images/dummy/clinic_image.jpg" alt="List Image" />
			    </div>
			</div>
			<div class="list_mid_content">
			    <div class="list_title">
				<a href="#" title="Dr Mustafa Stetieh">Mind & Brain Clinic</a>
			    </div>
			    <div class="list_sug_tags">
				<ul>
				    <li><a href="#" title="Homeopathy">Homeopathy</a></li>
				    <li><a href="#" title="Dentist">Dentist</a></li>
				    <li><a href="#" title="Ophthalmologist">Ophthalmologist</a></li>
				</ul>
			    </div>
			    <div class="list_experience">
				<p>Sahakaranagar, Bangalore</p>
			    </div>
			    <div class="list_clinic_facility">
				<ul>  
				    <li><a href="#" title="Deaddiction & Rehabilitation">Deaddiction & Rehabilitation</a></li>
				    <li><a href="#" title=" Emotional and Behavioural Problems"> Emotional and Behavioural Problems</a></li>
				    <li><a href="#" title="Child Guidance Clinic">Child Guidance Clinic</a></li>
				    <li><a href="#" title="Suicide Prevention">Suicide Prevention</a></li>
				    <li><a href="#" title="Counselling & Psychotherapy">Counselling & Psychotherapy</a></li>
				    <li><a href="#" title="Seizure Disorder">Seizure Disorder</a></li>				    
				</ul>
			    </div>			    
			</div>
			<div class="list_right_part">
			    <div class="list_available_time">
				<div class="list_open_day">
				    <span>Mon - Sat</span>
				    <p>7:00AM - 8:00PM</p>
				</div>
				<div class="list_open_time">
				    <span>Sun</span>
				    <p>9:00AM - 2:00PM</p>
				</div>
			    </div>
			    <div class="list_book_appoinment">
				<a href="#" title="View Details">View Details</a>
			    </div>
			</div>
		    </li>
		    <li>
			<div class="list_left_image">
			    <div class="image_94">
				<img src="/assets/front/base/images/dummy/clinic_image.jpg" alt="List Image" />
			    </div>
			</div>
			<div class="list_mid_content">
			    <div class="list_title">
				<a href="#" title="Dr Mustafa Stetieh">Mind & Brain Clinic</a>
			    </div>
			    <div class="list_sug_tags">
				<ul>
				    <li><a href="#" title="Homeopathy">Homeopathy</a></li>
				    <li><a href="#" title="Dentist">Dentist</a></li>
				    <li><a href="#" title="Ophthalmologist">Ophthalmologist</a></li>
				</ul>
			    </div>
			    <div class="list_experience">
				<p>Sahakaranagar, Bangalore</p>
			    </div>
			    <div class="list_clinic_facility">
				<ul>  
				    <li><a href="#" title="Deaddiction & Rehabilitation">Deaddiction & Rehabilitation</a></li>
				    <li><a href="#" title=" Emotional and Behavioural Problems"> Emotional and Behavioural Problems</a></li>
				    <li><a href="#" title="Child Guidance Clinic">Child Guidance Clinic</a></li>
				    <li><a href="#" title="Suicide Prevention">Suicide Prevention</a></li>
				    <li><a href="#" title="Counselling & Psychotherapy">Counselling & Psychotherapy</a></li>
				    <li><a href="#" title="Seizure Disorder">Seizure Disorder</a></li>				    
				</ul>
			    </div>			    
			</div>
			<div class="list_right_part">
			    <div class="list_available_time">
				<div class="list_open_day">
				    <span>Mon - Sat</span>
				    <p>7:00AM - 8:00PM</p>
				</div>
				<div class="list_open_time">
				    <span>Sun</span>
				    <p>9:00AM - 2:00PM</p>
				</div>
			    </div>
			    <div class="list_book_appoinment">
				<a href="#" title="View Details">View Details</a>
			    </div>
			</div>
		    </li>
		    <li>
			<div class="list_left_image">
			    <div class="image_94">
				<img src="/assets/front/base/images/dummy/clinic_image.jpg" alt="List Image" />
			    </div>
			</div>
			<div class="list_mid_content">
			    <div class="list_title">
				<a href="#" title="Dr Mustafa Stetieh">Mind & Brain Clinic</a>
			    </div>
			    <div class="list_sug_tags">
				<ul>
				    <li><a href="#" title="Homeopathy">Homeopathy</a></li>
				    <li><a href="#" title="Dentist">Dentist</a></li>
				    <li><a href="#" title="Ophthalmologist">Ophthalmologist</a></li>
				</ul>
			    </div>
			    <div class="list_experience">
				<p>Sahakaranagar, Bangalore</p>
			    </div>
			    <div class="list_clinic_facility">
				<ul>  
				    <li><a href="#" title="Deaddiction & Rehabilitation">Deaddiction & Rehabilitation</a></li>
				    <li><a href="#" title=" Emotional and Behavioural Problems"> Emotional and Behavioural Problems</a></li>
				    <li><a href="#" title="Child Guidance Clinic">Child Guidance Clinic</a></li>
				    <li><a href="#" title="Suicide Prevention">Suicide Prevention</a></li>
				    <li><a href="#" title="Counselling & Psychotherapy">Counselling & Psychotherapy</a></li>
				    <li><a href="#" title="Seizure Disorder">Seizure Disorder</a></li>				    
				</ul>
			    </div>			    
			</div>
			<div class="list_right_part">
			    <div class="list_available_time">
				<div class="list_open_day">
				    <span>Mon - Sat</span>
				    <p>7:00AM - 8:00PM</p>
				</div>
				<div class="list_open_time">
				    <span>Sun</span>
				    <p>9:00AM - 2:00PM</p>
				</div>
			    </div>
			    <div class="list_book_appoinment">
				<a href="#" title="View Details">View Details</a>
			    </div>
			</div>
		    </li>
		</ul>
	    </div>
	    <!--full listing part End-->

	    <!--pagination Start-->
	    <div class="general_pagination">
		<ul>
		    <li><a href="#" title="Prev">Prev</a></li>
		    <li  class="active"><a href="#" title="1">1</a></li>
		    <li><a href="#" title="2">2</a></li>
		    <li><a href="#" title="3">3</a></li>				   
		    <li><a href="#" title="4">4</a></li>
		    <li><a href="#" title="Next">Next</a></li>				    
		</ul>

	    </div>
	    <!--pagination End-->
	</div>	
    </div>
</div>
<!-- inner box End -->

