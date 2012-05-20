<?php
  $layout->sessionFlash();
?>
<div class=""> </div>
	<div class=""></div>
	<div class="ShareForm">
	<?php 
	$username_auth=$this->Session->read('Auth.User.email');
	//echo $username_auth;
	e($form->create('User', array('url' => array('controller' => 'users', 'action' => 'changepassword'))));?> 
	<table width="100%" border="0"  >
			<tr><td colspan="2"></td></tr>
			<tr>
				<td align="right">Current Password *</td>
				<td align="left">
					<?php e($form->input('User.old_passowrd', array('type'=>'password', 'div'=>false, 'label'=>false,'class'=>'InputClass')));?>
				</td>
				
			</tr>
			<tr>	
				<td align="right">New Password</td>
				<td  align="left">
		<?php e($form->input('User.new_password', array('type'=>'password', 'div'=>false, 'label'=>false,'class'=>'InputClass' )));?>
		</td>
		
			</tr>
				<tr>
				<td align="right">Email *</td>
				<td  align="left">
					<?php e($form->input('User.email', array('div'=>false, 'label'=>false, 'value'=>$username_auth,'class'=>'InputClass')));?>
				</td>
			</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td colspan="2">
		<p align="center">
		<?php #e($form->hidden('User.role_id',array('div'=>false,'label'=>false,'value'=>2))); ?>
		<?php #e($form->hidden('User.status',array('div'=>false,'label'=>false,'value'=>1))); ?>
		<?php e($form->button("update" ,array('div'=>false, 'label'=>false,'class'=>'BlueBtn'))); ?>
		</p>
			</td>
		</tr>
	</table>
	<?php e($form->end());?>
	</div>
</div>
	
	

    