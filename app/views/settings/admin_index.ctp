	<div class="SearchRight">
		<?php e($form->create($modelName, array('url'=>array('controller' => $controllerName, 'action' => 'index'))));?>
		<div class="input text"><label>Search by Setting</label> <?php e($form->input('name', array('label' => false, 'div'=>false,'class'=>'InputBox'))); ?> <?php e($form->submit('Search', array('div'=>false)));?></div>
		<div class="SearchRightAction"></div>
		<?php e($form->end());?>
	</div>
	<div class="adminrightinner">
		<div class="tablewapper2">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Admin2Table">
				<tr class="head">
					<td width="28%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">Setting Name</td>					
					<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">Value</td>
					<td align="center" valign="middle" class="Bdrrightbot Padtopbot6">Action</td>
				</tr>
				<?php 
				foreach($data as $value){?>					
					<tr>
						<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;"><strong><?php e($value[$modelName]['name']);?></strong></td>
						<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;"><?php e($value[$modelName]['value']);?></td>
						<td align="center" valign="middle" class="Bdrbot ActionIcon"><?php e($admin->getActionImage(array('edit'=>array('controller'=>$controllerName, 'action'=>'edit')), $value[$modelName]['id'])); ?></td>
					</tr>
					<?php
				}?>
			</table>
		</div>		
	</div>
	<div class="clr"></div>
