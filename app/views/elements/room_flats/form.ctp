<?php e($javascript->link(array('fckeditor'), false));?>
<table border="0" class="Admin2Table" width="100%">	
	<tr class="AddProFrm">
		<td colspan="2"><h3>Room/Flat information</h3></td>
	</tr>	
	<tr>
		<td valign="middle" class="Padleft26">User List</td>
		<td><?php e($form->input('user_id', array('options'=>$userList,'div'=>false, 'label'=>false, "class" => "Testbox5")));?>
		</td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26">Street address<span class="input_required">*</span> </td>
		<td><?php e($form->input('street_address', array('div'=>false, 'label'=>false, "class" => "Testbox5")));?>
		</td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26">Country<span class="input_required">*</span> </td>
		<td>
			<?php				
			e($form->input('country_id',array('options'=>$countries,'div'=>false,'label'=>false,'empty'=>"Please Select Country","class" => "Testbox5")));
			?>
		</td>
	</tr>
	<tr id="stateOptions">
	<?php e($this->element('room_flats/state')); ?>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26">City<span class="input_required">*</span></td>
		<td>
			<?php  e($form->input('city_name', array('div'=>false, 'label'=>false, "class" => "Testbox5")));?>
		</td>
	</tr>
	
	<tr>
		<td valign="middle" class="Padleft26">ZIP / Postal code </td>
		<td>
			<?php  e($form->input('zipcode', array('div'=>false, 'label'=>false, "class" => "Testbox5")));?>
		
		</td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26">Room/Flat Type<span class="input_required">*</span> </td>
		<td>
			<?php  e($form->input('RoomFlatType.id', array('options'=>$roomType,'div'=>false, 'label'=>false, "class" => "Testbox5")));?>
		
		</td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26">Toatal Room<span class="input_required">*</span> </td>
		<td>
			<?php  e($form->input('total_room', array('options'=>$general->totalRooms(),'div'=>false, 'label'=>false, "class" => "Testbox5")));?>
		
		</td>
	</tr>	
	<tr>
		<td valign="middle" class="Padleft26">Total BathRoom<span class="input_required">*</span> </td>
		<td>
			<?php  e($form->input('total_bathroom', array('options'=>$general->totalBathrooms(),'div'=>false, 'label'=>false, "class" => "Testbox5")));?>
		
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</tr>
	<tr>
		<td valign="middle" class="Padleft26">Description</td>
		<td>
			<?php  e($form->input('RoomFlat.description', array('div'=>false, 'label'=>false, "class" => "textarea")));?>
			<?php echo $fck->load('RoomFlat/description',"Default");?>
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</tr>	
	<tr>
		<td valign="middle" class="Padleft26">Amenities </td>
		<td>
			<?php  e($form->input('Amenity.Amenity', array('multiple'=>'checkbox','options'=>$amenities,'div'=>false, 'label'=>false)));?>
		
		</td>
	</tr>		
	<tr>
		<td valign="middle" class="Padleft26">Rent<span class="input_required">*</span> </td>
		<td>
			<?php  e($form->input('price', array('div'=>false, 'label'=>false, "class" => "Testbox5")));?>
		
		</td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26">Booked</td>
		<td>
			<?php 
			if(isset($this->data['RoomFlat']['booked'])){
				e($form->input('booked', array("type"=>"checkbox", 'div'=>false,'label'=>false)));
			}else{
				e($form->input('booked', array("type"=>"checkbox", 'div'=>false,'label'=>false)));
			}					
			?>			
		</td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26">Not Booked</td>
		<td>
			<?php 
			if(isset($this->data['RoomFlat']['booked']) && $this->data['RoomFlat']['booked'] ==1){
				e($form->input('not_booked', array('checked'=>false,"type"=>"checkbox", 'div'=>false,'label'=>false)));
			}else{
				e($form->input('not_booked', array('checked'=>true,"type"=>"checkbox", 'div'=>false,'label'=>false)));
			}					
			?>		
		</td>
	</tr>	
	<tr>
		 <td valign="middle" class="Padleft26">Status</td>
		 <td>
		 <?php e($form->input('status', array('options'=>Configure::read('Status'),'div'=>false, 'label'=>false, "class" => "TextBox5")));?>
		 </td>
	</tr>
	<?php
	if($this->params['action']=='admin_add'){?>	
		<tr class="AddProFrm">
			<td colspan="2"><h3>Upload room/flat images</h3></td>
		</tr>	
		<tr>
			<td valign="middle" class="Padleft26">Upload Image</td>
			<td><?php e($this->element('room_flats/add_image')); ?></td>			
		</tr>
		<?php
	}elseif(count($this->data['RoomFlatImage']) >0){?>
		<tr class="AddProFrm">
			<td colspan="2"><h3>Uploaded room/flat images</h3></td>
		</tr>	
		<tr>
			<?php e($this->element('room_flats/view_image',array('RoomFlatImageArr'=>$this->data['RoomFlatImage']))); ?>
		</tr>
		<?php
	} ?>	
</table>
	<script type="text/javascript">
		jQuery("#RoomFlatBooked").click(function(){
		  
		   if(jQuery("#RoomFlatBooked").is(':checked') == true) {
				jQuery("#RoomFlatNotBooked").attr('checked', false); 
			}else{
				jQuery("#RoomFlatNotBooked").attr('checked', true);
			}

			
		});
		jQuery("#RoomFlatNotBooked").click(function(){
			
		   if(jQuery("#RoomFlatNotBooked").is(':checked') == true) {
				jQuery("#RoomFlatBooked").attr('checked', false); 
			}else{
				jQuery("#RoomFlatBooked").attr('checked', true);
			}

			
		});
	</script>