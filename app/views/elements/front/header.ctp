<div class="HeaderConts">
	<div class="HdrTop">
		<div class="Logo"><?php e($html->link($html->image('images/logo.png',array('alt'=>'logo')),array('controller'=>'fronts','action'=>'index'),array('escape'=>false)));?></div>
		<div class="HdrRht">
			<?php
			if($this->Session->read('Auth.User')){
				e($this->element('front/welcome'));			
			}else{			
				e($this->element('front/signin'));
			}
			?>
		</div>
	</div>
	<?php e($this->element('front/navigation')); ?>
	<div class="Clear"></div>
</div>
