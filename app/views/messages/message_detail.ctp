
		<div class="Homecenterconts">
					 <div class="Rectop">
							<h1 class="Rech1"> <?php if(isset($page)){ echo $page;}?> - Message Detail</h1>
							<h1 class="Rech1" style="float:right"> 
								<?php 
									echo $html->link('Back To Inbox',array('controller'=>'messages','action'=>'inbox'),array('escape'=>false,'class'=>'Rech1'));
								?>
							</h1>
							<div class="clr"></div>
					 </div>
					<div class="usermessages">
					<?php echo $this->Session->flash();?> 
					<?php if(!empty($message_detail_inbox)) { 
						?>
						
						<table class="message_read_table" cellpadding="0" cellspacing="0" border="0" width="100%">
							<tr>
								<td width="20%">
									<label><?php if ($page =="outbox") { echo "To";} else { echo "From";}  ?></label>
								</td>
								<td width="10%">:</td>
								<td>
									<?php e($message_detail_inbox['User']['username']);?>
								</td>
							</tr>
							
							<tr>
								<td>
									<label><?php e(__('Subject',true)) ?></label>
								</td>
								<td>:</td>
								<td>
									<?php e($message_detail_inbox['Message']['subject']); ?>
								</td>
							</tr>
							
							<tr>
								<td>
									<label><?php e(__('Received',true)) ?></label>
								</td>
								<td>:</td>
								<td>
									<?php e(date("F j, Y, g:i a", strtotime($message_detail_inbox['Message']['created']))) ; ?>
								</td>
							</tr>
							
							<tr>
								<td>
									<label><?php e(__('Description',true)) ?></label>
								</td>
								<td>:</td>
								<td>
									<?php e($message_detail_inbox['Message']['message']); ?>
								</td>
							</tr>
							<?php
  							/* date functionlity*/
								if(!empty($message_detail_inbox['Date']['id'])){
								?>
								<tr>
									<td>
										<label><?php e(__('Date Request',true)) ?></label>
									</td>
									<td>:</td>
									<td>
										<table width="100%" cellspacing="0" cellpadding="0">
											<tr>
												<?php if($message_detail_inbox['Date']['accepted'] == 0){?>
												<td align="left">
													<?php echo $html->link('Accept',array('controller'=>'messages','action'=>'date_request_action',$message_detail_inbox['Date']['id'],1),array('escape'=>false,'class'=>'acceptHearticona'));?>	
												</td>
												<td align="left">
													<?php echo $html->link('Reject',array('controller'=>'messages','action'=>'date_request_action',$message_detail_inbox['Date']['id'],2),array('escape'=>false,'class'=>'RejectHearticona'));?>	
												</td>
												<?php }else{
												if($message_detail_inbox['Date']['accepted'] == 1){
												?>
												<td align="left" style="padding:0px">
													You accepted this date request.	
												</td>
												<?php 
													}elseif($message_detail_inbox['Date']['accepted'] == 2){?>
												<td align="left" style="padding:0px">
													You rejected this date request.	
												</td>
												<?php 
													}
												}?>
											</tr>
										</table>	
									</td>
								</tr>
								<?php
								}
							?>
							
							<?php 
							// for promiuom users rate options
							$prim = $is_premium;
							if($prim == 1){
							echo $javascript->link('/rating/js/rating_prototype');
							echo $html->css('/rating/css/rating'); 

							?>
							<tr>
								<td>
									<label><?php e(__('Rate this Message',true)) ?></label>
								</td>
								<td>:</td>
								<td>
									 <div class="ProfRatMiddMessage">
									  <?php
										echo $this->element('rating', array('plugin' => 'rating',
															'model' => 'Message',
															'id' => $message_detail_inbox['Message']['id']));
										?>
              
									</div>
								</td>
							</tr>
							<?php }?>
							
							<?php if (isset($page) && ($page=="outbox" || $page=="deleted")) { ?>
							<?php } else { ?>
							<tr>
								<td>
									<label><?php e(__('Action',true))?></label>
								</td>
								<td>:</td>
								<td>
									
									
									
									
									<div class="Frontmsg3">
										<b><?php echo $html->link(__('Delete',true), array('controller'=>'messages', 'action'=>'delete',$message_detail_inbox['Message']['id'],'deletefrom'=>'inbox', 'token'=>$this->params['_Token']['key']),array('class'=>'deletelink'), sprintf(__('Are you sure you want to delete', true), $message_detail_inbox['Message']['id']),false,false); ?></b>
									 </div>
									 <div class="Frontmsg3">
									 <b><a class="reply" id="wall_<?php e($message_detail_inbox['Message']['id']);?>">
												<?php e('Reply'); ?>
												</a>
											</b>
											</div>	
										
								</td>
							</tr>
							<?php } ?>
						</table>
							
								<div class="ImgDecmidImg"> 
								<?php if (file_exists('uploads/messages/large/'.$message_detail_inbox['Message']['pic']) && !empty($message_detail_inbox['Message']['pic'])) {
									echo $html->image('/uploads/messages/large/'.$message_detail_inbox['Message']['pic'] , array('alt'=>'Pic'));	
								} ?>
               
								</div>
								
								
								<?php if (isset($page) && ($page=="inbox")) { ?>
									<?php if (!empty($reply_message)) {
									?>
									<table class="msgdetailclass" cellspacing="0" cellpadding=0 style="border:1px red;" border="0" width="100%">
									 <tr bgcolor="#eaeaea">
										<td><label>From</label></td>
										<td><label>To</label></td>
										<td><label>Subject</label></td>
										<td><label>Description</label></td>
										<td><label>Date</label></td>
									</tr>
									 <?php foreach($reply_message as $reply) { ?>
									<tr>
									  <td><?php echo $reply['Sender']['username'];?> </td>
									  <td><?php echo $reply['Receiver']['username'];?> </td>
									  <td>
									  <?php e($html->link($reply['Message']['subject'], array('controller'=>'messages', 'action'=>'message_detail',$reply['Message']['id'],'inbox'), array('escape'=>false)));?>
									 </td>
									  <td><?php echo $reply['Message']['message'];?> </td>
									  <td><?php e(date("F j, Y, g:i a", strtotime($reply['Message']['created']))) ; ?> </td>
									 
									</tr>
									
									<?php } ?>
									</table>
									
									<?php } 
								}
								?>
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								<!-- Message reply -->
								
								<div id="container">
									<?php if (!empty($draft)) {?>	
										
									<div style="display:block;" class="wall_<?php e($draft['Message']['id']);?>">	
									<?php e($form->create('Message',array('url'=>array('controller'=>'messages', 'action'=>'message_reply'))));
										 e($form->hidden('id', array('value'=>$draft['Message']['id'])));
										 e($form->hidden('parent_id', array('value'=>$draft['Message']['parent_id'])));
										 
										 e($form->hidden('receiver_id', array('value'=>$draft['Message']['receiver_id'])));
										 ?>		
										 <ul class="CosplayFrm">
											<li>
												
												<?php e($form->input('subject', array('class'=>'CosplayFild', 'label'=>false,'placeholder'=>'Subject', 'value'=>$draft['Message']['subject'],  'div'=>false)));?>
											</li>
											<li>
												<?php e($form->input('message', array('class'=>'CosplayTxtar',"cols"=>"45", "rows"=>"5", 'label'=>false,'placeholder'=>'Message', 'div'=>false,'value'=>$draft['Message']['message'])));?>
											</li>
											<li>
												
												<?php e($ajax->submit('Reply', array('class'=>'PostMessage','style'=>'margin-right:20px', 'update'=>'container', 'url' => array('controller' => 'messages', 'action'=>'message_reply'))));?>
												
												<?php e($ajax->submit('Save as draft', array('class'=>'PostMessage', 'update'=>'container', 'url' => array('controller' => 'messages', 'action'=>'saveasdraft'))));?>
												
												
											</li>
											 
											
										</ul>
										<?php e($form->end()) ; ?>	
									</div>
									
									<?php } else {
									?>
									<div style="display:none;" class="wall_<?php e($message_detail_inbox['Message']['id']);?>">	
									<?php e($form->create('Message',array('url'=>array('controller'=>'messages', 'action'=>'message_reply','parent_message_id'=>$message_detail_inbox['Message']['id'],'sender_id'=>$message_detail_inbox['Message']['sender_id']))));
										 //e($form->hidden('id', array('value'=>$value['Message']['id'])));
											e($form->hidden('parent_id', array('value'=>$message_detail_inbox['Message']['id'])));
											//e($form->hidden('parent_id', array('value'=>$message_detail_inbox['Message']['parent_id'])));
										 e($form->hidden('sender_id', array('value'=>$message_detail_inbox['Message']['sender_id'])));				
										//e($form->hidden('receiver_id', array('value'=>$message_detail_inbox['Message']['receiver_id'])));	
										 ?>		
										 <ul class="CosplayFrm">
											<li>
												 <label>Subject</label>
												 <?php 
												 $test = strchr($message_detail_inbox['Message']['subject'],'Re');
												if(!empty($test)){
												 $msg = $message_detail_inbox['Message']['subject'];
												 }else{
												 $msg = "Re:".$message_detail_inbox['Message']['subject'];
												 }?>
												<?php e($form->input('subject', array('class'=>'CosplayFild', 'label'=>false,'placeholder'=>'Subject', 'value'=>$msg,  'div'=>false,  "error" => array("class" => "errormsgtikbox"))));?>
											</li>
											<li>
												 <label>Message</label>
												<?php e($form->input('message', array('class'=>'CosplayTxtar','label'=>false,'placeholder'=>'Message', 'div'=>false, "error" => array("class" => "errormsgtikbox1"))));?>
											</li>
											<li>
												<label>&nbsp;</label>
												<?php e($ajax->submit('Reply', array('class'=>'PostMessage', 'update'=>'container', 'url' => array('controller' => 'messages', 'action'=>'message_reply'))));?>
												<div class="space"></div>
												<?php e($ajax->submit('Save as draft', array('class'=>'PostMessage', 'update'=>'container', 'url' => array('controller' => 'messages', 'action'=>'saveasdraft'))));?>
												
											</li>
											 
											
										</ul>
										<?php e($form->end()) ; ?>	
									</div>									
									
									<?php } ?>
									
								</div>	
									<!-- Message reply -->
							<?php //} ?>
						<?php } else { ?>	
								<div style="padding:10px;">
								<?php e('No_record_found'); ?>
							</div>
						<?php } ?>	
								

					
			
					</div>
					
					
				</div>
				
               
 
<script type="text/javascript">
jQuery(".reply").click(function () {
	  var id	=	jQuery(this).attr('id');	  	
		jQuery('.'+id).slideToggle("slow");
	  
    });
	
</script>