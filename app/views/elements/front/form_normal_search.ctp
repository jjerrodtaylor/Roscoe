	<?php
	if($session->read('Search.keyword') && $this->params['action']=='search'){
		$keyword = $session->read('Search.keyword');
	}else{
		$keyword = 'Please Enter your keyword here';
	}
	?>
	<?php e($form->create('RoomFlat',array('url'=>array('controller'=>'room_flats','action'=>'search','#middle'),'id'=>'normalSearchForm'))); ?>
	<h1>
		<span>Rent a Room</span> & <br/>
		<label>Find A Roommate</label>
	</h1>
	<div class="MidSrh">
		<?php e($form->input('keyword',array('label'=>false,'value'=>$keyword,'onblur'=>"this.value==''?this.value=this.defaultValue:null;",'onfocus'=>"this.value==this.defaultValue?this.value='':null;"))); ?>	
		<span style="color:red;" class='login_message'></span>
	</div>
	<p class="AdSrh">
		<?php e($html->link('advanced search','javascript:void(0);',array('id'=>'advance_search_link','div'=>false,'label'=>false))); ?>	
	</p>
	<p class="MidSrchBtnP">
		<?php e($form->button('Start your Search',array('type'=>'button','class'=>'MidSrhBtn','id'=>'normal_search_submit')));?>	
	</p>
	<?php e($form->end()); ?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#normal_search_submit").click(function(){				
				if("<?php e($session->read('Auth.User.id')); ?>"){					
					jQuery(".login_message").html('');
					jQuery("#normalSearchForm").submit();
				}else{				
					jQuery(".login_message").html('Please first login and continue searching.');
				}
			});
			jQuery("#advance_search_link").click(function(){
				if("<?php e($session->read('Auth.User.id')); ?>"){
					jQuery(".login_message").html('');
					window.location.href = SITE_URL+'/room_flats/add_search/#middle';
				}else{
					jQuery(".login_message").html('Please first login and continue searching.');
				}			
			
			});
		})
	</script>
