<div class="HdrRhtBtm">	
	<p class="Rembr">
		<label>Welcome&nbsp;&nbsp;<?php e($this->Session->read('Auth.User.email')); ?></label>
	</p>
	<p class="FPass">
		<?php e($html->link('Logout',array('controller'=>'registers','action'=>'logout'),array('div'=>false,'label'=>false))); ?>
	</p>
	<?php if($this->params['action'] !='my_account'){?>					
		<p class="NUsr">
		<?php e($html->link('My Profile',array('controller'=>'registers','action'=>'my_account','#middle'),array('div'=>false,'label'=>false))); ?>
		</p>
	<?php } ?>
</div>	