<?php e($javascript->link(array('jquery/jquery','fileupload/qr-code-brochure-room-flat','fileupload/fileuploader'))); ?>

<?php e($html->css(array('fileupload/fileuploader'))); ?>
<div class="InnerMidCntR">
	<?php e($form->create('RoomFlat', array('url' => array('controller' => 'room_flats', 'action' => 'addimage',$room_flat_id))));?>     
	<?php e($form->hidden('RoomFlat.room_flat_number',array('value'=>$hash))); ?>	
	<?php e($form->hidden('image_count',array('value'=>count($roomFlatImageArr),'id'=>'image_count'))); ?>
		<h2 class="InnerMidCntRHd">Add Image for room/flat</h2>		
		<ul class="MyAccCnts">			
			<li>
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
			</li>
			<li>
				<label class="MyAccLbl"><?php e($form->button('<span>Submit </span>', array('type'=>'submit', 'escape'=>false,'class'=>'MyAccSubmit')));?></label>
				<span class="MyAccTxtVal">&nbsp;</span>
			</li>
		</ul>	
		<?php e($form->end()); ?>	
</div>