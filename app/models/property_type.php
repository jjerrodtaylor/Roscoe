<?php
class PropertyType extends AppModel {

	var $name = 'PropertyType';
	
	var $hasMany = array(
		'PropertyListing' => array(
			'className' => 'PropertyListing',
			'foreignKey' => 'property_type_id',
		)
	);
	
	 var $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Name is Required.'
			),
			'isUnique'=>array(
				'rule'=>'isUnique',
				''=>'This is already used.'
			)
		),
	);
}
?>