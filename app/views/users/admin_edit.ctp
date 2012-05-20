<div class="adminrightinner">
     <?php 
       e($form->create('User', array('url' => array('controller' => 'users', 'action' => 'edit'))));
       e($form->input('User.id'));
	   e($form->input('UserReference.id'));
		
      ?>    
	 <div class="tablewapper2 AdminForm">
	  <h3 class="legend1">Edit Admin User </h3>
		<?php e($this->element('admin/edit_form'));?>
      </div>
      <div class="buttonwapper">
				<div><input type="submit" value="Submit" class="submit_button" /></div>
				<div class="cancel_button"><?php echo $html->link("Cancel", "/admin/users/index/", array("title"=>"", "escape"=>false)); ?></div>
		</div>
		<?php
		   e($form->end());
		?>	
</div>

