<table border="0" class="Admin2Table" width="100%">						
			  <tr>
				 <td valign="middle" class="Padleft26"  width="20%">Country Name <span class="input_required">*</span></td>
				 <td><?php e($form->input('name', array('div'=>false, 'label'=>false, "class" => "Testbox5")));?></td>
			  </tr>
				<tr>
				 <td valign="middle" class="Padleft26"  width="20%">Country iso code  <span class="input_required">*</span></td>
				 <td><?php e($form->input('iso_code', array('div'=>false, 'label'=>false, "class" => "Testbox5")));?></td>
			  </tr>
			  	
			  	
			   <tr>
				 <td valign="middle" class="Padleft26">Status</td>
				 <td>
				 <?php e($form->input('status', array('options'=>Configure::read('Status'),'div'=>false, 'label'=>false, "class" => "TextBox5")));?>
				 </td>
			  </tr>	
</table>