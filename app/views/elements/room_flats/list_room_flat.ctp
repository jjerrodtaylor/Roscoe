<?php
if(isset($this->params['named']['page'])){
	$page = $this->params['named']['page'];
}else{
	$page = 1;
}?>
<?php 
if(isset($data) && count($data) >0){?>
	<li>
		<div class="RoomFlatList">
			<?php
			
			foreach($data as $key=>$roomFlatDetail){?>
				<?php
				$class = ($key%2)?'even':'odd';
				?>
				<div class='<?php e($class); ?> RoomFlatLi'>
					<div class="RoomFlatImg">
						<?php					
						if(isset($roomFlatDetail['RoomFlatImage'][0]['image_name'])){
							$image_name = $roomFlatDetail['RoomFlatImage'][0]['image_name'];
							$hash = $roomFlatDetail['RoomFlatImage'][0]['hash'];
							$path = WWW_ROOT.'img'.DS.IMAGE_ROOM_FLAT_FOLDER_NAME.DS.$hash.DS.'uploaded_thumb'.DS.$image_name;
							if(file_exists($path)){
								$image = $html->image(IMAGE_ROOM_FLAT_FOLDER_NAME.'/'.$hash.'/'.'uploaded_thumb'.'/'.$image_name,array('title'=>'Room/Flat Image','width'=>80,'height'=>80));
								e($html->link($image,array('controller'=>'room_flats','action'=>'more_detail',$roomFlatDetail['RoomFlat']['id'],'#middle'),array('escape'=>false)));
							}else{
								$image = $html->image('home.jpg',array('title'=>'No image for room/flat','width'=>80,'height'=>80));
								e($html->link($image,array('controller'=>'room_flats','action'=>'more_detail',$roomFlatDetail['RoomFlat']['id'],'#middle'),array('escape'=>false)));
							
							}
						}else{
							$image = $html->image('home.jpg',array('title'=>'No image for room/flat','width'=>80,'height'=>80));
							e($html->link($image,array('controller'=>'room_flats','action'=>'more_detail',$roomFlatDetail['RoomFlat']['id'],'#middle'),array('escape'=>false)));
						}?>									
					</div>
					<div class="RoomFlatTxt">
						<table width="100%" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td valign="top">
									<h1>
										<?php 
										$h1_info = '';
										if(isset($roomFlatDetail['RoomFlat']['city_name'])){
											$h1_info .= ucfirst($roomFlatDetail['RoomFlat']['city_name']).', ';
										}
										if(isset($roomFlatDetail['RoomFlatType']['name'])){
											$h1_info .= ucfirst($roomFlatDetail['RoomFlatType']['name']);
										}						
										?>
										<span class="address">
											<?php e($h1_info); ?>
										</span> 
										<span style='color:#FE6200'><?php ($roomFlatDetail['RoomFlat']['booked'])?e('- Booked'):e('- Not Booked'); ?></span>
									</h1>									
									<p>
										<em>
										<?php e(ucfirst($roomFlatDetail['RoomFlat']['street_address']) . "," . ucfirst($roomFlatDetail['RoomFlat']['city_name']) . "," . ucfirst($roomFlatDetail['State']['name']) . "-" . $roomFlatDetail['RoomFlat']['zipcode'].",".$roomFlatDetail['Country']['iso_code']); ?>
										</em>
									</p>
									<p class="small">
									<?php e($text->truncate($roomFlatDetail['RoomFlat']['description'],100)); ?><br>
									<?php e($html->link('More Detail',array('controller'=>'room_flats','action'=>'more_detail',$roomFlatDetail['RoomFlat']['id'],'preaction:'.$this->params['action'],'page:'.$page,'#middle'),array('class'=>'ReadMore'))); ?>
									</p>													
								</td>
								<td valign="top" align="right" width="10%">
									<h1 class="Price">$<?php e(number_format($roomFlatDetail['RoomFlat']['price'],2)); ?></h1>
								</td>
							</tr>
							<tr>												
								<td colspan="2" align="right">
								<?php e($html->link($html->image('edit.jpg',array('width'=>15,'heigh'=>14)),array('controller'=>'room_flats','action'=>'edit',$roomFlatDetail['RoomFlat']['id'],'#middle'),array('escape'=>false)));?>
								&nbsp;&nbsp;
								<?php e($html->link($html->image('erase01.png',array('width'=>15,'heigh'=>14,'class'=>'delete_room_flat','title'=>'Delete Room/Flat','alt'=>$roomFlatDetail['RoomFlat']['id'])),'javascript:void(0);',array('escape'=>false)));?>
								&nbsp;&nbsp;
								<?php e($html->link($html->image('insert-room-flat.png',array('width'=>15,'heigh'=>14)),array('controller'=>'room_flats','action'=>'addimage',$roomFlatDetail['RoomFlat']['id']),array('escape'=>false,'class'=>'addRoomFlatImage')));?>												
								</td>
							</tr>
							
						</table>					
					</div>
				</div>
				
				<?php
			}?>
		</div>
	</li>
	<li>	
		<?php e($this->element('paging',array('ModelName'=>'RoomFlat','ControllerName'=>'room_flats','action'=>'index'))); ?>			
	</li>
	<?php
}else{?>
	<li>
		<label class="MyAccLbl">Record Not Found.</label>
	</li>					
	<?php
}?>
