<?php //e($html->css('jquery/jquery.fileupload-ui')); ?>
<table border="0" class="Admin2Table" width="100%">		
	<?php  e($form->hidden('role_id',array('value'=>'2')))?>
	<?php  e($form->hidden('UserReference.terms_condtions',array('value'=>'1')))?>
	
	<tr class="AddProFrm">
		<td colspan="2"><h3>Account information</h3></td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26">Email <span class="input_required">*</span></td>
		<td><?php e($form->input('email', array('div'=>false, 'label'=>false, "class" => "Testbox5")));?></td>
	</tr>
	<?php if($this->params['action'] !='admin_edit'){?>
	<tr>
		<td valign="middle" class="Padleft26">Password <span class="input_required">*</span></td>
		<td><?php e($form->input('password2', array("type" => "password", 'div'=>false, 'label'=>false, "class" => "Testbox5")));?></td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26">Confirm Password <span class="input_required">*</span></td>
		<td><?php e($form->input('confirm_password', array("type" => "password", 'div'=>false, 'label'=>false, "class" => "Testbox5")));?></td>
	</tr>
	<?php } ?>
	<tr class="AddProFrm">
		<td colspan="2"><h3>Contact information's & personal information</h3></td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26">First Name <span class="input_required">*</span></td>
		<td><?php e($form->input('UserReference.first_name', array('div'=>false, 'label'=>false, "class" => "Testbox5")));?>
		</td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26">Last  Name</td>
		<td><?php e($form->input('UserReference.last_name', array('div'=>false, 'label'=>false, "class" => "Testbox5")));?>
		</td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26">Street address<span class="input_required">*</span> </td>
		<td><?php e($form->input('UserReference.street_address', array('div'=>false, 'label'=>false, "class" => "Testbox5")));?>
		</td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26">Country<span class="input_required">*</span> </td>
		<td>
			<?php				
			e($form->input('UserReference.country_id',array('options'=>$countries,'div'=>false,'label'=>false,'empty'=>"Please Select Country","class" => "Testbox5")));
			?>
		</td>
	</tr>
	<tr id="stateOptions">
	<?php e($this->element('registreduser/state')); ?>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26">City<span class="input_required">*</span></td>
		<td>
			<?php  e($form->input('UserReference.city_name', array('div'=>false, 'label'=>false, "class" => "Testbox5")));?>
		</td>
	</tr>
	
	<tr>
		<td valign="middle" class="Padleft26">ZIP / Postal code </td>
		<td>
			<?php  e($form->input('UserReference.zipcode', array('div'=>false, 'label'=>false, "class" => "Testbox5")));?>
		
		</td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26">Accessbility </td>
		<td>
			<?php e($form->input('User.access_permission',array('options'=>array('1'=>'Public','0'=>'Private'),'div'=>false,'label'=>false,'class'=>'TextBox5')));?>		
		</td>
	</tr>	
	<tr>
		 <td valign="middle" class="Padleft26">Status</td>
		 <td>
		 <?php e($form->input('User.status', array('options'=>Configure::read('Status'),'div'=>false, 'label'=>false, "class" => "TextBox5")));?>
		 </td>
	</tr>
	<?php
	if($this->params['action']=='admin_add'){?>	
		<tr class="AddProFrm">
			<td colspan="2"><h3>Upload user images for profile</h3></td>
		</tr>	
		<tr>
			<td valign="middle" class="Padleft26">Upload Image</td>
			<td><?php e($this->element('registreduser/add_image')); ?></td>			
		</tr>
		<?php
	}elseif(count($this->data['UserImage']) >0){?>
		<tr class="AddProFrm">
			<td colspan="2"><h3>Uploaded user images for profile</h3></td>
		</tr>	
		<tr>
			<?php e($this->element('registreduser/view_image',array('UserImageArr'=>$this->data['UserImage']))); ?>
		</tr>
		<?php
	} ?>	
</table>
