<?php e($javascript->link(array('fancybox/jquery.fancybox-1.3.4.pack','fancybox/jquery.mousewheel-3.0.4.pack'),false)); ?>
<?php e($html->css(array('jquery.fancybox-1.3.4'),false)); ?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.addRoomFlatImage').fancybox();
});		
</script>
<?php
if(isset($this->params['named']['page'])){
	$page = $this->params['named']['page'];
}else{
	$page = 1;
}
if(isset($data) && count($data) >0){
	e($this->element('room_flats/search_keyword',array('page'=>$page)));
	?>
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
								<?php //pr($roomFlatDetail['User']['id']); ?>
								<?php e($html->link('Contact Owner',array('controller'=>'registers','action'=>'contact_owner',$roomFlatDetail['User']['id']),array('class'=>'contactOw addRoomFlatImage'))); ?>
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
		<?php e($this->element('paging',array('ModelName'=>'RoomFlat','ControllerName'=>'room_flats','action'=>$this->params['action']))); ?>			
	</li>
	<?php
}else{?>
	<li>
		<label class="MyAccLbl">Record Not Found.</label>
	</li>					
	<?php
}?>