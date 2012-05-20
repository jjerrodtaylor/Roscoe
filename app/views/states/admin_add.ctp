<div class="adminrightinner">
     <?php 
	 e($form->create('State', array('url' => array('controller' => 'states', 'action' => 'add'))));
	 e($form->hidden('token_key', array('value' => $this->params['_Token']['key'])));
	 ?>     
	 <div class="tablewapper2 AdminForm">	
	   <h3 class="legend1">Add State </h3>
		<?php e($this->element('admin/state/form'));?>
      </div>
      <div class="buttonwapper">
				<div><?php e($form->submit('Submit', array('class' => 'submit_button')));?></div>
				<div class="cancel_button">
				<?php e($html->link("Cancel", array('admin'=>true, 'controller'=>'states', 'action'=>'index'), 
					array("title"=>"", "escape"=>false)));?>
				</div>
		</div>
		<?php
		   e($form->end());
		?>	
</div>