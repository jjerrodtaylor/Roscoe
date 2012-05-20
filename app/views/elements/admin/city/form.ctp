<table border="0" class="Admin2Table" width="100%">					 
			  <tr>
				 <td valign="middle" class="Padleft26" width="20%">Country <span class="input_required">*</span></td>
				 <td><?php e($form->input('country_id', array('div'=>false, 'label'=>false, "class" => "Testbox5", 
				 'empty'=>'Select Country')));
				 e($ajax->observeField('CityCountryId', array('update'=>'updateState', 
									    'url'=>array('controller' =>'states', 'action'=>'getStateList', 'model'=>'City'))
									));
				 ?>
				 </td>
			  </tr>	
			  <tr>
				 <td valign="middle" class="Padleft26">State <span class="input_required">*</span></td>
				 <td id="updateState"><?php e($form->input('state_id', array('div'=>false, 'label'=>false, "class" => "Testbox5", 'empty'=>'Select State')));?></td>
			  </tr>				  
			  <tr>
				 <td valign="middle" class="Padleft26">Name <span class="input_required">*</span></td>
				 <td><?php e($form->input('name', array('div'=>false, 'label'=>false, "class" => "Testbox5")));?></td>
			  </tr>	
			   <tr>
				 <td valign="middle" class="Padleft26">Status</td>
				 <td>
				 <?php e($form->input('status', array('options'=>Configure::read('Status'),'div'=>false, 'label'=>false, "class" => "TextBox5")));?>
				 </td>
			  </tr>	
		</table>
		