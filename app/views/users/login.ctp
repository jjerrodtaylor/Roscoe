<div id="InnerBlock">
 <div class="InnerBlock2">
  <h2><b>User Login</b></h2>
 <div class="InnerBlockMidd">
 <div id="FormBlock">
  <?php 
	$layout->sessionFlash();		
	e($form->create('User', array('url' => array('controller' => 'users', 'action'=>'login'))));
	?>	
	<div class="row">
		<span class="label">Username</span>
		<span class="formw">
			 <?php e($form->input('User.username', array('label'=>false, 'div'=>false)));?>
		</span>
	</div>
	<div class="row">
		<span class="label">Password</span>
		<span class="formw">
			 <?php e($form->input('User.password', array('label'=>false, 'div'=>false)));?>
		</span>
	</div>
   <div class="submit">
		<?php e($form->button('<span>Login</span>', array('type'=>'submit', 'escape'=>false,'class'=>'OrngBtn')));?>		
		<div class="ForgotPass" style="margin-top:5px;">
			<?php
				e($html->link('Forgot Password', array('controller'=>'users', 'action'=>'forgot_password')));
			 ?>
		 </div>		
	</div>
		
 <?php e($form->end());?>
 <div class="row" style="padding-left:364px;">
		<?php e($html->link('<span style="color:#FFF;">Register</span>', array('controller'=>'users', 'action'=>'register'),array('escape'=>false,'class'=>'OrngBtn')));?>
		<div style="float: left; padding-left: 10px; margin-top:5px; font:normal 12px Arial; color:#8c8b8b;">
		Not a CellSolo.com member ?
		 </div>		
	</div> 
  </div>
 </div>
 </div>
 </div>