<div id="quick">
	<?php		
		if( $session->check('Auth.Admin.username') != null) { 
			echo __("You are logged in as ", true) . $session->read('Auth.Admin.username'); 
			echo " | " . $html->link(__("Log Out", true), array('plugin' => 0, 'controller' => 'admins', 'action' => 'logout'));
		}
	?>
</div>