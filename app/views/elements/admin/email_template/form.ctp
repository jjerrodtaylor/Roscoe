 <?php 
 e($javascript->link(array('fckeditor'), false));
 e($form->hidden('token_key', array('value' => $this->params['_Token']['key'])));
 ?>
<table border="0" class="Admin2Table" width="100%">		
	<tr>
		<td valign="middle" class="Padleft26"  width="20%">Title <span class="input_required">*</span></td>
		<td><?php e($form->input('EmailTemplate.name', 
		array('div'=>false, 'label'=>false, "class" => "TextBox5")));?>
		</td>
	</tr>			  
	<tr>
		<td valign="middle" class="Padleft26">Subject <span class="input_required">*</span></td>
		<td><?php e($form->input('EmailTemplate.subject', 
		array('div'=>false, 'label'=>false, "class" => "TextBox5")));?>
		</td>
	</tr>

	<tr>
		<td valign="middle" class="Padleft26">Description <span class="input_required">*</span></td>
		<td>
		<?php e($form->input('EmailTemplate.description', array('div'=>false, 'label'=>false, "class" => "textarea")));?>
		<?php echo $fck->load('EmailTemplate/description',"Default");?>
		</td>
	</tr>  

	<tr>
		<td valign="middle" class="Padleft26">Status</td>
		<td>
		<?php e($form->input('EmailTemplate.status', array('options'=>Configure::read('Status'),'div'=>false, 'label'=>false, "class" => "TextBox5")));?>
		</td>
	</tr>   			  
</table>