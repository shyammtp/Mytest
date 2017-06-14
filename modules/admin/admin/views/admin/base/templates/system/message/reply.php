<?php $notification = $this->_getMessage();?>
<?php $messages = $this->getMessageData($notification['msg_id']); $subject_type = $this->getSubjectType($notification['subject_type']);?>
<?php
	$customer = App::model('admin/session')->getCustomer();			
	$sessionid = $customer->getUserId();
		
	$usermodel = App::model('user',false)->selectAttributes('*')->setLanguage(App::getCurrentLanguageId())->setConditionalLanguage(true)->load($messages['sender']);
	$post_date = explode(',',$messages['post_date']);	
	$receiverArr = explode(',',$messages['receiver']);	
	
	if(in_array($sessionid, $receiverArr)) {
		$pos = array_search($sessionid, $receiverArr);
		$replace = array($pos => $messages['sender']);		
		$receiverUser = implode(',',array_replace($receiverArr,$replace));
	} else {
		$receiverUser = implode(',',$receiverArr);
	}		
	$receiversList = $this->getReceiversList($receiverUser);				
?>										
<?php $reply = App::model('admin/notification/reply')->getReplies($notification['msg_id']);?>	

<div id="container">
<div class="loader">
	<center>
	   <img class="loading-image" src="<?php echo $this->getAssetsPathUrl('images/select2-spinner.gif');?>" alt="loading..">
	</center>
</div>
	<!-- search Content-->
	<div class="prd_dash">
	<div class="search_cont">
		<div class="serch_cont_lft pull-left">
			<p class="clr6 widtaut marg0"><span class="fnt15"><?php echo $notification['subject']; ?></span><span class="backr1 margr5 margl5" style="background: none repeat scroll 0 0 <?php echo $subject_type['color_code']; ?>;"><?php echo $subject_type['subject_index']; ?></span></p>
		 </div>
		 <div class="pull-right serch_cont_rgt">	
			 <a class="widtaut margr5 reply-position"><i class="margr5 fa fa-reply-all"></i><?php echo __('Reply');?></a> 
			 <?php /** 
			 <a title="Delete" class="deletemsg pull-right" data-id="" class="color_chan margr5"><span class="glyphicon glyphicon-trash fnt15"></span></a>	
			 **/ ?>
		 </div>	 
	 <?php if($notification['action_placed'] == 'f') { ?>
		<?php echo $notification['action']; ?>
	 <?php } ?>
	</div>
	<!-- search Content-->
	<!-- store search Content-->
	<!-- First Product-->
	 <div class="prd_dashbb notificat">
		<div class="prd_dash_top pad10 msg">
			<div class="prod_dash_left widaut">
				<span class="margr5 clr6"><?php echo $usermodel->getData('first_name'); ?></span>
			</div>
			<div class="prod_dash_right pull-right widaut">
				
				<span class="clr4 fnt10"><?php echo App::helper('date')->timeAgo($post_date[0]); ?></span>
				<!--<p><a class="hide_detail msg"><span class="clrss">Hide Details</span><i class="fa fa-sort-desc margl5"></i></a></p>-->
			</div>
		</div>
		<div class="prd_dash_bott pad10 marg10 msg-disp">
			<?php echo $notification['message']; ?>			
		</div>
	 </div>
	  <!-- First Product-->
	 <!-- Second Product-->		
		<div id="reply-result"></div>
		<?php if(!empty($reply)) { ?>		
			<?php foreach($reply as $replymessage) { ?>	
		<?php 
		$userreplymodel = App::model('user',false)->selectAttributes('*')->setLanguage(App::getCurrentLanguageId())->setConditionalLanguage(true)->load($replymessage['sender']);	 		
		?>		
	 	<!-- store search Content-->	 	
	 <div class="prd_dashbb notificat replyresponse-<?php echo $replymessage['reply_id']; ?>">
		<div class="prd_dash_top pad10 reply_details" data-id="<?php echo $replymessage['reply_id']; ?>">
			<div class="prod_dash_left widaut">
				<span class="margr5 clr6"><?php echo $userreplymodel->getData('first_name'); ?></span>								
			</div>
			<div class="prod_dash_right pull-right widaut">				
				<span class="clr4 fnt10"><?php echo App::helper('date')->timeAgo($replymessage['post_date']); ?></span>
				
				<?php /* if($sessionid == $replymessage['sender']) { ?>
				<a title="Delete" class="delete" data-id="<?php echo $replymessage['reply_id']; ?>" class="color_chan margr5"><span class="glyphicon glyphicon-trash fnt15"></span></a>
				<?php } */?>
				<!--<p><a id="hide_detail" class="reply_details" data-id="<?php //echo $replymessage['reply_id']; ?>"><span class="clrss">Hide Details</span><i class="fa fa-sort-desc margl5"></i></a></p>-->				
			</div>
		</div>		
		<div class="prd_dash_bott pad10 marg10 show_details-<?php echo $replymessage['reply_id']; ?>">
			<div class="prd_dash_bott_left">
		    <div class="displ">
				<?php echo $replymessage['message']; ?>
				</div>
				</div>
			</div>
		</div>		
		 <!-- Flipkart-->
		 <?php } ?>	
		<?php } ?>
		<?php $sessionusermodel = App::model('user',false)->selectAttributes('*')->setLanguage(App::getCurrentLanguageId())->setConditionalLanguage(true)->load($sessionid);?>
		 
		 <!-- Eltorninc Admin-->
		 <div class="prd_dashbb notificat">
			<div class="displ pad10">
				<div class="displ">
					<div class="displ">						
						<b><?php echo __('Reply to - '); ?></b>
						<?php foreach($receiversList as $list) { ?>							
							<label class="label label-success"><?php echo $list['first_name']; ?></label>
						<?php } ?>												
						<!--<span class="margr5 clr6 undd"><?php //echo $sessionusermodel->getData('first_name'); ?></span>-->
					</div>
				   <div class="displ marg10">
						<textarea class="form-control no_borderr displ" id="content"></textarea>
				   </div>
				</div>
			</div>		
		</div>
		 <!-- Eltorninc Admin-->
         <div class=" panel-footer">
			<input type="hidden" id="message_id" name="message_id" value="<?php echo $notification['msg_id']; ?>" />
			<input type="hidden" id="user_id" name="user_id[]" value="<?php echo $receiverUser; ?>" />			
			<button class="btn btn-primary mr5 reply" id="reply-position"><?php echo __('Reply');?></button>
			<button class="btn btn-default  mr5" type="button" onclick="setLocation('<?php echo $this->getUrl("admin/dashboard/index");?>')"><?php echo __('Cancel');?></button>
         </div>
		
	 </div>
	 <!-- Second Product-->
	 </div>
	<!-- store search Content-->

