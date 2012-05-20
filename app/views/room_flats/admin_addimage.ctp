<?php e($javascript->link(array('fileupload/qr-code-brochure-room-flat','fileupload/fileuploader'))); ?>

<?php e($html->css(array('fileupload/fileuploader'))); ?>


<div class="adminrightinner">
	<?php e($form->create('RoomFlat', array('url' => array('controller' => 'room_flats', 'action' => 'addimage',$room_flat_id))));?>     
	<?php e($form->hidden('RoomFlat.room_flat_number',array('value'=>$hash))); ?>	
	<?php e($form->hidden('image_count',array('value'=>count($roomFlatImageArr),'id'=>'image_count'))); ?>
	
	<div class="tablewapper2 AdminForm">
		<h3 class="legend1">Add Image for room/flat</h3>
		<table>
			<tr>
				<td align="left" valign="top" class="textLabel">
					<div id="vertical_logo">		
						<noscript>			
							<p>Please enable JavaScript to use file uploader.</p>				
						</noscript>         
					</div>
					
					<!--  =======image name in input box ============ -->
					<span id="roomFlatImageList"><span>	
				</td>
			</tr>
		</table>
	</div>
	<div class="buttonwapper">
		<div><input type="submit" value="Submit" class="submit_button" /></div>
		<div class="cancel_button"><?php echo $html->link("Cancel", "/admin/room_flats/index/", array("title"=>"", "escape"=>false)); ?>
		</div>
	</div>
	<?php e($form->end()); ?>	
</div>