<?php
class Amenity extends AppModel {

	var $name = 'Amenity';
  	 /**
     * Behaviors used by the Model
     *
     * @var array
     * @access public
     */
	 
	var $hasAndBelongsToMany = array(
			'RoomFlat' =>
				array(
					 'className'              => 'RoomFlat',
					 'joinTable'              => 'amenities_room_flats',
					 'foreignKey'             => 'amenity_id',
					 'associationForeignKey'  => 'room_flat_id',
					 
					 
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
						'message'=>'This already exists.'
						)   
	        ),
		)
	);
}
?>