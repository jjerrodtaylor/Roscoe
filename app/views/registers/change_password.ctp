	<A NAME="middle"></A>
	<div class="InnerMidCntR">
		<?php e($form->create('User', array('url' => array('controller' => 'registers', 'action' => 'change_password','#middle'))));?>     
		<h2 class="InnerMidCntRHd">Change Password</h2>
		<ul class="MyAccCnts">
			<li>
				<label class="MyAccLbl">New Password<span class="addvalidation">*</span></label>
				<span class="MyAccTxtVal"><?php e($form->input('User.password2',array('type'=>'password','div'=>false,'label'=>false,'class'=>'MyPassTxtbx')));?></span>
			</li>
			 <li>
				<label class="MyAccLbl">Confirm Password<span class="addvalidation">*</span></label>
				<span class="MyAccTxtVal"><?php e($form->input('User.confirm_password',array('type'=>'password','div'=>false,'label'=>false,'class'=>'MyPassTxtbx')));?></span>
			</li>
		</ul>
		<ul class="MyAccCnts">	
			<li>
				<label class="MyAccLbl"><?php e($form->button('<span>Submit </span>', array('type'=>'submit', 'escape'=>false,'class'=>'MyAccSubmit')));?></label>
				<span class="MyAccTxtVal">&nbsp;</span>
			</li>
		</ul>		
		<?php e($form->end()); ?>
	</div>