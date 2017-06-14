<?php
$user = $this->getUsers();
$contactDetails = $user->getContactDetails();
$thumbimage = $user->getProfileImageUrl(200,200);
$connect = array();
if($c = $user->getFacebookPage()) {
    $connect['facebook'] = $c;
}
if($c = $user->getTwitterPage()) {
    $connect['twitter'] = $c;
}
if($c = $user->getInstagramPage()) {
    $connect['instagram'] = $c;
}
$i = 0;
$html = '';
$contacts = $user->getAllContactDetails();
$activities = $this->getActivities();
$emails = $user->getAdditionalEmails(); 
?>
<div class="row">
    <div class="col-sm-4 col-md-3">
        <div class="text-center">
            <?php if($thumbimage):?>
                <img src="<?php echo $thumbimage;?>" class="img-circle img-offline img-responsive img-profile" alt=""  />
            <?php else:?>
                <img class="img-circle" src="<?php echo $this->getAssetsPathUrl('images/default_avatar_male.jpg');?>" alt="" >
            <?php endif;?>
            <h4 class="profile-name mb5"><i class="fa <?php echo $user->getGender() == 'M' ? "fa-male":"fa-female";?>" title="<?php echo $user->getGender() == 'M' ? "Male":"Female";?>"></i>&nbsp;<?php echo $user->getFirstName();?></h4>

            <div><i class="fa fa-envelope-o"></i> <?php echo $user->getPrimaryEmailAddress();?></div>

            <?php if($this->getUsers()->getData('resident_location')):?>
            <div><i class="fa fa-map-marker"></i> <?php echo $user->getData('resident_location');?></div>
            <?php endif;?>

             <div class="mb20"></div>

            <div class="btn-group">
                <?php if($user->getMode()):?>
                <button class="btn btn-primary btn-bordered" onclick="setLocation('<?php echo $this->getUrl('admin/users/editprofile',array('user'=> Encrypt::instance()->encode(App::model('admin/session')->getCustomer()->getUserId()), 'mode' => 'epf'));?>')"><i class="fa fa-edit"></i>&nbsp;<?php echo __('Edit');?></button>
                <?php else:?>
                <button class="btn btn-primary btn-bordered" onclick="setLocation('<?php echo $this->getUrl("admin/users/edit",array('id' => $this->getUsers()->getUserId()));?>')"><i class="fa fa-edit"></i>&nbsp;<?php echo __('Edit');?></button>
                <?php endif;?>
            </div>
        </div><!-- text-center -->

        <br />
        <?php if(count($contacts)):?>
            <div class="textleft"><i class="glyphicon glyphicon-phone"></i>
                <?php $cinfo = array(); foreach($contacts as $contact):?>
                    <?php $s = "+".$contact['country_code']."-".$contact['number'];
                    if($contact['is_primary'])
                    {
                        $s .= '<span title="Primary">('.__('P').')'."</span>";
                    }
                    $cinfo[] = $s;
                    ?>
                <?php endforeach;?>
                <?php echo implode(", ",$cinfo);?>
            </div>
        <br />
        <?php endif;?>

        <?php if(count(array_filter($connect))):?>
        <h5 class="md-title">Connect</h5>
        <ul class="list-unstyled social-list">

            <?php if(isset($connect['twitter'])):?><li><i class="fa fa-twitter"></i> <a href="<?php echo $connect['twitter'];?>"><?php echo $connect['twitter'];?></a></li><?php endif;?>
             <?php if(isset($connect['facebook'])):?><li><i class="fa fa-facebook"></i> <a href="<?php echo $connect['facebook'];?>"><?php echo $connect['facebook'];?></a></li><?php endif;?>
             <?php if(isset($connect['instagram'])):?><li><i class="fa fa-instagram"></i> <a href="<?php echo $connect['instagram'];?>"><?php echo $connect['instagram'];?></a></li><?php endif;?>
        </ul>
        <div class="mb30"></div>
        <?php endif;?>


        <h5 class="md-title"><?php echo __('Other Info');?>:</h5>
        <?php if($user->getDateOfBirth()):?>
            <div class="pdb10"><?php echo __("DOB: "). date("d/m/Y",strtotime($user->getDateOfBirth()));?></div>
        <?php endif;?>
        <div class="pdb10"><?php echo __("Registered on: "). date("d/m/Y",strtotime($user->getCreatedDate()));?></div>
        <div class="pdb10"><?php echo __("User Status: "). ($user->getStatus() ? '<span class="label label-success">'.__("Enabled").'</span>':
        '<span class="label label-danger">'.__("Disabled").'</span>');?></div>

        <?php   if(count($emails)):?>
        <div class="mb30"></div>
        <h5 class="md-title"><?php echo __('Additional Email');?>:</h5>
        <?php $em = array(); foreach($emails as $email):?>
                <?php $em[] = $email['email']; ?>
        <?php endforeach;?>
         <div class="pdb10"><?php echo implode(", ",$em);?></div>
        <?php endif;?>


    </div><!-- col-sm-4 col-md-3 -->

    <div class="col-sm-8 col-md-9">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-line">
            <li class="active"><a href="#activities" data-toggle="tab"><strong><?php echo __('Activities');?></strong></a></li>
            <li><a href="#roles" data-toggle="tab"><strong><?php echo __('Roles');?></strong></a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content nopadding noborder">
            <div class="tab-pane active" id="activities">
                <div class="activity-list">
                    <?php if($activities):?>
                    <?php foreach($activities as $activity):?>
                        <div class="media">
                            <a class="pull-left" href="#">
                               <!-- <img class="media-object img-circle" src="images/photos/user1.png" alt="" />-->
                            </a>
                            <div class="media-body">
                                <strong><?php echo $user->getFirstName();?> </strong> <i class="glyphicon glyphicon-chevron-right"></i> <?php echo $activity['message'];?>. <br />
                                <small><?php echo __('IP:');?> <?php echo $activity['ip_'];?></small> <br />
                                <small><?php echo __('Device:');?> <?php echo $activity['device'];?></small> <br />
                                <small class="text-muted"><?php echo App::helper('date')->nicetime($activity['date']);?></small>
                            </div>
                        </div><!-- media -->
                    <?php endforeach;?>
                    <?php else:?>
                        <?php echo __('No Recent Activities found');?>
                    <?php endif;?>

                </div><!-- activity-list -->

                <!--<button class="btn btn-white btn-block">Show More</button> -->
            </div><!-- tab-pane -->


             <div class="tab-pane" id="roles">

                <div class="roles-list">

                    <?php

                        if($owner = $user->getOwner($user->getData('user_id'),false)) {
                            foreach($owner as $owns) {
                                $image = '<i class="fa fa-building-o" style="font-size: 40px;"></i>';
                                if($img = $this->getPlaceImage($owns['place_category_id'],$owns['entity_primary_id'])) {
                                    $image = '<img src="'.$img.'" width="40"/>';
                                }
                                $html .= '<li> <div class="row role-box">
                                            <div class="col-sm-3">'.$image.'</div>
                                            <div class="col-sm-9">
                                        <div class="role-type">'.__('Administrator').'</div>';
                                if(isset($owns['place_id']) && $owns['place_id'] > 0) {

                                   $html .= '<div class="companyinc"> at '.$user->getEntityName($owns['place_id'])."</div>";
                                }
                                $html .= '</div></div> </li>';
                                $i++;
                            }
                        }
                        if($roleset = $this->getRoles($user->getData('user_id'))) {
                            foreach($roleset as $roles) {
                                $tagbgcolor =
                                $tagtextcolor = '';
                                if(isset($roles['tag_bg_color']) && $roles['tag_bg_color']) {
                                    $tagbgcolor = 'border-left-color:'.$roles['tag_bg_color'].";";
                                }
                                if(isset($roles['tag_text_color']) && $roles['tag_text_color']) {
                                    $tagtextcolor = 'color:'.$roles['tag_text_color'].";";
                                }
                                $html .= '<li><div class="row role-box" style="'.$tagbgcolor.'">
                                                    <div class="col-sm-3"><i class="fa fa-building-o" style="font-size: 40px;"></i></div>
                                                    <div class="col-sm-9">
                                                        <div class="role-type">'.$roles['role_name'].'</div>
                                                        <div class="companyinc"> at '.$roles['place_name'].'</div>
                                                    </div>
                                            </div></li>';
                                $i++;
                            }
                        }
                        ?>
                    <?php if($i >0):?>
                        <ul class="view-roles-list">
                    <?php endif;?>
                    <?php echo $html;?>
                    <?php if($i >0):?>
                        </ul>
                    <?php endif;?>
                    <?php if($i <=0):?>
                        <?php echo __('No Roles assigned');?>
                    <?php endif;?>


                </div><!-- activity-list -->
            </div><!-- tab-pane -->
    </div><!-- tab-content -->

    </div><!-- col-sm-9 -->
</div><!-- row -->
