	<div class="adminrightinner">
		<?php e($form->create('QuestionOption', array('url' => array('controller' => 'question_options', 'action' => 'add'))));?>     
		<div class="tablewapper2 AdminForm">
			<?php e($form->hidden('QuestionOption.id')); ?>
			<?php e($this->element('question_options/form'));?>
		</div>
		<div class="buttonwapper">
			<div><?php e($form->submit('Submit', array('class' => 'submit_button')));?></div>
			<div class="cancel_button">
				<?php e($html->link("Cancel", array('admin'=>true, 'controller'=>'question_options', 'action'=>'index'), 
				array("title"=>"", "escape"=>false)));
				?>
			</div>
		</div>
		<?php
		e($form->end());
		?>	
	</div>