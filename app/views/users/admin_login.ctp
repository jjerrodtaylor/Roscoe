	<div class="loginBlock">	
		<div class="LoginContent">		
		<?php $layout->sessionFlash();?>	
			<?php e($form->create('User', array('url' => array('controller' => 'users', 'action' => 'login'))));?>
			<p><span class="label">Email </span>
			<?php echo $form->input("email", array("type" => "text", "div" => false, "label" => false)); ?>
			</p>
			<p>
			<span class="label">Password</span>
			<?php echo $form->input("password", array("type" => "password", "div" => false, "label" => false)); ?>
			</p>
			<div><span class="label">&nbsp;</span><?php echo $form->submit("Login", array("class" => "login_btn")); ?></div>
			<?php echo $form->end(); ?>
		</div>
	</div>	
	