

	 <div class="Homecenterconts">
		 <div class="Rectop">
				<h1 class="Rech1">Inbox</h1>
				<div class="clr"></div>
		 </div>
		<div class="usermessages">
			 <?php echo $this->Session->flash();?>
			
		<?php if(!empty($message_inbox)) { 
				$exPaginator->options = array('url' => $this->passedArgs);
				//$paginator->options(array('url' => $this->passedArgs)); 
				$paginator->options(array('url'=>$this->passedArgs, 'update'=>'Container', 'indicator'=>'spinner'));
				?>
			<div  id="Container">	
			 <?php  e($form->create('Message', array('name'=>'Message', 'url' => array('controller' => 'messages', 'action' => 'msgprocess'))));
					 e($form->hidden('pageAction', array('id' => 'pageAction')));?>
				<div class="BlogListRowMsg">
					<div class="Frontmsgchckbox"><input name="chkbox_n" id="chkbox_id" type="checkbox" value="" class="Chkbox" onclick="javascript:check_uncheck('Message')" /></div>
					<div class="Frontmsg3"><b style="color:#FF0000;"> <?php e($exPaginator->sort(__('From',true), 'User.username'))?></b></div>
					<div class="Frontmsg"><b style="color:#FF0000;"><?php e($exPaginator->sort(__('Subject',true), 'Message.subject'))?></b></div>
					<div class="Frontmsg1"><b style="color:#FF0000;"><?php e($exPaginator->sort(__('Description',true), 'Message.message'))?></b></div>
					<div class="Frontmsg5"><b style="color:#FF0000;"><?php e($exPaginator->sort(__('Recived',true), 'Message.created'))?></b></div>
					<div class="Frontmsg_status"><b style="color:#FF0000;"><?php e($exPaginator->sort(__('Status',true), 'Message.read_status'))?></b></div>
					<div class="Frontmsg3"><b style="color:#FF0000;"><?php e(__('Action',true))?></b></div>
				</div>	
		
				<?php foreach($message_inbox as $key => $value) {
						 if($value['Message']['read_status'] == 0){
							$NoreadClass = 'NoreadClass';
						 }else{
							$NoreadClass = '';
						 }
						 
						 ?><div class="BlogListRowMsg <?php echo $NoreadClass;?>">
						
						<div class="Frontmsgchckbox"><?php e($form->checkbox('Message.id'.$value['Message']['id'], array("class"=>"Chkbox", 'value'=>$value['Message']['id'] ))); ?></div>
						<div class="Frontmsg3"><?php e($value['User']['username']);?></div>
						<div class="Frontmsg">
						 
							<?php e($html->link($value['Message']['subject'], array('controller'=>'messages', 'action'=>'message_detail',$value['Message']['id'],'inbox'), array('escape'=>false)));?>
						 
						</div>
						<div class="Frontmsg1">
						 
						<?php e(strip_tags(substr($value['Message']['message'],0,20)) ); ?>...
						 
						</div> 
						<div class="Frontmsg5">
						<?php //e($value['Message']['created']); ?>
						<?php e(date("F j, Y, g:i a", strtotime($value['Message']['created']))) ; ?>
						
						</div>
						
						
						<div class="Frontmsg_status"> <?php e($layout->is_viewed($value['Message']['read_status'])); ?> </div>
						
						<div class="Frontmsg3"> 	
							<b><?php echo $html->link(__('Delete',true), array('controller'=>'messages', 'action'=>'delete',$value['Message']['id'],'deletefrom'=>'inbox', 'token'=>$this->params['_Token']['key']), null, sprintf(__('Are you sure you want to delete', true), $value['Message']['id']),false,false); ?></b>
						 </div>
						</div>
						
			<?php   } ?>

					<?php e($form->submit('Favorite', array('name'=>'favorite', 'class'=>'PostMessage','style'=>'margin:10px 0px 0px 10px', "onclick" => "javascript:return validateChk('Message', 'favorite');")));		
						
						e($form->submit('Delete', array('name'=>'delete', 'class'=>'PostMessage','style'=>'margin:10px 0px 0px 10px', "onclick" => "javascript:return validateChk('Message', 'delete');")));
						
				  e($form->end());
				?>
				<div class="Srhresfot paging">
				<div style="float:left;width:50%">
				<?php e($form->create(null));
				echo 'Per page';			
				$options = Configure::read('App.PerPage');  
				  if($session->check('Messageslisting.PerPage')){
					 $selected = $session->read('Messageslisting.PerPage');			  
				  }
				  else{
					  $selected = Configure::read('App.PageLimit');
				  }

				  e($form->select('UpperPerPage',$options, $selected, array('id'=>'UpperPerPage', 
				  'name'=>'UpperPerPage','empty'=>false),false));	 			 
				  e($ajax->observeField('UpperPerPage', array(
										  'url'=>array(
										  'controller'=>'messages', 'action'=>'inbox'),
										  'update'=>'Container'	,
										  'indicator'=>'spinner' 				  
										)
							));
					e($form->end());?>		
					</div>
					<div>
					<?php echo $this->element('paging', array("paging_model_name"=>"Message", "total_title"=>"User's message")); ?>                            
					</div>
					</div>
				</div> 
	<?php	} else { ?>	
					<div style="padding:10px;">
					<?php e('No record found'); ?>
					</div>
	<?php 	} ?>	
		 

		</div>					
	</div>