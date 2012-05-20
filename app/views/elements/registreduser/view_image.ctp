	<td colspan="2">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">	
			<tr>
				<td colspan="4" id="image_loader"></td>
			</tr>		
			<tr>
				<td colspan="4">
					<div id ="newreleaseresult">
						<ul style="width:100%">
							<?php 
								foreach($UserImageArr as $key=>$images){
							?>
								<li id="viewImage_<?php e($images['id']);?>" style="float:left;border:2px solid #E5EECC; margin:3px;list-style-type:none;">
									<div>
										<table width="100%" cellpadding="0" cellspacing="0" border="0">
											<tr>
												<td colspan="2" style="padding:20px;">
												<?php
												e($html->image('user_images/'.$images['hash'].'/uploaded_thumb/'.$images['image_name'],array('width'=>100,'heigh'=>100)));
												?>
												</td>
											</tr>
											<tr>
												<td><?php e($html->image('erase01.png',array('alt'=>$images['id'],'width'=>24,'height'=>24,'class'=>'delete_image','style'=>'cursor:pointer;','title'=>'Delete Image'))); ?></td>
												<td>
													profile image
													<?php
													$cond2 = (isset($this->data['Image']['default']) && $this->data['Image']['default'] == $images['id']);
													if($images['profile_default'] || $cond2){?>
														<input type="radio" name="data[Image][default]" checked value="<?php e($images['id']); ?>"> 					
														<?php 
													}else{ ?>
														<input type="radio" name="data[Image][default]" value="<?php e($images['id']); ?>"> 					
													<?php
													}?>
												</td>
											</tr>
											
										</table>
									</div>
								</li>
								<?php 
								}
								?>
						</ul>
					</div>
				</td>
			</tr>
					
		</table>
	</td>		
	