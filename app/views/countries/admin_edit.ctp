<div class="adminrightinner">
     <?php 
		e($form->create('Country', array('url' => array('controller' => 'countries', 'action' => 'edit'))));
		e($form->hidden('Country.id'));
		e($form->hidden('token_key', array('value' => $this->params['_Token']['key'])));
	 ?>     
	 <div class="tablewapper2 AdminForm">	
	   <h3 class="legend1">Edit  Country  </h3>
		<?php e($this->element('admin/country/form'));?>
      </div>
      <div class="buttonwapper">
				<?php e($form->submit('Submit', array('class' => 'submit_button')));?>
				<div class="cancel_button">
				<?php e($html->link("Cancel", array('admin'=>true, 'controller'=>'countries', 'action'=>'index'), 
					array("title"=>"", "escape"=>false)));?>
				</div>
		</div>
		<?php
		   e($form->end());
		?>	
</div>