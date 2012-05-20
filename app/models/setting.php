<?php
class Setting extends AppModel{
	var $name	= 'Setting' ;
	
	var $actsAs = array(
        'Multivalidatable',
		);
		
	function getSetting(){
	  $data = $this->find('list', array('fields'=>array('name', 'value')));
	  if(!empty($data)){
	    foreach($data as $key => $value)
			{
				Configure::write($key, $value);	
			}
	  }
	  
	}
	
	
	var $validationSets = array(
        // Start Of Admin Validation Set
				'setting' => array(
						'value'=>array(
							'notEmpty'=>array(
							'rule'=>'notEmpty',
							'message' => 'Value is required.'
							)
						)				
				)
			);
}
?>