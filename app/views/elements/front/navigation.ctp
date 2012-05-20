	<?php
	$slug = '';
	if(isset($page_detail['StaticPage']['slug'])){
		$slug = $page_detail['StaticPage']['slug'];
	}elseif($this->params['controller'] == 'static_pages' && $this->params['action']=='contact_us'){
		$slug = 'contact_us';
	}elseif($this->params['controller'] == 'static_pages' && $this->params['action']=='tell_a_friend'){
		$slug = 'tell_a_friend';
	}
	$home = '';
	$about_us = '';
	$help = '';
	$contact_us = '';
	$tell_a_friend = '';
	switch($slug){
		case 'about-us':
			$about_us = 'Select';
			break;
		case 'help':
			$help = 'Select';
			break;
		case 'contact_us':
			$contact_us = 'Select';
			break;
		case 'tell_a_friend':
			$tell_a_friend = 'Select';
			break;			
		default:
			$home = 'Select';
	}
	?>
	
	<div class="Navigation">
		<ul class="MainNav">
			<li>
				<?php e($html->link('Home','/',array('class'=>$home,'div'=>false,'label'=>false))); ?>
			</li>
			<li>
			<?php e($html->link('About Us','/pages/about-us/#middle',array('class'=>$about_us,'div'=>false,'label'=>false))); ?>
			</li>
			<li>
			<?php e($html->link('Tell a friend',array('controller'=>'static_pages','action'=>'tell_a_friend','#middle'),array('class'=>$tell_a_friend,'div'=>false,'label'=>false))); ?>
			</li>
			<li>
			<?php e($html->link('Help','/pages/help/#middle',array('class'=>$help,'div'=>false,'label'=>false))); ?>
			</li>
			<li class="Last">
			<?php e($html->link('Contact Us','/contact_us/#middle',array('class'=>$contact_us,'div'=>false,'label'=>false))); ?>
			</li>
		</ul>
	</div>