<div class="popUpSgnUp">
	<div id="flash_div"></div>
	<?php e($form->create('Register',array('id'=>'popup_signup','controller'=>'registers','action'=>'signup'))); ?>
	<h2>New User Sign Up</h2>
	<div class="popUpSgnUpMid">
		<ul class="popUpSgnUpFrm">
			<li>
				<p class="SgnUpLbl">Email Address</p>
				<p class="SgnUpTxtBx">
				<?php e($form->input('User.email',array('div'=>false,'label'=>false,'class'=>'SgnUpTxtBxFld',"error" => array("wrap" => "span", "class" => "error_msg")))); ?>
				<span id="UserEmail_error" class ="error_msg"></span>			
				</p>
			</li>
			<li>
				<p class="SgnUpLbl">Password</p>
				<p class="SgnUpTxtBx">
				<?php e($form->input('User.password2',array('type'=>'password','div'=>false,'label'=>false,'class'=>'SgnUpTxtBxFld',"error" => array("wrap" => "span", "class" => "error_msg")))); ?>
				<span id="UserPassword2_error" class ="error_msg"></span>				
				</p>
			</li>
			<li>
				<p class="SgnUpLbl">Confirm Password</p>
				<p class="SgnUpTxtBx">
				<?php e($form->input('User.confirm_password',array('type'=>'password','div'=>false,'label'=>false,'class'=>'SgnUpTxtBxFld',"error" => array("wrap" => "span", "class" => "error_msg")))); ?>
				<span id="UserConfirmPassowd_error" class ="error_msg"></span>				
				</p>
			</li>
			<li>
				<p class="SgnAgree">
				<span><?php e($form->input('UserReference.terms_condtions',array('type'=>'checkbox','div'=>false,'label'=>false,"error" => array("wrap"=>"span","class" => "error_msg")))); ?>
				<span id="UserReferenceTermsCondtions_error" class ="error_msg"></span>	
				</span>
							
				<label>
					I agree to the
					<?php e($html->link('Terms of Use',array('controller'=>'static_pages','action'=>'page','privacy-policy'),array('div'=>false,'label'=>false))); ?>
					and 
					<?php e($html->link('Privacy Policy',array('controller'=>'static_pages','action'=>'page','privacy-policy'),array('div'=>false,'label'=>false))); ?>
				</label>
				</p>
			</li>
			<li>
				<p class="SignUpP"><?php e($form->submit('submit',array('type'=>'button','div'=>false,'label'=>false,'class'=>'SgnUpBtn popup_submit_button','value'=>'Sign Up'))); ?></p>
			</li>
		</ul>
	</div>
	<div class="popUpSgnUpBtm"></div>
	<?php e($form->end()); ?>
</div>
<script type='text/javascript'>
jQuery(".popup_submit_button").click(function(){
	
	var data = jQuery("#popup_signup").serialize();	
	jQuery.ajax({
		url:SiteUrl+'/registers/popup_signup',
		type:'POST',
		data:'data='+data,
		dataType:'json',
		success:function(data){			
			jQuery("#flash_div").html('<div class="'+data.value.Session.element+'">'+data.value.Session.setFlash+'</div>');
			jQuery("#UserEmail_error").html(data.value.User.email);	
			jQuery("#UserPassword2_error").html(data.value.User.password2);
			jQuery("#UserConfirmPassowd_error").html(data.value.User.confirm_password);	
			jQuery("#UserReferenceTermsCondtions_error").html(data.value.UserReference.terms_condtions);			
			/* unset this->data */
			if(data.value.Session.element == 'flash_good' ){
				jQuery("#popup_signup #UserEmail").val('');	
				jQuery("#popup_signup #UserPassword2").val('');
				jQuery("#popup_signup #UserConfirmPassowd").val('');	
				jQuery("#popup_signup #UserReferenceTermsCondtions").val('');
				jQuery("#popup_signup #UserConfirmPassword").val('');
				jQuery("#popup_signup #UserReferenceTermsCondtions").attr('checked',false);					
			
			}
		
		}
	});
});

</script>