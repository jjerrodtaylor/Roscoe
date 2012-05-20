	<div class="adminrightinner">
		<div class="tablewapper2 AdminForm">
			<h3 class="legend1">Search</h3>
			<?php e($form->create($modelName, array('url'=>array('controller' => $this->params['controller'], 'action' => 'index'))));?>
			<table border="0" width="100%" class="Admin2Table">
				<tbody>
				<tr>
				<td width="18%" valign="middle" class="Padleft26">User Email</td>
				<td><?php e($form->input('User.email', array('type'=>'text','label' => false, 'div'=>false,'class'=>'InputBox1'))); ?></td>
				</tr> 
				<tr>
				<td valign="middle" class="Padleft26">&nbsp;</td>
				<td align="left"> 
				<?php e($form->submit('Search', array('div'=>false, 'class'=>'submit_button')));?>                 
				</td>
				</tr>              
				</tbody>
			</table> 
			<?php e($form->end());?>    
			<div style="clear: both;"></div>
		</div>
	</div>
	<div class="fieldset">
		<h3 class="legend">
			Search Results
			<div class="total" style="float:right"> Total Room/flat : <?php e($this->params["paging"][$modelName]["count"]);?>
			</div>
		</h3>
		<div class="adminrightinner" style="padding:0px;">
			<?php
			e($form->create($modelName, array('name'=>$modelName, 'url' => array('controller' => $this->params['controller'], 'action' => 'process'))));
			//e($form->create($modelName, array('url' => array('controller' => $this->params['controller'], 'action' => 'process'),array('name'=>$modelName))));
			e($form->hidden('pageAction', array('id' => 'pageAction')));
			//e($form->hidden('token_key', array('value' => $this->params['_Token']['key'])));
			if(!empty($data)){
				$exPaginator->options = array('url' => $this->passedArgs);
				$paginator->options(array('url' => $this->passedArgs));?>
				<div class="tablewapper2">	
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Amenity2Table">	
						<tr class="head">
							<td align="center" valign="middle" class="Bdrrightbot Padtopbot6">
							<input name="chkbox_n" id="chkbox_id" type="checkbox" value="" class="Chkbox" onclick="javascript:check_uncheck('<?php e($modelName);?>')"	width="5%"  />
							</td>	    
							<td width="25%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;"><?php e($exPaginator->sort('User Email', 'User.email'))?>
							</td>
							<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;"><?php e($exPaginator->sort('Room/Flat City', $modelName.'.city_name'))?>
							</td>
							<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;"><?php e($exPaginator->sort('Room/Flat Type', 'RoomFlatType.name'))?>
							</td>
							<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;"><?php e($exPaginator->sort('Total Rooms', $modelName.'.total_room'))?>
							</td>
							<td width="10%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;"><?php e($exPaginator->sort('Price', $modelName.'.price'))?>
							</td>							
							<td width="5%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">Status</td>
							<td width="10%"align="center" valign="middle" class="Bdrrightbot Padtopbot6">Action</td>
						</tr>	
						<?php
						foreach($data as $value){?>
							<tr>
								<td align="center" valign="middle" class="Bdrrightbot Padtopbot6">
									<?php e($form->checkbox($modelName.'.id'.$value[$modelName]['id'], array("class"=>"Chkbox", 'value'=>$value[$modelName]['id'] ))) ?>
								</td>		
								<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
									<?php e($value['User']['email']);?>
								</td>
								<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
									<?php e($value[$modelName]['city_name']);?>
								</td>
								<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
									<?php e($value['RoomFlatType']['name']);?>
								</td>
								<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
									<?php e($value[$modelName]['total_room']);?>
								</td>
								<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
									<?php e($value[$modelName]['price']);?>
								</td>								
								<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
									<?php
									if($value[$modelName]['status']=='1'){
										e($html->image("active.png", array("title" => "Active Room/Flat", "alt" => "Active", "border" => 0))) ; 
									}else{
										e($html->image("deactive.png", array("title" => "Deactive Room/Flat", "alt" => "Deactive", "border" => 0))) ;
									}
									?>
								</td>
								<td align="center" valign="middle" class="Bdrbot ActionIcon">
									<?php
									e($admin->getActionImage(array('edit'=>array('controller'=>$this->params['controller'], 'action'=>'edit'), 'delete'=>array('controller'=>$this->params['controller'], 'action'=>'delete','token'=>$this->params['_Token']['key'])), $value[$modelName]['id']));
									?>
									<?php e($html->link($html->image('insert-room-flat.png',array('height'=>18,'width'=>18)),array('controller'=>'room_flats','action'=>'addimage',$value['RoomFlat']['id']),array('escape'=>false,'title'=>'Add Images'))); ?>		
									
								</td>
							</tr>	
							<?php
						}?>
					</table>
				</div>
				<?php
			}?>
			<?php  if(!empty($data)){ ?>
				<div class="buttonwapper">
					<div class="Addnew_button">
						<?php  echo $html->link("Add New", array('controller'=>$this->params['controller'], 'action'=>'add'), array("title"=>"", "escape"=>false)); ?>
					</div>
					<?php  e($form->submit('Activate', array('name'=>'activate', 'class'=>'cancel_button', 'type'=>'button', "onclick" => "javascript:return validateChk('".$modelName."', 'activate');")));?>
					<?php e($form->submit('Deactivate', array('name'=>'deactivate', 'type'=>'button', 'class'=>'cancel_button',  "onclick" => "javascript:return validateChk('".$modelName."', 'deactivate');")));?>
					<?php e($form->submit('Delete', array('name'=>'delete', 'type'=>'button', 'class'=>'cancel_button',  "onclick" => "javascript:return validateChk('".$modelName."', 'delete');")));?>
				</div>
				<?php e($form->end());
			}else{?>
				<div style="color:blue, font-size:20; padding-bottom:30px;padding-top:30px;padding-left:280px" ><strong>No Records Found.</strong></div>
				<div class="Addnew_button">
				<?php  echo $html->link("Add New", array('controller'=>$this->params['controller'], 'action'=>'add'), array("title"=>"", "escape"=>false)); 			?>
				</div>
				<?php 
			}?>
		</div>
		<div class="clr"></div>
		<?php echo $this->element('admin/admin_paging', array("paging_model_name"=>$modelName,"total_title"=>$modelName)); ?>	 
	</div>	 