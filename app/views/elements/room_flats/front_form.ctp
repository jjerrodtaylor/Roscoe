	<ul class="MyAccCnts">
		<li>
			<label class="MyAccLbl">Street Address <span class="addvalidation">*</span></label>
			<span class="MyAccTxtVal"><?php e($form->input('street_address',array('div'=>false,'label'=>false,'class'=>'MyAccTxtbx')));?></span>
		</li>
		<li>
			<label class="MyAccLbl">Country <span class="addvalidation">*</span></label>
			<span class="MyAccTxtVal"><?php e($form->input('country_id',array('options'=>$countries,'div'=>false,'label'=>false,'empty'=>"Please Select Country",'class'=>'MyAccDrpDwn')));?></span>
		</li>
		<li id="stateOptions">
			<?php e($this->element('room_flats/state')); ?>
		</li>
		<li>
			<label class="MyAccLbl">City <span class="addvalidation">*</span></label>
			<span class="MyAccTxtVal"><?php e($form->input('city_name',array('div'=>false,'label'=>false,'class'=>'MyAccTxtbx')));?></span>
		</li>
		<li>
			<label class="MyAccLbl">ZIP / Postal Code</label>
			<span class="MyAccTxtVal"><?php e($form->input('zipcode',array('div'=>false,'label'=>false,'class'=>'MyAccTxtbx')));?></span>
		</li>
		<li>
			<label class="MyAccLbl">Room / Flat Type <span class="addvalidation">*</span></label>
			<span class="MyAccTxtVal"><?php e($form->input('RoomFlatType.id',array('options'=>$roomType,'div'=>false,'label'=>false,'class'=>'MyAccDrpDwn')));?></span>
		</li>
		<li>
			<label class="MyAccLbl">Total Room <span class="addvalidation">*</span></label>
			<span class="MyAccTxtVal"><?php e($form->input('total_room',array('options'=>$general->totalRooms(),'div'=>false,'label'=>false,'class'=>'MyAccDrpDwn')));?></span>
		</li>
		<li>
			<label class="MyAccLbl">Total BathRoom <span class="addvalidation">*</span></label>
			<span class="MyAccTxtVal"><?php e($form->input('total_bathroom',array('options'=>$general->totalBathrooms(),'div'=>false,'label'=>false,'class'=>'MyAccDrpDwn')));?></span>
		</li>
		<li>
			<label class="MyAccLbl">Description</label>
			<span class="MyAccTxtVal"><?php e($form->input('RoomFlat.description',array('div'=>false,'label'=>false,'class'=>'MyAccTxtArea')));?></span>
			<?php echo $fck->load('RoomFlat/description',"Default");?>
		</li>
		<li>
			<label class="MyAccLbl">Amenities</label>
			<span class="MyAccTxtVal"><?php e($form->input('Amenity.Amenity',array('multiple'=>'checkbox','options'=>$amenities,'div'=>false,'label'=>false,'class'=>'AmenitiesMyAccTxtbx')));?></span>
		</li>
		<li>
			<label class="MyAccLbl">Booked<span class="addvalidation">*</span></label>
			<span class="MyAccTxtVal">
			<?php 
			if(isset($this->data['RoomFlat']['booked'])){
				e($form->input('booked', array("type"=>"checkbox", 'div'=>false,'label'=>false)));
			}else{
				e($form->input('booked', array("type"=>"checkbox", 'div'=>false,'label'=>false)));
			}					
			?>			
			</span>
		</li>
		<li>
			<label class="MyAccLbl">Not Booked<span class="addvalidation">*</span></label>
			<span class="MyAccTxtVal">
			<?php 
			if(isset($this->data['RoomFlat']['booked']) && $this->data['RoomFlat']['booked'] ==1){
				e($form->input('not_booked', array('checked'=>false,"type"=>"checkbox", 'div'=>false,'label'=>false)));
			}else{
				e($form->input('not_booked', array('checked'=>true,"type"=>"checkbox", 'div'=>false,'label'=>false)));
			}					
			?>			
			</span>
		</li>		
		<li>
			<label class="MyAccLbl">Rent<span class="addvalidation">*</span></label>
			<span class="MyAccTxtVal"><?php e($form->input('price',array('div'=>false,'label'=>false,'class'=>'MyAccTxtbx')));?></span>
		</li>		
		<li>
			<label class="MyAccLbl">Status</label>
			<span class="MyAccTxtVal"><?php e($form->input('status', array('options'=>Configure::read('Status'),'div'=>false, 'label'=>false, "class" => "MyAccDrpDwn")));?></span>
		</li>		
	</ul>	
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