<table border="0" class="Admin2Table" width="100%">		
			  <tr>
				 <td valign="middle" class="Padleft26">Username <span class="input_required">*</span></td>
				 <td><?php e($form->input('User.username', array('div'=>false, 'label'=>false, "class" => "Testbox5")));?></td>
			  </tr>
			  <tr>
				 <td valign="middle" class="Padleft26">Password <span class="input_required">*</span></td>
				 <td><?php e($form->input('User.password2', array("type" => "password", 'div'=>false, 'label'=>false, "class" => "Testbox5")));?></td>
			  </tr>			  
			   <tr>
				 <td valign="middle" class="Padleft26">Email <span class="input_required">*</span></td>
				 <td><?php e($form->input('User.email', array('div'=>false, 'label'=>false, "class" => "Testbox5")));?></td>
			  </tr>
			   <tr>
				 <td valign="middle" class="Padleft26">First Name <span class="input_required">*</span></td>
				 <td><?php e($form->input('UserReference.first_name', array('div'=>false, 'label'=>false, "class" => "Testbox5")));?></td>
			  </tr>
			   <tr>
				 <td valign="middle" class="Padleft26">Last Name </td>
				 <td><?php e($form->input('UserReference.last_name', array('div'=>false, 'label'=>false, "class" => "Testbox5")));?></td>
			  </tr>
			  <tr>
				 <td valign="middle" class="Padleft26">Status</td>
				 <td>
				 <?php e($form->input('User.status', array('options'=>Configure::read('Status'),'div'=>false, 'label'=>false, "class" => "TextBox5")));?>
				 </td>
			  </tr>
			 		 
			 
		</table>
