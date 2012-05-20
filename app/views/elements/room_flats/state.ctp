	<?php
	if(!isset($states)){
		$states = '';
	}
	if(!isset($action)){
		$action = '';
	}
	?>
	<?php
	if($this->params['action'] =='admin_add' || $this->params['action'] =='admin_edit' || $action == 'admin'){?>
		<td valign="middle" class="Padleft26">State/Province <span class="input_required">*</span></td>
		<td id="loader_login">
			<?php e($form->input('RoomFlat.state_id',array('options'=>$states,'div'=>false,'label'=>false,"class" => "Testbox5",'empty'=>'Select State'))); ?>
		</td>
		<?php
	}else{?>
		<label class="MyAccLbl">State<span class="addvalidation">*</span></label>
		<span class="MyAccTxtVal" id="loader_login"><?php e($form->input('RoomFlat.state_id',array('options'=>$states,'div'=>false,'label'=>false,'class'=>'MyAccDrpDwn','empty'=>'Select State')));?></span>
		<?php
	}?>
	
	