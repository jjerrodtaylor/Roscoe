<?php
class RoomFlatType extends AppModel {

	var $name = 'RoomFlatType';
	
 	var $hasOne = array(
		'RoomFlat' => array(
			'className' => 'RoomFlat',
			'foreignKey' => 'room_flat_type_id',
			'dependant' =>true
		)
	); 
	
    var $actsAs = array(        
        'Multivalidatable'
    );	
	/**
     * Custom validation rulesets
     */	
	var $validationSets = array(
	   'admin'=>array(
	      'name'=>array(		              	
			 'notEmpty'=>array(
						'rule'=>'notEmpty',
						'message'=>'This  is required'		  
						),
			 'isUnique'=>array(
						'rule'=>'isUnique',
						'message'=>'This is already exists.'
						)   
	        ),
		)
	);

}
?>