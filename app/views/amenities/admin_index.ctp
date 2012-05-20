	<div class="adminrightinner">
		<div class="tablewapper2 AdminForm">
			<h3 class="legend1">Search</h3>
			<?php e($form->create('Amenity', array('url'=>array('controller' => 'amenities', 'action' => 'index'))));?>
			<table border="0" width="100%" class="Admin2Table">
				<tbody>
				<tr>
				<td width="18%" valign="middle" class="Padleft26">Amenity Name</td>
				<td><?php e($form->input('Amenity.name', array('type'=>'text','label' => false, 'div'=>false,'class'=>'InputBox1'))); ?></td>
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
			<div class="total" style="float:right"> Total Amenities : <?php e($this->params["paging"]['Amenity']["count"]);?>
			</div>
		</h3>
		<div class="adminrightinner" style="padding:0px;">
			<?php
			e($form->create('Amenity', array('name'=>'Amenity', 'url' => array('controller' => 'amenities', 'action' => 'process'))));
			e($form->hidden('pageAction', array('id' => 'pageAction')));
			e($form->hidden('token_key', array('value' => $this->params['_Token']['key'])));
			if(!empty($data)){
				$exPaginator->options = array('url' => $this->passedArgs);
				$paginator->options(array('url' => $this->passedArgs));?>
				<div class="tablewapper2">	
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Amenity2Table">	
						<tr class="head">
							<td align="center" valign="middle" class="Bdrrightbot Padtopbot6">
							<input name="chkbox_n" id="chkbox_id" type="checkbox" value="" class="Chkbox" onclick="javascript:check_uncheck('Amenity')"	width="5%"  />
							</td>	    
							<td width="65%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;"><?php e($exPaginator->sort('Name', 'Amenity.name'))?>
							</td>
							<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;"><?php e($exPaginator->sort('Created', 'Amenity.created'))?></td>
							<td width="5%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">Status</td>
							<td width="10%"align="center" valign="middle" class="Bdrrightbot Padtopbot6">Action</td>
						</tr>	
						<?php
						foreach($data as $value){?>
							<tr>
								<td align="center" valign="middle" class="Bdrrightbot Padtopbot6">
									<?php e($form->checkbox('Amenity.id'.$value['Amenity']['id'], array("class"=>"Chkbox", 'value'=>$value['Amenity']['id'] ))) ?>
								</td>		
								<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
									<?php e($value['Amenity']['name']);?>
								</td>
								<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
									<?php e($time->niceShort($value['Amenity']['created']));?>
								</td>
								<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
									<?php
									if($value['Amenity']['status']=='1'){
										e($html->image("active.png", array("title" => "Active Amenity", "alt" => "Active", "border" => 0))) ; 
									}else{
										e($html->image("deactive.png", array("title" => "Deactive Amenity", "alt" => "Deactive", "border" => 0))) ;
									}
									?>
								</td>
								<td align="center" valign="middle" class="Bdrbot ActionIcon">
									<?php
									e($admin->getActionImage(array('edit'=>array('controller'=>'amenities', 'action'=>'edit'), 'delete'=>array('controller'=>'amenities', 'action'=>'delete','token'=>$this->params['_Token']['key'])), $value['Amenity']['id']));
									?>
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
						<?php  echo $html->link("Add New", array('controller'=>'amenities', 'action'=>'add'), array("title"=>"", "escape"=>false)); ?>
					</div>
					<?php  e($form->submit('Activate', array('name'=>'activate', 'class'=>'cancel_button', 'type'=>'button', "onclick" => "javascript:return validateChk('Amenity', 'activate');")));?>
					<?php e($form->submit('Deactivate', array('name'=>'deactivate', 'type'=>'button', 'class'=>'cancel_button',  "onclick" => "javascript:return validateChk('Amenity', 'deactivate');")));?>
					<?php e($form->submit('Delete', array('name'=>'delete', 'type'=>'button', 'class'=>'cancel_button',  "onclick" => "javascript:return validateChk('Amenity', 'delete');")));?>
				</div>
				<?php e($form->end());
			}else{?>
				<div style="color:blue, font-size:20; padding-bottom:30px;padding-top:30px;padding-left:280px" ><strong>No Records Found.</strong></div>
				<div class="Addnew_button">
				<?php  echo $html->link("Add New", array('controller'=>'amenities', 'action'=>'add'), array("title"=>"", "escape"=>false)); 			?>
				</div>
				<?php 
			}?>
		</div>
		<div class="clr"></div>
		<?php echo $this->element('admin/admin_paging', array("paging_model_name"=>"Amenity","total_title"=>"Amenity")); ?>	 
	</div>	 