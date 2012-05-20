	<?php e($javascript->link(array('fancybox/jquery.fancybox-1.3.4.pack','fancybox/jquery.mousewheel-3.0.4.pack'))); ?>
	<?php e($html->css(array('jquery.fancybox-1.3.4'),false)); ?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.signup').fancybox();
	});		
	</script>		
	<?php e($form->create('Register',array('controller'=>'registers','action'=>'login'))); ?>
	<ul class="UsrPass">
		<li>
			<?php e($form->input('User.email',array('error'=>false,'div'=>false,'label'=>false,'value'=>'Email','onblur'=>"this.value==''?this.value=this.defaultValue:null;",'onfocus'=>"this.value==this.defaultValue?this.value='':null;"))); ?>
		</li>
		<li style="margin-right:0px;">
			<?php e($form->input('User.password',array('div'=>false,'label'=>false,'value'=>'Password','onblur'=>"this.value==''?this.value=this.defaultValue:null;",'onfocus'=>"this.value==this.defaultValue?this.value='':null;"))); ?>
		</li>		
		<?php //$layout->sessionFlash();?>
		
	</ul>
	<div class="HdrRhtBtm">	
		<p class="Rembr">
			<span>
				<?php e($form->input('User.remember_me',array('type'=>'checkbox','div'=>false,'label'=>false,))); ?>
			</span>
			<label>Remember me</label>
		</p>
		<p class="FPass">
			<?php e($html->link('Forgot your password?',array('controller'=>'registers','action'=>'forget_password'),array('class'=>'signup','div'=>false,'label'=>false))); ?>
		</p>
		<p class="HdrLgn">
			<?php e($form->submit('Login',array('div'=>false,'label'=>false,'class'=>'LgnBtn','value'=>'Login')));?>
		</p>
		<p class="NUsr">New User?
			<?php e($html->link('Sign Up',array('controller'=>'registers','action'=>'popup_signup'),array('div'=>false,'label'=>false,'class'=>'signup'))); ?>
		</p>
	</div>
	<div class="Clear"></div>	
	<?php e($form->end());?>
