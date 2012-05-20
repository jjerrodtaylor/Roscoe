		<div class="adminrightinner">
			<?php e($form->create('User', array('url' => array('controller' => 'registers', 'action' => 'changepassword'))));?>     
			<div class="tablewapper2 AdminForm">	
				<table border="0" class="Admin2Table" width="100%">		
					<tr>
						<td colspan="2"><?php e($form->input('id'));?></td>		
					</tr>
					<tr>
						<td valign="middle" class="Padleft26">New Password<span class="input_required">*</span></td>
						<td><?php e($form->input('User.password2', array('type'=>'password', 'div'=>false, 'label'=>false, "class" => "Testbox5")));?></td>
					</tr>
					<tr>
						<td valign="middle" class="Padleft26">Confirm Password<span class="input_required">*</span></td>
						<td><?php e($form->input('User.confirm_password', array('type'=>'password', 'div'=>false, 'label'=>false, "class" => "Testbox5")));?></td>
					</tr>
				</table>
			</div>
			<div class="buttonwapper">
				<div><input type="submit" value="Submit" class="submit_button" /></div>
				<div class="cancel_button"><?php echo $html->link("Cancel", "/admin/registers/index/", array("title"=>"", "escape"=>false)); ?></div>
			</div>
			<?php e($form->end()); ?>	
		</div>