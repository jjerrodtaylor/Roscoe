<div class="adminrightinner">
     <?php e($form->create('StaticPage', array('url' => array('controller' => 'static_pages', 'action' => 'edit'))));?>     
	<?php  e($form->input('StaticPage.id'));?>
	 <div class="tablewapper2 AdminForm">	
	<?php echo $this->element('static_page' . DS . 'form'); ?>
      </div>
      <div class="buttonwapper">
				<div><input type="submit" value="Submit" class="submit_button" /></div>
				<div class="cancel_button"><?php echo $html->link("Cancel", array('controller'=>'static_pages', 'action'=>'index'), array("title"=>"", "escape"=>false)); ?></div>
		</div>
	 <?php
	  e($form->end());
	 ?>	
</div>