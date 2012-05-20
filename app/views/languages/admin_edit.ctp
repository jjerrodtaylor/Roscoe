<div class="adminrightinner">
     <?php 
       e($form->create('Language', array('url' => array('controller' =>'languages', 'action' => 'edit'))));
        e($form->input('Language.id'));
      ?>        
	 <div class="tablewapper2 AdminForm">	
			<?php e($this->element('language/form'));?>
      </div>
      <div class="buttonwapper">
				<div><?php e($form->submit('Submit', array('class' => 'submit_button')));?></div>
				<div class="cancel_button">
				<?php e($html->link("Cancel", array('admin'=>true, 'controller'=>'languages', 'action'=>'index'), 
					array("title"=>"", "escape"=>false)));?>
				</div>
		</div>
		<?php
		   e($form->end());
		?>	
</div>