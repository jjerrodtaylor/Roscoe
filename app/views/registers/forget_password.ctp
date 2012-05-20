<div class="popUpSgnUp">
	<div id="flash_div"></div>
	<?php e($form->create('Forget',array('url'=>array('controller'=>'registers','action'=>'forget_password'),'id'=>'forgetPassForm'))); ?>
	<h2>Forget Password</h2>
	<h5>To reset your password, enter the email you use to sign in to Iwantaroommate. This can be your Gmail address, or it may be another email address you associated with your account.</h5>
	<div class="popUpSgnUpMid">
		<ul class="popUpSgnUpFrm">
			<li>
				<p class="SgnUpLbl">Email Address</p>
				<p class="SgnUpTxtBx">
				<?php e($form->input('Forget.email',array('div'=>false,'label'=>false,'class'=>'SgnUpTxtBxFld',"error" => array("wrap" => "span", "class" => "error_msg")))); ?>
				<span id="UserEmail_error" class ="error_msg"></span>			
				</p>
			</li>
			<li>
				<p class="SignUpP"><?php e($form->submit('submit',array('type'=>'button','div'=>false,'label'=>false,'class'=>'SgnUpBtn popup_forget_button','value'=>'Sign Up'))); ?></p>
			</li>
		</ul>
	</div>
	<div class="popUpSgnUpBtm"></div>
	<?php e($form->end()); ?>
</div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("form input").attr('autocomplete','off');
		jQuery(".popup_forget_button").click(function(){
			jQuery(".UserEmail_error").hide();
			var hasError = false;
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	 
			var emailaddressVal = jQuery("#ForgetEmail").val();
			if(emailaddressVal == '') {
				jQuery("#UserEmail_error").html('Please enter your email address.');
				hasError = true;
			}else if(!emailReg.test(emailaddressVal)) {
				jQuery("#UserEmail_error").html('Enter a valid email address.');
				hasError = true;
			}
			if(hasError == true){
				return false;
			}else{
				var email = jQuery("#ForgetEmail").val();
				jQuery('#flash_div').html("<img src='"+SITE_URL+"/img/ajax-loader.gif' border='0' />");
				
				jQuery.ajax({
					url:SiteUrl+'/registers/forget_password',
					type:'POST',
					data:'email='+email,
					dataType:'json',
					success:function(data){			
						jQuery("#flash_div").html('<div class="'+data.message_type+'">'+data.message+'</div>');
							
						/* unset this->data */
						if(data.message_type == 'flash_good' ){
							jQuery("#forgetPassForm #ForgetEmail").val('');	
							jQuery("#UserEmail_error").html('');
						}else{
							jQuery("#UserEmail_error").html(data.message);
						}
					
					}
				});
			}
			
		});
	});
</script>
