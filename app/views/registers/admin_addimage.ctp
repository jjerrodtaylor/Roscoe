<?php e($javascript->link(array('fileupload/qr-code-brochure','fileupload/fileuploader'))); ?>

<?php e($html->css(array('fileupload/fileuploader'))); ?>


<div class="adminrightinner">
	<?php e($form->create('User', array('url' => array('controller' => 'registers', 'action' => 'addimage',$user_id))));?>     
	<?php e($form->hidden('User.hash',array('value'=>$hash))); ?>	
	<?php e($form->hidden('image_count',array('value'=>count($userImageArr),'id'=>'image_count'))); ?>
	
	<div class="tablewapper2 AdminForm">
		<h3 class="legend1">Add Image for user profile</h3>
		<table>
			<tr>
				<td align="left" valign="top" class="textLabel">
					<div id="vertical_logo">		
						<noscript>			
							<p>Please enable JavaScript to use file uploader.</p>				
						</noscript>         
					</div>
					
					<!--  =======image name in input box ============ -->
					<span id="userImageList"><span>	
				</td>
			</tr>
		</table>
	</div>
	<div class="buttonwapper">
		<div><input type="submit" value="Submit" class="submit_button" /></div>
		<div class="cancel_button"><?php echo $html->link("Cancel", "/admin/registers/index/", array("title"=>"", "escape"=>false)); ?>
		</div>
	</div>
	<?php e($form->end()); ?>	
</div>