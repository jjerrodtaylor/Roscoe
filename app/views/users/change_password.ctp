<div class="MddleConts">
	<div class="Nreltop"><h2>
		<?php if($session->check('Auth.User.username')){
						echo "Hello ".ucfirst($session->read('Auth.User.username'));
		} ?>
		</h2>
		<div Style="float:right"><h2>Change Password </h2></div>
	</div>
	<div class="Nrelmid">
		<div class="">
				<?php  //	$layout->sessionFlash(); ?>
			<div id="FormBlocku " >
				<?php 
					e($form->create(null, array('url' => array('controller' => 'users', 'action' => 'change_password'))));
				?>
				<table align="left"width="100%" cellpadding="0" cellspacing="0" class="formTable" >
					<tr>
						<td >
								<span class="label">Password<span class="addvalidation">*</span></span>
						</td>
						<td>
								<?php e($form->input('User.password2', array('label'=>false, 'type'=>'password', 'div'=>false)));?>
						</td>
					</tr>
					<tr>
						<td >
								<span class="label">Confirm Password<span class="addvalidation">*</span></span>
						</td>
						<td>
							<?php e($form->input('User.confirm_password', array('label'=>false,'type'=>'password',  'div'=>false)));?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;
						</td>
						<td id="updateState">
						 	<?php e($form->button('<span>update</span>', array('type'=>'submit', 'escape'=>false,'class'=>'OrngBtn')));?>	
						</td>
					</tr>
				</table>
				<?php e($form->end());?>
			</div>
		</div>
	</div>
</div>
</div>
<div class="Clear"></div>
