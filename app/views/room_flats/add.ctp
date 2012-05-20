	<?php e($javascript->link(array('fckeditor'), false));?>
	<A NAME="middle"></A>
	<div class="InnerMidCntR">
		<?php e($form->create('RoomFlat', array('url' => array('controller' => 'room_flats', 'action' => 'add','#middle'))));?>     
		<h2 class="InnerMidCntRHd">Add Room/Flat</h2>
		<?php e($this->element('room_flats/front_form')); ?>
		<ul class="MyImages">
			<li>
				<label class="MyAccLbl">Upload Image</label>
				<span class="MyAccTxtVal">
					<table>
						<tr>				
							<?php e($this->element('room_flats/add_image')); ?>
						</tr>
					</table>					
				</span>		
			</li>
		</ul>			
		<ul class="MyAccCnts">
			<li>
				<label class="MyAccLbl"><?php e($form->button('<span>Submit </span>', array('type'=>'submit', 'escape'=>false,'class'=>'MyAccSubmit')));?></label>
				<span class="MyAccTxtVal">&nbsp;</span>
			</li>
		</ul>			
		<?php e($form->end());?>	
	</div>