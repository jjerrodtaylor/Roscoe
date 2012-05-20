<?php
class RoomFlat extends AppModel 
{
    var $name = 'RoomFlat';
	
	
	
	var $belongsTo = array(
		"RoomFlatType" => array(
			'className'=> 'RoomFlatType',
			'foreignKey' => 'room_flat_type_id'
		),
		"Country" => array(
			'className'=> 'Country',
			'foreignKey' => 'country_id'
		),
		"State" => array(
			'className'=> 'State',
			'foreignKey' => 'state_id'
		),
		"User"=>array(
			'className'=>'User',
			'foreignKey'=>'user_id'
		
		)
	);	

	var $hasMany = array(
			'RoomFlatImage'=>array(
				'className'=>'RoomFlatImage',
				'foreignKey'=>'room_flat_id'
			)
		);

	var $hasAndBelongsToMany = array(
			'Amenity' =>
				array(
					 'className'              => 'Amenity',
					 'joinTable'              => 'amenities_room_flats',
					 'foreignKey'             => 'room_flat_id',
					 'associationForeignKey'  => 'amenity_id',
					 
					 
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
			'country_id' => array(
						'notEmpty'=> array(
						'rule' => 'notEmpty',  
						'message' => 'This is required.'
						)	
			),
			'state_id' => array(
						'notEmpty'=> array(
						'rule' => 'notEmpty',  
						'message' => 'This is required.'
						)	
			),
			'street_address' => array(
						'notEmpty'=> array(
						'rule' => 'notEmpty',  
						'message' => 'This is required.'
						)	
			),
			'city_name' => array(
						'notEmpty'=> array(
						'rule' => 'notEmpty',  
						'message' => 'This is required.'
						)	
			),
			'total_room' => array(
						'notEmpty'=> array(
						'rule' => 'notEmpty',  
						'message' => 'This is required.'
						)	
			),
			'total_bathroom' => array(
						'notEmpty'=> array(
							'rule' => 'notEmpty',  
							'message' => 'This is required.'
						)	
			),
			'price' => array(
				
					'notEmpty'=> array(
						'rule' => 'notEmpty',  
						'message' => 'This is required.',
						'last'=>true,
					)
				
			)			
		),
		'advanced_search'=>array(
			'room_type'=>array(
				'notEmpty'=>array(
					'rule'=>'notEmpty',
					'message'=>'This is required'
				)
			),
			'total_room'=>array(
				'notEmpty'=>array(
					'rule'=>'notEmpty',
					'message'=>'This is required'
				)
			),
			'minrent'=>array(
				'numeric'=>array(
					'rule'=>'numeric',
					'message'=>'Numeric value is required'				
				)			
			),
			'maxrent'=>array(
				'numeric'=>array(
					'rule'=>'numeric',
					'message'=>'Numberic value is required'				
				)			
			)
		)
	);	
    
}
?>