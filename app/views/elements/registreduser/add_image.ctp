<?php e($javascript->link(array('fileupload/qr-code-brochure','fileupload/fileuploader'))); ?>

<?php e($html->css(array('fileupload/fileuploader'))); ?>
<?php e($form->hidden('User.hash',array('value'=>$hash))); ?>
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
			<!--  =======show image name list ============ -->	
			<?php e($this->element('registreduser/list_uploaded_image')); ?>
		</td>
	</tr>
</table>

