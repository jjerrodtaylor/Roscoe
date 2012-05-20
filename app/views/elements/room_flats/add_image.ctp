<?php e($javascript->link(array('fileupload/qr-code-brochure-room-flat','fileupload/fileuploader'))); ?>
<?php e($html->css(array('fileupload/fileuploader'))); ?>
<?php  e($form->hidden('room_flat_number',array('value'=>$hash)))?>
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
			<!--  =======show image name list ============ -->	
			<?php e($this->element('room_flats/list_uploaded_image')); ?>
		</td>
	</tr>
</table>