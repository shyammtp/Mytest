
<?php $customer = App::model('store/session')->getCustomer(); ?>
	<?php if(count($this->getMessage()) > 0) { $i=1; foreach($this->getMessage() as $message){   ?>
	<li>
	 <div class="prd_dashbb" <?php if($i==1){ ?> style=" border-top:none;" <?php } ?>>
		<div class="prd_dash_top pad10" id="message_id-<?php echo $message['primary_id']; ?>">
		    <a class="new_inbox_link" href="<?php echo $this->getUrl('admin/system/reply_message',array('id' => $message['msg_id'],'type' => 'inbox'));?>">
			<div class="prod_dash_left" >
				<span class="margr5 left_name" title="<?php echo $message['from']; ?>"><?php echo $message['from']; ?><br><span class="clr4 fnt10 replies"><?php echo date("M-d-Y h:i A", strtotime($message['post_date'])); ?></span></span>
				<p class="clr5 widtaut margl5 right_name"><i class="backr1 margr5 margl5" style="background: none repeat scroll 0 0 <?php echo $message['color_code']; ?>;"><?php echo $message['subject_index']; ?></i>				<?php  
				if($message['reply_id']!='0'){ 
					echo '<b>Re</b>: '.strip_tags(substr($message['replymessage'].' - '.'&#x200E;'.$message['subject'],0,75).'&#x200E;'); 
				} else { 
					echo '&#x200E;'.strip_tags(substr($message['subject'],0,75)).'&#x200E;'; 
				} ?></p>
			</div>
			<div class="prod_dash_right pull-right">
				
				<span class="clr4 fnt10 replies"><?php echo  App::helper('date')->timeAgo($message['post_date']); ?></span>
			</div>
		    </a>
		</div>
		<?php $last_message = $this->CheckisLastmessage($message['primary_id'],$message['msg_id'],$customer->getID()); ?> 
		<?php if($last_message==$message['primary_id']){ ?> 
		<a class="widtaut margr5 margb5 replyclass" href="<?php echo $this->getUrl('admin/system/reply_message',array('id' => $message['msg_id'],'type' => 'inbox'));?>"><i class="margr5 fa fa-reply-all"></i><?php echo __('Reply');?></a>
		<?php } ?>
		
		<div class="prd_dash_bott pad10 show_details1"  id="detaile-<?php echo $message['primary_id']; ?>" style="display:none">
			<div class="prd_dash_tab displ">
				<table>
					<tr>
						<?php if($message['action']){ ?>
							<?php if($message['reply_id']!='0'){ ?>
								<td class="prd_dash_tab_left"><?php echo $message['replymessage']; ?></td>
							<?php } else { ?>
								<td class="prd_dash_tab_left"><?php echo $message['message']; ?></td>
							<?php } ?>
						<?php } else {  ?>
							<?php if($message['reply_id']!='0'){ ?>
								<div class="no_action displ"><?php echo $message['replymessage']; ?></div>
							<?php } else { ?>
								<div class="no_action displ"><?php echo $message['message']; ?></div>
							<?php } ?>	
						<?php } ?>
						<?php if($message['reply_id']=='0'){ ?>
							<td class="prd_dash_tab_right"><?php echo $message['action']; ?></td>
						<?php } ?>	
					</tr>
				</table>
			</div>	
		</div>
	 </div>
	  <!-- First Product-->
	 <!-- Second Product-->
	 </li>
	 <?php  $i++; }} else { ?>
	 <?php } ?>
