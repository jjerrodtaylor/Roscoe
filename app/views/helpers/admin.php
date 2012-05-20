<?php
/**
 * Admin Helper
 *
 *
 * @category Helper
 */
class AdminHelper extends AppHelper {

    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
	 var $helpers = array('Html', 'Session');
	 
    
	
	function getActionImage($actions = null,$id = null,$name = null) {
	   
		$controller = '' ;
		$action = '' ;
		if(!empty($actions)) {
			foreach($actions as $imagetype=>$to_action) {
				if(isset($to_action['controller'])) 
					$controller = $to_action['controller'];
				if(isset($to_action['action'])) 
					$action = $to_action['action'];
				if(isset($to_action['token'])) 
					$token = $to_action['token'];	
				
				if($imagetype=='view') {
					//e($this->Html->link($this->Html->image('/img/admin/view.jpg',array('class'=>'viewstatusimg1 thickbox','title'=>'View '.$name,'alt'=>'View','width'=>'18','height'=>'18')),array('controller'=>$controller,'action'=>$action,$id))) ;
				}elseif($imagetype=='changepassword') {
					e($this->Html->link($this->Html->image('/img/admin/change_password.jpg',array('class'=>'viewstatusimg1','title'=>'ChangePassword '.$name,'alt'=>'changepassword','width'=>'18','height'=>'18')),array('controller'=>$controller,'action'=>$action,$id),array('escape'=>false))) ;
				}elseif($imagetype=='edit') {
					e($this->Html->link($this->Html->image('/img/admin/edit_icon.jpg',array('class'=>'viewstatusimg1','title'=>'Edit '.$name,'alt'=>'edit','width'=>'18','height'=>'18')),array('controller'=>$controller,'action'=>$action,$id),array('escape'=>false))) ;
				} elseif($imagetype=='delete') {
					e($this->Html->link($this->Html->image('/img/admin/cross_icon.jpg', array('class'=>'viewstatusimg1','title'=>'Delete '.$name,'alt'=>'delete','width'=>'18','height'=>'18')), array('controller'=>$controller,'action'=>$action,'token'=>$token, $id),array('class'=>'deleteItem', 'escape'=>false)));	
				}elseif($imagetype=='manageimage') {
					//e($this->Html->link($this->Html->image('portlet_admin_icon.gif',array('class'=>'viewstatusimg1','title'=>'Manage '.$name.'Images','alt'=>'edit','width'=>'20','height'=>'16')),array('controller'=>$controller,'action'=>$action,$id ),array('escape'=>'false'))) ;
				} elseif($imagetype=='default_true') {
					e($this->Html->link($this->Html->image('default_true.png',array('class'=>'viewstatusimg1','title'=>'edit','alt'=>'edit','width'=>'20','height'=>'16')),array('controller'=>$controller,'action'=>$action,$id ),array('escape'=>false))) ;
				} elseif($imagetype=='default_false') {
					e($this->Html->link($this->Html->image('default_false.png',array('class'=>'viewstatusimg1','title'=>'edit','alt'=>'edit','width'=>'20','height'=>'16')),array('controller'=>$controller,'action'=>$action,$id ),array('escape'=>false))) ;
				} elseif($imagetype=='active') {
					e($this->Html->link($this->Html->image('active.png',array('class'=>'viewstatusimg1','title'=>'edit','alt'=>'edit','width'=>'20','height'=>'16')),array('controller'=>$controller,'action'=>$action,$id ),array('escape'=>false))) ;
				} elseif($imagetype=='deactive') {
					e($this->Html->link($this->Html->image('deactive.png',array('class'=>'viewstatusimg1','title'=>'edit','alt'=>'edit','width'=>'20','height'=>'16')),array('controller'=>$controller,'action'=>$action,$id ),array('escape'=>false))) ;
				}elseif($imagetype=='options'){
					e($this->Html->link($this->Html->image('/img/admin/change_password.jpg',array('class'=>'viewstatusimg1','title'=>'Options '.$name,'alt'=>'Options','width'=>'18','height'=>'18')),array('controller'=>$controller,'action'=>$action,$id),array('escape'=>false))) ;
				
				}
			}
		}
	}
	
		
	
}	
?>	