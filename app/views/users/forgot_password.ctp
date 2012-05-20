<div id="InnerBlock">
 <div class="InnerBlock2">
  <h2><b>Forgot Password</b></h2>
 <div class="InnerBlockMidd">
 <div id="FormBlock">
  <?php 
	$layout->sessionFlash();		
	e($form->create('User', array('url' => array('controller' => 'users', 'action'=>'forgot_password'))));
  ?>
  <div class="row">
		<span class="label">Email</span>
		<span class="formw">
			 <?php e($form->input('email', array('label'=>false, 'div'=>false)));?>
		</span>
	</div>	
   <div class="submit">
		
			
				<?php e($form->button('<span>Submit</span>', array('type'=>'submit', 'escape'=>false,'class'=>'OrngBtn')));?>		
			 
		
	</div>  
 <?php e($form->end());?>
  </div>
 </div>
 </div>
 </div>