	<?php
	$minrent = 'Min Rent';
	$maxrent = 'Max Rent';
	if(!empty($this->data)){
		$minrent = $this->data['RoomFlat']['minrent'];
		$maxrent = $this->data['RoomFlat']['maxrent'];
	}
	?>
	<A NAME="middle"></A>
	<div class="InnerMidCntR">
		<?php e($form->create('RoomFlat', array('url' => array('controller' => 'room_flats', 'action' => 'add_search','#middle'))));?>     
		<?php $layout->sessionFlash();?>
		<h2 class="InnerMidCntRHd">Advanced Search</h2>
		<ul class="MyAccCnts">
			<li>
				<label class="MyAccLbl">Room / Flat Type <span class="addvalidation">*</span></label>
				<span class="MyAccTxtVal"><?php e($form->input('room_type',array('options'=>$roomType,'div'=>false,'label'=>false,'empty'=>'Please Select Type','class'=>'MyAccDrpDwn')));?></span>
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
				<label class="MyAccLbl">Rent<span class="addvalidation">*</span></label>
				<span class="MyAccTxtVal">
					<?php e($form->input('minrent',array('div'=>false,'label'=>false,'class'=>'MyAccTxtbx','value'=>$minrent,'onblur'=>"this.value==''?this.value=this.defaultValue:null;",'onfocus'=>"this.value==this.defaultValue?this.value='':null;")));?>
				</span>
			</li>
			<li>
				<label class="MyAccLbl">&nbsp;</label>
				<span class="MyAccTxtVal">
					<?php e($form->input('maxrent',array('div'=>false,'label'=>false,'class'=>'MyAccTxtbx','value'=>$maxrent,'onblur'=>"this.value==''?this.value=this.defaultValue:null;",'onfocus'=>"this.value==this.defaultValue?this.value='':null;")));?>
				</span>				
			</li>			
		</ul>
		<ul class="MyAccCnts">	
			<li>
				<label class="MyAccLbl"><?php e($form->button('<span>Submit </span>', array('type'=>'submit', 'escape'=>false,'class'=>'MyAccSubmit')));?></label>
				<span class="MyAccTxtVal">&nbsp;</span>
			</li>
		</ul>		
		<?php e($form->end()); ?>
	</div>
