<div class="adminrightinner">
     <?php 
	 e($form->create('City', array('url' => array('controller' => 'cities', 'action' => 'edit'))));
	 e($form->hidden('City.id'));
	 e($form->hidden('token_key', array('value' => $this->params['_Token']['key'])));
	 ?>     
	 <div class="tablewapper2 AdminForm">
  <h3 class="legend1">Edit  City
 </h3>	 
		<?php e($this->element('admin/city/form'));?>
      </div>
      <div class="buttonwapper">
				<div><?php e($form->submit('Submit', array('class' => 'submit_button')));?></div>
				<div class="cancel_button">
				<?php e($html->link("Cancel", array('admin'=>true, 'controller'=>'cities', 'action'=>'index'), 
					array("title"=>"", "escape"=>false)));?>
				</div>
		</div>
		<?php
		   e($form->end());
		?>	
</div>