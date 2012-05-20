	<?php e($javascript->link(array('fckeditor'), false));?>
	<A NAME="middle"></A>
	<div class="InnerMidCntR">
		<?php e($form->create('RoomFlat', array('url' => array('controller' => 'room_flats', 'action' => 'edit','#middle'))));?>     
		<?php e($form->hidden('RoomFlat.id')); ?>
		<h2 class="InnerMidCntRHd">Edit Room/Flat</h2>
		<?php e($this->element('room_flats/front_form')); ?>
		<?php
		if(count($this->data['RoomFlatImage']) >0){ ?>
			<h2 class="InnerMidCntRIMHd">Uploaded Images : </h2>
			<ul class="MyImages">
				<li>
					<table>
						<tr>
							<?php e($this->element('room_flats/view_image',array('RoomFlatImageArr'=>$this->data['RoomFlatImage']))); ?>
						</tr>
					</table>
				</li>
			</ul>
			<?php
		}?>
		<ul class="MyAccCnts">	
			<li>
				<label class="MyAccLbl"><?php e($form->button('<span>Submit </span>', array('type'=>'submit', 'escape'=>false,'class'=>'MyAccSubmit')));?></label>
				<span class="MyAccTxtVal">&nbsp;</span>
			</li>
		</ul>			
		<?php e($form->end());?>	
	</div>