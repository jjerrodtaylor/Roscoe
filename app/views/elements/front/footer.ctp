<div class="FooterCnts">
	<div class="FtrLinks">
		<?php e($html->link('Home','/',array('div'=>false,'label'=>false))); ?>
		|
		<?php e($html->link('About Us','/pages/about-us/#middle',array('div'=>false,'label'=>false))); ?>
		| 
		<?php e($html->link('Tell a friend',array('controller'=>'static_pages','action'=>'tell_a_friend','#middle'),array('div'=>false,'label'=>false))); ?>
		|
		<?php e($html->link('Help','/pages/help/#middle',array('div'=>false,'label'=>false))); ?>
		|  
		<?php e($html->link('Contact Us','/contact_us/#middle',array('div'=>false,'label'=>false))); ?> 
		|
		<?php e($html->link('Privacy Policy','/pages/privacy-policy/#middle',array('div'=>false,'label'=>false))); ?>
		| 
		<?php e($html->link('Terms and Conditions','/pages/terms-and-conditions/#middle',array('div'=>false,'label'=>false))); ?>
	</div>
	<div class="FtrCpyRht">Copyright &copy; 2012 <?php e($html->link('www.iwantaroommate.com',array('controller'=>'fronts','action'=>'index'),array('class'=>'CopyFtrCpyRht'))); ?> All rights reserved</div>
	<div class="Clear"></div>
</div>