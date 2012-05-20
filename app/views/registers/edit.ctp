	<?php e($javascript->link(array('fancybox/jquery.fancybox-1.3.4.pack','fancybox/jquery.mousewheel-3.0.4.pack'),false)); ?>
	<?php e($html->css(array('jquery.fancybox-1.3.4'),false)); ?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.addAttribute').fancybox();
	});		
	</script>	
	<A NAME="middle"></A>
	<div class="InnerMidCntR">
		<?php e($form->create('User', array('url' => array('controller' => 'registers', 'action' => 'edit'))));?>     
		<?php e($form->hidden('User.id')); ?>
		<?php e($form->hidden('UserReference.terms_condtions')); ?>
		<?php e($form->hidden('UserReference.id')); ?>
		<?php $layout->sessionFlash();?>
		<h2 class="InnerMidCntRHd">Edit Profile Detail</h2>
		<ul class="MyAccCnts">
			<li>
				<label class="MyAccLbl">Email <span class="addvalidation">*</span></label>
				<span class="MyAccTxtVal"><?php e($form->input('User.email',array('div'=>false,'label'=>false,'class'=>'MyAccTxtbx')));?></span>
			</li>
			<li>
				<label class="MyAccLbl">Fast Name<span class="addvalidation">*</span></label>
				<span class="MyAccTxtVal"><?php e($form->input('UserReference.first_name',array('div'=>false,'label'=>false,'class'=>'MyAccTxtbx')));?></span>
			</li>
			 <li>
				<label class="MyAccLbl">Last Name:</label>
				<span class="MyAccTxtVal"><?php e($form->input('UserReference.last_name',array('div'=>false,'label'=>false,'class'=>'MyAccTxtbx')));?></span>
			</li>
			 <li>
				<label class="MyAccLbl">Street Address<span class="addvalidation">*</span></label>
				<span class="MyAccTxtVal"><?php e($form->input('UserReference.street_address',array('div'=>false,'label'=>false,'class'=>'MyAccTxtbx')));?></span>
			</li>			
			<li>
				<label class="MyAccLbl">Country<span class="addvalidation">*</span></label>
				<span class="MyAccTxtVal">
					<?php e($form->input('UserReference.country_id',array('div'=>false,'label'=>false,'class'=>'MyAccDrpDwn','empty'=>'Please select country')));?>
				</span>
			</li>
			<li id="stateOptions">
				<?php e($this->element('registreduser/state')); ?>	
			</li>
			<li>
				<label class="MyAccLbl">City<span class="addvalidation">*</span></label>
				<span class="MyAccTxtVal"><?php e($form->input('UserReference.city_name',array('div'=>false,'label'=>false,'class'=>'MyAccTxtbx')));?></span>
			</li>
			<li>
				<label class="MyAccLbl">ZIP / Postal code:</label>
				<span class="MyAccTxtVal"><?php e($form->input('UserReference.zipcode',array('div'=>false,'label'=>false,'class'=>'MyAccTxtbx')));?></span>
			</li>
			<li>
				<label class="MyAccLbl">Accessbility:</label>
				<span class="MyAccTxtVal"><?php e($form->input('User.access_permission',array('options'=>array('1'=>'Public','0'=>'Private'),'div'=>false,'label'=>false,'class'=>'MyAccDrpDwn')));?></span>
			</li>			
		</ul>
		<?php 
		if(count($this->data['UserImage'])>0){?>
			<h2 class="InnerMidCntRIMHd">Uploaded Images : </h2>
			<ul class="MyImages">
				<li>
					<table>
						<tr>				
							<?php e($this->element('registreduser/view_image',array('UserImageArr'=>$this->data['UserImage']))); ?>
						</tr>
					</table>			
				</li>
			</ul>
			<?php 
		}?>
		<ul class="MyAccCnts">	
			<li>
				<label  class="MyA"><?php e($html->link('Add image',array('controller'=>'registers','action'=>'addimage',$this->data['User']['id']),array('title'=>'Add Images','class'=>'addAttribute'))); ?></label>
				<span class="MyA"><?php e($html->link('Update Question\'s Answer',array('controller'=>'registers','action'=>'question_answer',$this->data['User']['id']),array('class'=>'addAttribute','title'=>'Update Question\s Answer'))); ?></span>
			</li>
			<li>
				<label class="MyAccLbl"><?php e($form->button('<span>Submit </span>', array('type'=>'submit', 'escape'=>false,'class'=>'MyAccSubmit')));?></label>
				<span class="MyAccTxtVal">&nbsp;</span>
			</li>
		</ul>		
		<?php e($form->end()); ?>
	</div>
		
