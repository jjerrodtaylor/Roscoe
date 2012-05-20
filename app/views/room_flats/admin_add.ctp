	<div class="adminrightinner">
		<?php e($form->create($modelName, array('url' => array('controller' => $this->params['controller'], 'action' => 'add'))));?>     
		<div class="tablewapper2 AdminForm">	
			<?php e($this->element('room_flats/form'));?>
		</div>
		<div class="buttonwapper">
			<div><?php e($form->submit('Submit', array('class' => 'submit_button')));?></div>
			<div class="cancel_button">
				<?php e($html->link("Cancel", array('admin'=>true, 'controller'=>$this->params['controller'], 'action'=>'index'), 
				array("title"=>"", "escape"=>false)));
				?>
			</div>
		</div>
		<?php
		e($form->end());
		?>	
	</div>