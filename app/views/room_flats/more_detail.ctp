	<?php
	if(isset($this->params['named']['page'])){
		$page = $this->params['named']['page'];
	}else{
		$page = 1;
	}?>	
	<?php echo $html->css(array('imggallery/prettyPhoto','imggallery/slide_style')); ?>
	<?php echo $javascript->link(array('imggallery/jcarousellite_1.0.1','imggallery/jquery.prettyPhoto')); ?>
	<A NAME="middle"></A>
	<div class="InnerMidCntR">
		<div id="LoadingDiv" style="position:absolute;margin-top:0%;left:75%;"></div>		
		<h2 class="InnerMidCntRHd">Room/Flat Detail<span class="back"><?php e($html->link('Back',array('controller'=>'room_flats','action'=>$prevAction,'page:'.$page,'#middle'))); ?></span></h2>
		<div class="faceTwee"><?php  e($this->element('room_flats/facebook')); ?><?php e($this->element('room_flats/tweeter')); ?></div>
		<?php 
			if(count($data)>0){?>	
				<ul class="MyAccCnts RoomFlateDe">					
					<li class="RoomFlateLeft">
						<div class="home_head">
							<h1>								
								<span>
									<?php e(ucfirst($data['RoomFlat']['city_name'])); ?>
									<?php e(ucfirst($data['RoomFlatType']['name'])); ?>
								</span>
								<?php
								if($prevAction == 'index'){?>
									<span style='color:#FE6200'><?php ($data['RoomFlat']['booked'])?e('- Booked'):e(' - Not Booked'); ?></span>
									<?php
								}?>
							</h1>
							<p>
							<?php
							$link = ucfirst($data['RoomFlat']['street_address']) . "," . ucfirst($data['RoomFlat']['city_name']) . "," . ucfirst($data['State']['name']) . "-" . $data['RoomFlat']['zipcode'].",".$data['Country']['iso_code'];
							$url = "window.open('".Router::url(array('controller'=>'room_flats','action'=>'view_room_flat_areas',$data['RoomFlat']['id']))."', 'Window1', 'menubar=no, width=600, height=550, toolbar=no, scrollbars=1')";
							?>
							<em>
								<?php e($link); ?>
							</em>
							</p>
						</div>
						<div class="home_left">
							<table cellspacing="0" cellpadding="0" border="0" class="home_info1" width="100%">
								<tr>
									<td width="35%"><strong>Rent</strong></td>
									<td width="3%"><strong>:</strong></td>
									<td class="red"><strong> $<?php e(number_format($data['RoomFlat']['price'],2)); ?> </strong></td>
								</tr>
								<tr>
									<td valign="top"><strong>Type</strong></td>
									<td><strong>:</strong></td>
									<td> <?php e(ucfirst($data['RoomFlatType']['name'])); ?> </td>
								</tr>
								<tr>
									<td valign="top"><strong>Address</strong></td>
									<td><strong>:</strong></td>
									<td><?php e(ucfirst($data['RoomFlat']['street_address'])); ?></td>
								</tr>
								<tr>
									<td valign="top"><strong>City</strong></td>
									<td><strong>:</strong></td>
									<td><?php e(ucfirst($data['RoomFlat']['city_name'])); ?></td>
								</tr>
								<tr>
									<td valign="top"><strong>State</strong></td>
									<td><strong>:</strong></td>
									<td><?php e(ucfirst($data['State']['name'])); ?></td>
								</tr>
								<tr>
									<td valign="top"><strong>Country</strong></td>
									<td><strong>:</strong></td>
									<td><?php e($data['Country']['iso_code']); ?></td>
								</tr>
								<tr>
									<td valign="top"><strong>ZIP Code</strong></td>
									<td><strong>:</strong></td>
									<td><?php e($data['RoomFlat']['zipcode']); ?></td>
								</tr>						
								<tr>
									<td><strong>Total Room</strong></td>
									<td><strong>:</strong></td>
									<td> <?php e($data['RoomFlat']['total_room']); ?> </td>
								</tr>
								<tr>
									<td><strong>Total Bathroom</strong></td>
									<td><strong>:</strong></td>
									<td> <?php e($data['RoomFlat']['total_bathroom']); ?> </td>
								</tr>
							</table>
						</div>
						<div class="contact_owner">
							<h3>Contact Owner</h3>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="20%">Name</td>
									<td>
										<span class="special">
											<?php e(ucfirst($data['User']['UserReference']['first_name']))?>&nbsp;<? e(ucfirst($data['User']['UserReference']['last_name']));?>
										</span>
									</td>
								</tr>
								<tr>
									<td>Email</td>
									<td><a href="mailto:<?php echo $data['User']['email']; ?>"><span class="special"><?=$data['User']['email']?></span></a></td>
								</tr>
							</table>
						</div>				
					</li>				
					<li>
						<div class="home_right1">
							<?php /* ==================================================== */ ?>
							<?php 
							if(!empty($data['RoomFlatImage'])){?>
							<div class="DGlLrgTh"  style="min-height:220px;border:solid 1px;">
								<ul class="gallery clearfix" style="list-style-type: none;">
									<?php 
									$j=0; 
									foreach($data['RoomFlatImage'] as $key=>$proImage){
										$uploaded_image_path = SITE_URL.'/img/'.IMAGE_ROOM_FLAT_FOLDER_NAME.'/'.$proImage['hash'].'/uploaded/'.$proImage['image_name'];
										$large_image_path = SITE_URL.'/img/'.IMAGE_ROOM_FLAT_FOLDER_NAME.'/'.$proImage['hash'].'/uploaded_large/'.$proImage['image_name'];
										
										if($j>0){ 
											$tempCSS = 'style="display:none;"';
										}else {
											$tempCSS = '';    
										}?>
										<li <?php echo $tempCSS;?>>
											<a href="<?php e($large_image_path); ?>" rel="prettyPhoto[gallery2]" title="" id="abcHref">
											<?php
											e($html->image($large_image_path, array('alt'=>'room/flat image','title'=>'room/flat image','class'=>'abc')));
											?>
											</a>
										</li>
										<?php 
										$j++; 
									} ?>
								</ul>
							</div>
							
							<div id="list">
								<div class="prev"><?php e($html->image('left_arrow.gif',array('alt'=>'prev'))); ?></div>
								<div class="slider">
									<ul>
										<?php 
										foreach($data['RoomFlatImage'] as $key=>$proImage){
											$small_image_path = SITE_URL.'/img/'.IMAGE_ROOM_FLAT_FOLDER_NAME.'/'.$proImage['hash'].'/uploaded_thumb/'.$proImage['image_name'];
										
											?>
											<li style="overflow:scroll;width:79px;vertical-align:top; ">
											<?php e($html->image($small_image_path, array('alt'=>'room/flat','title'=>'room/flat', 'width'=>'77', 'height'=>'78', 'class'=>"captify" )));?>  
											</li>
											<?php 
										} ?>
									</ul>
								</div>
								<div class="next">
									<?php e($html->image('right_arrow.gif',array('alt'=>'next'))); ?>
								</div>
							</div>
							<?php 
							} else{ 
								e($html->image('home.jpg',array('title'=>'No Image')));

							} ?>					
							<?php /* ===================================================== */ ?>
							<div class="clr"></div>
						</div>				
					</li>
				</ul>
				<!-- ================Amenities=============== -->
				<?php
				if(count($data['Amenity'])>0){?>					
					<div class="DescTxtM home_head" style="margin:5px 0 5px 0;">
						<h1>Amenities</h1>
						<table width="100%" cellspacing="0" cellpadding="0" border="0">
							<?php 
							foreach($data['Amenity'] as $key=>$amenities){?>
								<tr>
									<td width="2%"><strong><?php e(++$key.'.'); ?></strong></td>
									<td><?php e($amenities['name']); ?></td>
								</tr>
								<?php
							}?>
						</table>
					</div>						
					<?php 
				}?>
			
				<!-- ================Description=============== -->
				<?php
				if(!empty($data['RoomFlat']['description'])){?>			
					<div class="DescTxtM  home_head">
						<h1>Description</h1>
						<?php e($data['RoomFlat']['description']); ?> 
					</div>
					<?php 
				}?>				
				<?php
			}else{?>	

				<ul class="MyAccCnts RoomFlateDe">			
					<li>
						<label class="MyAccLbl">Record Not Found.</label>
					</li>
				</ul>
				<?php
			}?>
			
			<?php //e($this->element('room_flats/list_room_flat')); ?>
		
		
		
	</div>	
	<script type ="text/javascript">
		jQuery(document).ready(function(){
			jQuery("area[rel^='prettyPhoto']").prettyPhoto();
			jQuery(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: false});
			jQuery(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});

		});
		jQuery(function() {
			jQuery(".slider").jCarouselLite({
				btnNext: ".next",
				btnPrev: ".prev",
				visible: 4,
				circular: false
			});
		});
    
		jQuery(".captify ").click(function() {  
		
			var tyu = jQuery(this).attr("src");
			var large_image_path = tyu.replace("uploaded_thumb", "uploaded_large");
			
			jQuery(".abc").attr("src", large_image_path);
			jQuery("#abcHref").attr("href", large_image_path);
		
		});							
	</script>