<script>
$(document).ready(function() {
	/*
	$('.msg').click(function() {
		$('.msg-disp').toggle();		
	});
	$(document.body).on('click','.reply_details',function() {		
		var id = $(this).attr('data-id');		
		$('.show_details-'+id).toggle();
	});
	*/
	$('.reply-position').click(function() {		
		$('#content').focus();		
	});
	$('.reply').click(function() {			
		var message_id = $('#message_id').val();
		var user_id = $('#user_id').val();		
		var message = $('#content').val();
		
		var sel = $('#reply-result');
		if(message != '') {						
			//sel.empty();
			$.ajax({
				type:"POST",
				url:"<?php echo $this->getUrl('admin/system/mailreply',$this->getRequest()->query());?>",
				data:{message_id:message_id,message:message,user_id:user_id},
				dataType:"html",
				beforeSend: function() {
					$('.loader').show();						
					$('button').prop('disabled', true);
				},
				complete: function() {	
					$('.loader').hide();				
					$('button').prop('disabled', false);
				},
				success:function(data) {								
					sel.prepend(data);									
				}
			});
		}
		$('#content').val('');		
	});	
	$(document.body).on('click','.delete',function() {
		var reply_id = $(this).attr('data-id');		
		var msg_id  = '<?php echo $notification['msg_id']; ?>';
		if(confirm('Are you sure want to delete?')) {			
			$('.replyresponse-'+reply_id).fadeOut('slow');
			$('.replyresponse-'+reply_id).remove();
			$.ajax({
				type:"POST",
				url:"<?php echo $this->getUrl('admin/system/deletereply',$this->getRequest()->query());?>",
				data:{msg_id:msg_id,reply_id:reply_id},
				dataType:"html",
				success:function(data) {								
					//$('.dstatus').html(data);									
				}
			});
		}
	});
	$(document.body).on('click','.deletemsg',function() {		
		var msg_id  = '<?php echo $notification['msg_id']; ?>';
		if(confirm('Are you sure want to delete?')) {						
			$.ajax({
				type:"POST",
				url:"<?php echo $this->getUrl('admin/system/delete_message',$this->getRequest()->query());?>",
				data:{msg_id:msg_id},
				dataType:"html",
				success:function(data) {								
					if(data) {
						window.location = '/admin/dashboard/index';
					}
				}
			});
		}
	});
});
</script>
<style>
.reply-position {
	cursor:pointer;
}
.loading-image {
  position: absolute;
  top: 50%;
  left: 50%;
  z-index: 10;
}
.loader
{
    display: none;
    width:200px;
    height: 200px;
    position: fixed;
    top: 50%;
    left: 50%;
    text-align:center;
    margin-left: -50px;
    margin-top: -100px;
    z-index:2;
    overflow: auto;
}
</style>
