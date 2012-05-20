	<A NAME="middle"></A>
	<div class="InnerMidCntR">
		<?php $layout->sessionFlash(); ?>
		<h2 class="InnerMidCntRHd">My Profile Information</h2>
		
			<ul class="MyAccCnts">
				<?php 
				if(isset($data) && count($data) >0){?>						
						<li>
							<table width="100%" cellspacing="0" cellpadding="0" border="0">
								<tr>
									<td valign="top">
										<table width="100%" cellspacing="0" cellpadding="0" border="0">
											<?php
											if(isset($data['UserImage']) && count($data['UserImage']) >0 ){
												$userImageArr = $general->getProfileImage($data['UserImage']);
												$image_path = IMAGE_USER_FOLDER_NAME.'/'.$userImageArr['hash'].'/'.'uploaded_thumb'.'/'.$userImageArr['image_name'];
												//$siteFolder  = dirname(dirname($_SERVER['SCRIPT_FILENAME']));
												
												if(!file_exists(WWW_ROOT.'img/'.$image_path)){
													$image_path = 'default_user_image.png';
												}
											}else{
												$image_path = 'default_user_image.png';
											}?>											
											<tr>
												<td><?php e($html->image($image_path)); ?></td>
											</tr>
											<tr><td>&nbsp;</td></tr>
										</table>
									</td>
									<td width="5%">&nbsp;</td>
									<td valign="top">
										<table width="100%" cellspacing="0" cellpadding="0" border="0">
											<tr>
												<td>
													<ul class="MyAccCnts">
													<li>
														<label class="MyAccLbl">Email:</label>
														<span class="MyAccTxtVal"><?php e($data['User']['email']); ?></span>
													</li>													
													<?php 
													if($data['UserReference']['first_name']){?>
														<li>
															<label class="MyAccLbl">Name:</label>
															<span class="MyAccTxtVal"><?php e(ucwords($data['UserReference']['first_name']).' '.ucwords($data['UserReference']['last_name'])); ?></span>
														</li>					
														<?php
													} ?>
													<?php 
													if($data['UserReference']['street_address']){?>
														<li>
															<label class="MyAccLbl">Street Address:</label>
															<span class="MyAccTxtVal"><?php e(ucwords($data['UserReference']['street_address'])); ?></span>
														</li>					
														<?php
													} ?>
													<?php 
													if($data['UserReference']['Country']){?>
														<li>
															<label class="MyAccLbl">Country:</label>
															<span class="MyAccTxtVal"><?php e($data['UserReference']['Country']['name']); ?></span>
														</li>					
														<?php
													} ?>
													<?php 
													if($data['UserReference']['State']){?>
														<li>
															<label class="MyAccLbl">State:</label>
															<span class="MyAccTxtVal"><?php e($data['UserReference']['State']['name']); ?></span>
														</li>					
														<?php
													} ?>					
													<?php 
													if($data['UserReference']['city_name']){?>
														<li>
															<label class="MyAccLbl">City:</label>
															<span class="MyAccTxtVal"><?php e($data['UserReference']['city_name']); ?></span>
														</li>					
														<?php
													} ?>
													<?php 
													if($data['UserReference']['zipcode']){?>
														<li>
															<label class="MyAccLbl">ZIP / Postal code:</label>
															<span class="MyAccTxtVal"><?php e($data['UserReference']['zipcode']); ?></span>
														</li>					
														<?php
													} ?>
													<li>
														<label class="MyAccLbl">Accessbility:</label>
														<span class="MyAccTxtVal">
														<?php ($data['User']['access_permission'])?e('Public'):e('Private'); ?>
														</span>
													</li>														
													<li>
														<label class="MyAccLbl">Created Date:</label>
														<span class="MyAccTxtVal"><?php e($data['User']['created']); ?></span>
													</li>													
												</ul>
												</td>
											</tr>				
										</table>
									</td>
								</tr>
							</table>
						<li>						
						<?php
			}else{?>
				<li>
					<label class="MyAccLbl">Record Not Found.</label>
				</li>					
				<?php
			}?>
		</ul>
	</div>
       


