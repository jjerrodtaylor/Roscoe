<?php e($form->input($model.'.state_id', array('div'=>false, 'label'=>false, "class" => "Testbox5", 'empty'=>'Select State')));
 e($ajax->observeField($model.'StateId', array('update'=>'updateCity', 'indicator'=>'ajax_state_indicator',
									    'url'=>array('controller' =>'cities', 'action'=>'getCityList', 'model'=>$model))
									));	
  e('<span id="ajax_state_indicator" style="display:none;">'.$html->image('/img/admin/ajax-loader.gif', array('height'=>'14')).'</span>');										
?>