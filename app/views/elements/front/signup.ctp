<div class="SgnUp">
	<?php
	$layout->sessionFlash();	
	$email_value = '';
	if($this->params['action']=='signup'){
		if(!empty($this->data) && isset($this->data['User']['email'])){
			$email_value =	$this->data['User']['email'];
		}
	}
	
	?>
	<?php e($form->create('Register',array('controller'=>'registers','action'=>'signup'))); ?>
	<h2>New User Sign Up</h2>
	<div class="SgnUpMid">
		<ul class="SgnUpFrm">
			<li>
				<p class="SgnUpLbl">Email Address</p>
				<p class="SgnUpTxtBx">
				<?php
				e($form->input('User.email',array('value'=>$email_value,'div'=>false,'label'=>false,'class'=>'SgnUpTxtBxFld',"error" => array("wrap" => "span", "class" => "error_msg")))); 
				?>
				</p>
			</li>
			<li>
				<p class="SgnUpLbl">Password</p>
				<p class="SgnUpTxtBx"><?php e($form->input('User.password2',array('type'=>'password','div'=>false,'label'=>false,'class'=>'SgnUpTxtBxFld',"error" => array("wrap" => "span", "class" => "error_msg")))); ?></p>
			</li>
			<li>
				<p class="SgnUpLbl">Confirm Password</p>
				<p class="SgnUpTxtBx"><?php e($form->input('User.confirm_password',array('type'=>'password','div'=>false,'label'=>false,'class'=>'SgnUpTxtBxFld',"error" => array("wrap" => "span", "class" => "error_msg")))); ?></p>
			</li>
			<li>
				<p class="SgnAgree"><span><?php e($form->input('UserReference.terms_condtions',array('type'=>'checkbox','div'=>false,'label'=>false,"error" => array("wrap" => "span", "class" => "error_msg")))); ?></span>
				<label>
					I agree to the
					<?php e($html->link('Terms of Use',array('controller'=>'static_pages','action'=>'page','privacy-policy'),array('div'=>false,'label'=>false))); ?>
					and 
					<?php e($html->link('Privacy Policy',array('controller'=>'static_pages','action'=>'page','privacy-policy'),array('div'=>false,'label'=>false))); ?>

				</label>
				</p>
			</li>
			<li>
				<p class="SignUpP"><?php e($form->submit('submit',array('div'=>false,'label'=>false,'class'=>'SgnUpBtn','value'=>'Sign Up'))); ?></p>
			</li>
		</ul>
	</div>
	<div class="SgnUpBtm"></div>
	<?php e($form->end()); ?>
</div>