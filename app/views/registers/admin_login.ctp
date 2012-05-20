	<div class="loginBlock">	
		<div class="LoginContent">		
		<?php $layout->sessionFlash();?>	
			<?php e($form->create('Admin', array('url' => array('controller' => 'admins', 'action' => 'login'))));?>
			<p><span class="label">Username</span><?php echo $form->input("username", array("type" => "text", "div" => false, "label" => false)); ?></p>
			<p><span class="label">Password</span><?php echo $form->input("password", array("type" => "password", "div" => false, "label" => false)); ?></p>
			<div><span class="label">&nbsp;</span><?php echo $form->submit("Login", array("class" => "login_btn")); ?></div>
			<?php echo $form->end(); ?>
		</div>
	</div>	