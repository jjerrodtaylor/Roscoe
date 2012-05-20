<?php
switch($this->params['action']){
	case 'my_account':
		e('My Profile');
		break;
	case 'edit':
		if($this->params['controller'] == 'registers'){
			e('Edit Profile Detail');
		}else{
			e('Edit Room/Flat');
		}		
		break;
	case 'index':
		e('List Room/Flat');
		break;	
	case 'add':
		e('Add Room/Flat');
		break;
	case 'more_detail':
		e('More Detail');
		break;
	case 'search':
		e('Search Result');
		break;	
	case 'add_search':
		e('Advance Search');
		break;
	case 'advance_search_result':
		e('Advance Search Result');
		break;
	case 'change_password':
		e('Change Password');
		break;		
	default :
		e('My Profile');
		break;		
}
?>