<div class="adminrightinner">
	<?php e($form->create('User', array('url' => array('controller' => 'registers', 'action' => 'add'))));?>     
	<div class="tablewapper2 AdminForm">
		<h3 class="legend1">Add Users</h3>
		<?php e($this->element('registreduser/form'));?>
	</div>
	<div class="buttonwapper">
		<div><input type="submit" value="Submit" class="submit_button" /></div>
		<div class="cancel_button"><?php echo $html->link("Cancel", "/admin/registers/index/", array("title"=>"", "escape"=>false)); ?>
		</div>
	</div>
	<?php e($form->end()); ?>	
</div>

