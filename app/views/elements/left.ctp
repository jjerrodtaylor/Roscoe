<?php
$my_account ='';
$edit_my_account ='';
$add_room_flat = '';
$list_room_flat = '';
$change_password = '';
if(!isset($prevAction)){
	$prevAction = 'index';
}
if($this->params['action']=='my_account'){
	$my_account = 'Select';
}elseif($this->params['controller']=='registers' && $this->params['action']=='edit'){
	$edit_my_account ='Select';
}elseif($this->params['controller']=='room_flats' && $this->params['action']=='add'){
	$add_room_flat ='Select';
}elseif($this->params['controller']=='room_flats' && ($this->params['action']=='index' || ($this->params['action']=='more_detail' && $prevAction !='search' && $prevAction !='advance_search_result') || $this->params['action']=='edit')){
	$list_room_flat ='Select';
}elseif($this->params['controller']=='registers' && $this->params['action']=='change_password'){
	$change_password ='Select';
}

?>
<div class="InnerMidCntL">
	<ul class="MyAccItms">
		<li><?php e($html->link('My Profile',array('controller'=>'registers','action'=>'my_account','#middle'),array('class'=>$my_account))); ?></li>
		<li><?php e($html->link('Change Password',array('controller'=>'registers','action'=>'change_password','#middle'),array('class'=>$change_password))); ?></li>
		<li><?php e($html->link('Edit Profile Detail',array('controller'=>'registers','action'=>'edit','#middle'),array('class'=>$edit_my_account))); ?></li>
		<li><?php e($html->link('List Room/Flat',array('controller'=>'room_flats','action'=>'index','#middle'),array('class'=>$list_room_flat))); ?></li>
		<li><?php e($html->link('Add Room/Flat',array('controller'=>'room_flats','action'=>'add','#middle'),array('class'=>$add_room_flat))); ?></li>
	</ul>
	<?php
	if($this->params['action']=='more_detail' && isset($data['RoomFlat']['id'])){	
		?>
		<iframe src="<?php e(Router::url(array('controller'=>'room_flats','action'=>'view_room_flat_areas',$data['RoomFlat']['id']))); ?>" style="width: 242px; height: 357px; position: relative;margin-top:10px;" frameborder="0" border="0" cellspacing="0" marginheight="0" marginwidth="0"></iframe>		
		<?php
	}?>
</div>