	<div class="adminrightinner">
		<?php e($form->create($modelName, array('url' => array('controller' => $controllerName, 'action' => 'add'))));?>
		<div class="tablewapper2 AdminForm"><?php e($this->element('setting/admin_add'));?></div>
		<div class="buttonwapper">
			<div><input type="submit" value="Submit" class="submit_button" /></div>
			<div class="cancel_button"><?php echo $html->link("Cancel", "/admin/settings/index/", array("title"=>"", "escape"=>false)); ?></div>
		</div>
		<?php  e($form->end());	?>	
	</div>

