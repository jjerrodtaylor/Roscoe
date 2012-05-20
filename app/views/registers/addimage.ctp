<?php e($javascript->link(array('jquery/jquery.min','fileupload/qr-code-brochure','fileupload/fileuploader'))); ?>
<?php e($html->css(array('fileupload/fileuploader'))); ?>
<div class="InnerMidCntR">
	<?php e($form->create('User', array('url' => array('controller' => 'registers', 'action' => 'addimage',$user_id))));?>     
	<?php e($form->hidden('User.hash',array('value'=>$hash))); ?>	
	<?php e($form->hidden('image_count',array('value'=>count($userImageArr),'id'=>'image_count'))); ?>
		<h2 class="InnerMidCntRHd">Add Image for user profile</h2>		
		<ul class="MyAccCnts">			
			<li>
				<div id="vertical_logo">		
					<noscript>			
						<p>Please enable JavaScript to use file uploader.</p>				
					</noscript>         
				</div>
				<!--  =======image name in input box ============ -->
				<span id="userImageList"><span>	
			</li>
			<li>
				<label class="MyAccLbl"><?php e($form->button('<span>Submit </span>', array('type'=>'submit', 'escape'=>false,'class'=>'MyAccSubmit')));?></label>
				<span class="MyAccTxtVal">&nbsp;</span>
			</li>
		</ul>	
		<?php e($form->end()); ?>	
</div>
		