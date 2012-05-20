	<div class="adminrightinner">
		<?php e($form->create('EmailTemplate', array('url' => array('controller' => 'email_templates', 'action' => 'add'))));?>     
		<div class="tablewapper2 AdminForm">	
			<?php e($this->element('admin/email_template/form'));?>
		</div>
		<div class="buttonwapper">
			<div><?php e($form->submit('Submit', array('class' => 'submit_button')));?></div>
			<div class="cancel_button">
				<?php e($html->link("Cancel", array('admin'=>true, 'controller'=>'email_templates', 'action'=>'index'), 
				array("title"=>"", "escape"=>false)));
				?>
			</div>
		</div>
		<?php
		e($form->end());
		?>	
	</div>