<?php 
$storelogo = App::getConfig('STOREADMIN_LOGO',$this->getPlace()->getId()); 
?>
<div class="row">
    <div class="col-sm-4 col-md-3">
        <div class="text-center">
        	<?php if($storelogo): $storgeimg = App::helper('image')->getResizeImage('w200',$storelogo); ?>
            	<img src="<?php echo $storgeimg;?>" class="img-responsive img-profile" alt="" />
       	 	<?php endif;?>
            <h4 class="profile-name mb5"><?php echo $this->getPlace()->getPlaceName();?></h4>
            <div><i class="fa fa-map-marker"></i> San Francisco, California, USA</div>
            <div><i class="fa fa-briefcase"></i> Software Engineer at <a href="#">Company, Inc.</a></div>
        
            <div class="mb20"></div>
        
            <div class="btn-group">
                <button class="btn btn-primary btn-bordered">Following</button>
                <button class="btn btn-primary btn-bordered">Followers</button>
            </div>
        </div><!-- text-center -->
        
        <br />
      
        <h5 class="md-title">About</h5>
        <p class="mb30">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitat... <a href="#">Show More</a></p>
      
        <h5 class="md-title">Connect</h5>
        <ul class="list-unstyled social-list">
            <li><i class="fa fa-twitter"></i> <a href="#">twitter.com/eileensideways</a></li>
            <li><i class="fa fa-facebook"></i> <a href="#">facebook.com/eileen</a></li>
            <li><i class="fa fa-youtube"></i> <a href="#">youtube.com/eileen22</a></li>
            <li><i class="fa fa-linkedin"></i> <a href="#">linkedin.com/4ever-eileen</a></li>
            <li><i class="fa fa-pinterest"></i> <a href="#">pinterest.com/eileen</a></li>
            <li><i class="fa fa-instagram"></i> <a href="#">instagram.com/eiside</a></li>
        </ul>
      
        <div class="mb30"></div>
      
        <h5 class="md-title">Address</h5>
        <address>
            795 Folsom Ave, Suite 600<br>
            San Francisco, CA 94107<br>
            <abbr title="Phone">P:</abbr> (123) 456-7890
        </address>
      
    </div><!-- col-sm-4 col-md-3 -->
    
    <div class="col-sm-8 col-md-9">
      
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-line">
            <li class="active"><a href="#activities" data-toggle="tab"><strong>Technical Information</strong></a></li>
            <li><a href="#followers" data-toggle="tab"><strong>Owner</strong></a></li>
            <li><a href="#following" data-toggle="tab"><strong>Activity Log</strong></a></li>
            <li><a href="#events" data-toggle="tab"><strong>Transaction History</strong></a></li>
        </ul>
    
        <!-- Tab panes -->
        <div class="tab-content nopadding noborder">
            <div class="tab-pane active" id="activities">
            	<p>Your api key and id are to used in your website integration with CPAY</p>
               <div class="table-responsive col-sm-6">
	              <table class="table table-bordered mb30"> 
	              	<colgroup>
	              		<col width="20%" />
	              		<col width="80%" />
	              	</colgroup>
	                <tbody>
	                  <tr>
	                    <td>Api ID</td>
	                    <td>Mark</td> 
	                  </tr>
	                  <tr>
	                    <td>Api Key</td>
	                    <td>Jacob</td> 
	                  </tr>
	                  <tr>
	                    <td>3</td>
	                    <td>Larry</td> 
	                  </tr>
	                </tbody>
	              </table>
	              </div> 
            </div><!-- tab-pane -->
            
            <div class="tab-pane" id="followers">
        
                <div class="follower-list">
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object img-circle" src="holder.js/100x100.html" alt="" />
                        </a>
                        <div class="media-body">
                            <h3 class="follower-name">Ray Sin</h3>
                            <div><i class="fa fa-map-marker"></i> San Francisco, California, USA</div>
                            <div><i class="fa fa-briefcase"></i> Software Engineer at <a href="#">SomeCompany, Inc.</a></div>
              
                            <div class="mb20"></div>
              
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button class="btn btn-dark btn-xs"><i class="fa fa-envelope-o"></i> Send Message</button>
                                </div><!-- btn-group -->
                                <div class="btn-group">
                                    <button class="btn btn-white btn-xs"><i class="fa fa-check"></i> Following</button>
                                    <button class="btn btn-white btn-xs"><i class="fa fa-check"></i> Followers</button>
                                </div><!-- btn-group -->
                                
                            </div><!-- btn-toolbar -->
                        </div><!-- media-body -->
                    </div><!-- media -->
                    
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object img-circle" src="holder.js/100x100.html" alt="" />
                        </a>
                        <div class="media-body">
                            <h3 class="follower-name">Weno Carasbong</h3>
                            <div><i class="fa fa-map-marker"></i> Cebu City, Philippines</div>
                            <div><i class="fa fa-briefcase"></i> Software Engineer at <a href="#">ITCompany, Inc.</a></div>
              
                            <div class="mb20"></div>
              
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button class="btn btn-dark btn-xs"><i class="fa fa-envelope-o"></i> Send Message</button>
                                </div><!-- btn-group -->
                                <div class="btn-group">
                                    <button class="btn btn-white btn-xs"><i class="fa fa-check"></i> Following</button>
                                    <button class="btn btn-white btn-xs"><i class="fa fa-check"></i> Followers</button>
                                </div><!-- btn-group -->
                            </div><!-- btn-toolbar -->
                        </div><!-- media-body -->
                    </div><!-- media -->
          
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object img-circle" src="holder.js/100x100.html" alt="" />
                        </a>
                        <div class="media-body">
                            <h3 class="follower-name">Nusja Nawancali</h3>
                            <div class="profile-location"><i class="fa fa-map-marker"></i> Madrid, Spain</div>
                            <div class="profile-position"><i class="fa fa-briefcase"></i> CEO at <a href="#">SomeCompany, Inc.</a></div>
              
                            <div class="mb20"></div>
              
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button class="btn btn-dark btn-xs"><i class="fa fa-envelope-o"></i> Send Message</button>
                                </div><!-- btn-group -->
                                <div class="btn-group">
                                    <button class="btn btn-white btn-xs"><i class="fa fa-check"></i> Following</button>
                                    <button class="btn btn-white btn-xs"><i class="fa fa-check"></i> Followers</button>
                                </div><!-- btn-group -->
                            </div><!-- btn-toolbar -->
                        </div><!-- media-body -->
                    </div><!-- media -->
          
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object img-circle" src="holder.js/100x100.html" alt="" />
                        </a>
                        <div class="media-body">
                            <h3 class="follower-name">Zaham Sindilmaca</h3>
                            <div><i class="fa fa-map-marker"></i> Bangkok, Thailand</div>
                            <div><i class="fa fa-briefcase"></i> Java Developer at <a href="#">ITCompany, Inc.</a></div>
              
                            <div class="mb20"></div>
              
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button class="btn btn-dark btn-xs"><i class="fa fa-envelope-o"></i> Send Message</button>
                                </div><!-- btn-group -->
                                <div class="btn-group">
                                    <button class="btn btn-white btn-xs"><i class="fa fa-check"></i> Following</button>
                                    <button class="btn btn-white btn-xs"><i class="fa fa-check"></i> Followers</button>
                                </div><!-- btn-group -->
                            </div><!-- btn-toolbar -->
                        </div><!-- media-body -->
                    </div><!-- media -->
          
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object img-circle" src="holder.js/100x100.html" alt="" />
                        </a>
                        <div class="media-body">
                            <h3 class="follower-name">Christopher Atam</h3>
                            <div class="profile-location"><i class="fa fa-map-marker"></i> Tokyo, Japan</div>
                            <div class="profile-position"><i class="fa fa-briefcase"></i> QA Engineer at <a href="#">SomeCompany, Inc.</a></div>
              
                            <div class="mb20"></div>
              
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button class="btn btn-dark btn-xs"><i class="fa fa-envelope-o"></i> Send Message</button>
                                </div><!-- btn-group -->
                                <div class="btn-group">
                                    <button class="btn btn-white btn-xs"><i class="fa fa-check"></i> Following</button>
                                    <button class="btn btn-white btn-xs"><i class="fa fa-check"></i> Followers</button>
                                </div><!-- btn-group -->
                            </div><!-- btn-toolbar -->
                        </div><!-- media-body -->
                    </div><!-- media -->
          
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object img-circle" src="holder.js/100x100.html" alt="" />
                        </a>
                        <div class="media-body">
                            <h3 class="follower-name">Venro Leonga</h3>
                            <div class="profile-location"><i class="fa fa-map-marker"></i> Paris, France</div>
                            <div class="profile-position"><i class="fa fa-briefcase"></i> UX Designer at <a href="#">ITCompany, Inc.</a></div>
              
                            <div class="mb20"></div>
              
                            <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button class="btn btn-dark btn-xs"><i class="fa fa-envelope-o"></i> Send Message</button>
                                </div><!-- btn-group -->
                                <div class="btn-group">
                                    <button class="btn btn-white btn-xs"><i class="fa fa-check"></i> Following</button>
                                    <button class="btn btn-white btn-xs"><i class="fa fa-check"></i> Followers</button>
                                </div><!-- btn-group -->
                            </div><!-- btn-toolbar -->
                        </div><!-- media-body -->
                    </div><!-- media -->  
                </div><!--follower-list -->
            </div><!-- tab-pane -->
            
            <div class="tab-pane" id="following">
        
                <div class="activity-list">
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object img-circle" src="images/photos/user2.png" alt="" />
                        </a>
                    <div class="media-body">
                        <strong>Chris Anthemum</strong> liked a photos<br />
                        <small class="text-muted">Today at 12:30pm</small>
              
                        <ul class="uploadphoto-list">
                            <li><a href="images/photos/media5.png" data-rel="prettyPhoto"><img src="images/photos/media5.png" class="thumbnail img-responsive" alt="" /></a></li>
                            <li><a href="images/photos/media4.png" data-rel="prettyPhoto"><img src="images/photos/media4.png" class="thumbnail img-responsive" alt="" /></a></li>
                        </ul>
                    </div>
                </div><!-- media -->
          
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object img-circle" src="images/photos/user1.png" alt="" />
                    </a>
                    <div class="media-body">
                        <strong>Ray Sin</strong> is now following to <strong>Chris Anthemum</strong>. <br />
                        <small class="text-muted">Yesterday at 1:30pm</small>
                    </div><!-- media-body -->
                </div><!-- media -->
          
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object img-circle" src="images/photos/user4.png" alt="" />
                    </a>
                    <div class="media-body">
                        <strong>Frank Furter</strong> is now following to <strong>Ray Sin</strong>. <br />
                        <small class="text-muted">3 days ago at 1:30pm</small>
                    </div>
                </div><!-- media -->
          
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object img-circle" src="images/photos/user2.png" alt="" />
                    </a>
                    <div class="media-body">
                        <strong>Chris Anthemum</strong> liked a photos<br />
                        <small class="text-muted">5 days ago at 12:30pm</small>
              
                        <ul class="uploadphoto-list">
                            <li><a href="images/photos/media6.png" data-rel="prettyPhoto"><img src="images/photos/media6.png" class="thumbnail img-responsive" alt="" /></a></li>
                            <li><a href="images/photos/media7.png" data-rel="prettyPhoto"><img src="images/photos/media7.png" class="thumbnail img-responsive" alt="" /></a></li>
                            <li><a href="images/photos/media2.png" data-rel="prettyPhoto"><img src="images/photos/media2.png" class="thumbnail img-responsive" alt="" /></a></li>
                        </ul>
                    </div><!-- media-body -->
                </div><!-- media -->
          
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object img-circle" src="images/photos/user1.png" alt="" />
                    </a>
                    <div class="media-body">
                        <strong>Nusja Nawancali</strong> is now following to <strong>Zaham Sindilmaca</strong>. <br />
                        <small class="text-muted">December 25 at 1:30pm</small>
                    </div><!-- media-body -->
                </div><!-- media -->
          
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object img-circle" src="images/photos/user4.png" alt="" />
                    </a>
                    <div class="media-body">
                        <strong>Frank Furter</strong> is now following to <strong>Zaham Sindilmaca</strong>. <br />
                        <small class="text-muted">December 24 at 1:30pm</small>
                    </div><!-- media-body -->
                </div><!-- media -->
          
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object img-circle" src="images/photos/user3.png" alt="" />
                    </a>
                    <div class="media-body">
                        <strong>Nusja NawanCali</strong> posted a new blog. <br />
                        <small class="text-muted">December 23 at 3:18pm</small>
                  
                        <div class="media blog-media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="images/photos/media3.png" alt="" />
                            </a>
                            <div class="media-body">
                                <h4 class="media-title"><a href="#">Ut Enim Ad Minim Veniam</a></h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat... <a href="#">Read more</a></p>
                            </div><!-- media-body -->
                        </div><!-- media -->
                    </div><!-- media-body -->
                </div><!-- media -->
          
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object img-circle" src="images/photos/user4.png" alt="" />
                    </a>
                    <div class="media-body">
                        <strong>Mark Zonsion</strong> is now following to <strong>Weno Carasbong</strong>. <br />
                        <small class="text-muted">December 23 at 1:30pm</small>
                    </div><!-- media-body -->
                </div><!-- media -->
          
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object img-circle" src="images/photos/user4.png" alt="" />
                    </a>
                    <div class="media-body">
                        <strong>Frank Furter</strong> is now following to <strong>Weno Carasbong</strong>. <br />
                        <small class="text-muted">December 20 at 4:30pm</small>
                    </div><!-- media-body -->
                </div><!-- media -->
          
            </div><!-- activity-list -->
            <button class="btn btn-white btn-block">Show More</button>
        </div><!-- tab-pane -->
        
        <div class="tab-pane" id="events">
            <div class="events">
                <h5 class="lg-title mb20">Upcoming Events</h5>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object thumbnail" src="holder.js/100x120.html" alt="" />
                            </a>
                            <div class="media-body">
                                <h4 class="event-title"><a href="#">Free Living Trust Seminar</a></h4>
                                <small class="text-muted"><i class="fa fa-map-marker"></i> Silicon Valley, San Francisco, CA</small>
                                <small class="text-muted"><i class="fa fa-calendar"></i> Sunday, January 15, 2014 at 11:00am</small>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor...</p>
                            </div>
                        </div><!-- media -->
                    </div><!-- col-sm-6 -->
            
                    <div class="col-sm-6">
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object thumbnail" src="holder.js/100x120.html" alt="" />
                            </a>
                            <div class="media-body">
                                <h4 class="event-title"><a href="#">Serious Games Seminar</a></h4>
                                <small class="text-muted"><i class="fa fa-map-marker"></i> New York City</small>
                                <small class="text-muted"><i class="fa fa-calendar"></i> Monday, January 14, 2014 at 8:00am</small>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor...</p>
                            </div>
                        </div><!-- media -->
                    </div><!-- col-sm-6 -->
            
                    <div class="col-sm-6">
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object thumbnail" src="holder.js/100x120.html" alt="" />
                            </a>
                            <div class="media-body">
                                <h4 class="event-title"><a href="#">Travel &amp; Adventure Show</a></h4>
                                <small class="text-muted"><i class="fa fa-map-marker"></i> Los Angeles, CA</small>
                                <small class="text-muted"><i class="fa fa-calendar"></i> Friday, January 12, 2014 at 8:00am</small>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor...</p>
                            </div>
                        </div><!-- media -->
                    </div><!-- col-sm-6 -->
            
                    <div class="col-sm-6">
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object thumbnail" src="holder.js/100x120.html" alt="" />
                            </a>
                            <div class="media-body">
                                <h4 class="event-title"><a href="#">Mobile Games Summit</a></h4>
                                <small class="text-muted"><i class="fa fa-map-marker"></i> Bay Area, San Francisco</small>
                                <small class="text-muted"><i class="fa fa-calendar"></i> Saturday, January 10, 2014 at 8:00am</small>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor...</p>
                            </div>
                        </div><!-- media -->
                    </div><!-- col-sm-6 -->
                </div><!-- row -->
          
                <br />
          
                <h5 class="lg-title mb20">Past Events</h5>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object thumbnail" src="holder.js/100x120.html" alt="" />
                            </a>
                            <div class="media-body">
                                <h4 class="event-title"><a href="#">Free Living Trust Seminar</a></h4>
                                <small class="text-muted"><i class="fa fa-map-marker"></i> Silicon Valley, San Francisco, CA</small>
                                <small class="text-muted"><i class="fa fa-calendar"></i> Sunday, January 15, 2014 at 11:00am</small>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor...</p>
                            </div>
                        </div><!-- media -->
                    </div><!-- col-sm-6 -->
            
                    <div class="col-sm-6">
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object thumbnail" src="holder.js/100x120.html" alt="" />
                            </a>
                            <div class="media-body">
                                <h4 class="event-title"><a href="#">Serious Games Seminar</a></h4>
                                <small class="text-muted"><i class="fa fa-map-marker"></i> New York City</small>
                                <small class="text-muted"><i class="fa fa-calendar"></i> Monday, January 14, 2014 at 8:00am</small>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor...</p>
                            </div>
                        </div><!-- media -->
                    </div><!-- col-sm-6 -->
            
                    <div class="col-sm-6">
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object thumbnail" src="holder.js/100x120.html" alt="" />
                            </a>
                            <div class="media-body">
                                <h4 class="event-title"><a href="#">Travel &amp; Adventure Show</a></h4>
                                <small class="text-muted"><i class="fa fa-map-marker"></i> Los Angeles, CA</small>
                                <small class="text-muted"><i class="fa fa-calendar"></i> Friday, January 12, 2014 at 8:00am</small>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor...</p>
                            </div>
                        </div><!-- media -->
                    </div><!-- col-sm-6 -->
            
                    <div class="col-sm-6">
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object thumbnail" src="holder.js/100x120.html" alt="" />
                            </a>
                            <div class="media-body">
                                <h4 class="event-title"><a href="#">Mobile Games Summit</a></h4>
                                <small class="text-muted"><i class="fa fa-map-marker"></i> Bay Area, San Francisco</small>
                                <small class="text-muted"><i class="fa fa-calendar"></i> Saturday, January 10, 2014 at 8:00am</small>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor...</p>
                            </div>
                        </div><!-- media -->
                    </div><!-- col-sm-6 -->
                </div><!-- row -->
            </div><!-- events -->
        </div><!-- tab-pane -->
        
    </div><!-- tab-content -->
      
    </div><!-- col-sm-9 -->
</div><!-- row -->  
                     