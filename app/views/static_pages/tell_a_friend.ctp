<A NAME="middle"></A>

<div class="MidBtm">
	<div class="MidTopBg">
		<?php $layout->sessionFlash(); ?>
		<h2 class="InnerHd">Tell A Friend</h2>
		<div class="InnerMidCnt">			
			<?php e($form->create('TellFriend', array('url' => array('controller' => 'static_pages', 'action' => 'tell_a_friend','#middle')))); ?>
			<ul class="MyAccCnts">
				<li>
					<label class="MyAccLbl">Name<span class="addvalidation">*</span></label>
					<span class="MyAccTxtVal">
						<?php 
						e($form->input('name',array('style'=>'width:540px','div'=>false,'label'=>false,'class'=>'MyAccTxtbx','size'=>52)));
						?>
					</span>
				</li>
				<li>
					<label class="MyAccLbl">From<span class="addvalidation">*</span></label>
					<span class="MyAccTxtVal">
						<?php 
						e($form->input('from',array( 'style'=>'width:540px','div'=>false,'label'=>false,'class'=>'MyAccTxtbx','size'=>52)));
						?>
					</span>
				</li>
				<li>
					<label class="MyAccLbl">To<span class="addvalidation">*</span></label>
					<span class="MyAccTxtVal">
						<?php 
						e($form->input('to',array( 'style'=>'width:540px','div'=>false,'label'=>false,'class'=>'MyAccTxtbx','size'=>52)));
						?>
					</span>
				</li>
				<li>
					<label class="MyAccLbl">CC</label>
					<span class="MyAccTxtVal">
						<?php 
						e($form->input('cc',array( 'style'=>'width:540px','div'=>false,'label'=>false,'class'=>'MyAccTxtbx','size'=>52)));
						?>
					</span>
				</li>
				<li>
					<label class="MyAccLbl">BCC</label>
					<span class="MyAccTxtVal">
						<?php 
						e($form->input('bcc',array( 'style'=>'width:540px','div'=>false,'label'=>false,'class'=>'MyAccTxtbx','size'=>52)));
						?>
					</span>
				</li>				
				<li>
					<label class="MyAccLbl">Subject<span class="addvalidation">*</span></label>
					<span class="MyAccTxtVal">
						<?php 
						e($form->input('subject',array('style'=>'width:540px','type'=>'text','div'=>false,'label'=>false,'class'=>'MyAccTxtbx','size'=>52)));
						?>
					</span>
				</li>

				 <li>
					<label class="MyAccLbl">Message<span class="addvalidation">*</span></label>
					<span class="MyAccTxtVal">
						<?php 
						e($form->input('message',array( 'style'=>'width:540px','type'=>'','div'=>false,'label'=>false,'class'=>'MyAccTxtArea','cols'=>60,'rows'=>10)));
						?>
					</span>
				</li>
				<li>
					<label class="MyAccLbl">&nbsp;</label>
					<span class="MyAccTxtVal">
						<?php 
						e($form->button('<span>Submit </span>', array('type'=>'submit', 'escape'=>false,'class'=>'MyAccSubmit')));
						?>
					</span>
				</li>				
			</ul>
			<?php e($form->end());?>
		</div>
	</div>
	<div class="MidBtmBg"></div>
</div>	

