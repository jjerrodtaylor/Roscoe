<?php
class UserReference extends AppModel {

	
	var $name = 'UserReference';	
	/**
     * Behaviors used by the Model
     *
     * @var array
     * @access public
  */
	var $actsAs = array('Multivalidatable');
	var $belongsTo=array('User');
	var $validationSets = array(	
		'admin'=>array(
			'first_name' => array(
				'alphaNumaric'=> array(
					'rule' => 'notEmpty',  
	        		'message' => 'First name is required.'
				)	
			),
			'country_id' => array(
						'notEmpty'=> array(
						'rule' => 'notEmpty',  
						'message' => 'Please select country name .'
						)	
			),
			'state_id' => array(
						'notEmpty'=> array(
						'rule' => 'notEmpty',  
						'message' => 'Please select state name .'
						)	
			),
			'street_address' => array(
						'notEmpty'=> array(
						'rule' => 'notEmpty',  
						'message' => 'Street address is required.'
						)	
			),
			'city_name' => array(
						'notEmpty'=> array(
						'rule' => 'notEmpty',  
						'message' => 'City name is required.'
						)	
			)
		),
		'front'=>array(
			'terms_condtions'=>array(
               'rule' => array('comparison', '!=', 0),
               'required' => true,
               'message' => 'You must agree to the terms of use',              
			),
			'first_name'=>array(
               'rule' => 'notEmpty',              
               'message' => 'First name is riquired.',              
			),			
			'country_id' => array(
						'notEmpty'=> array(
						'rule' => 'notEmpty',  
						'message' => 'Please select country name .'
						)	
			),
			'state_id' => array(
						'notEmpty'=> array(
						'rule' => 'notEmpty',  
						'message' => 'Please select state name .'
						)	
			),
			'street_address' => array(
						'notEmpty'=> array(
						'rule' => 'notEmpty',  
						'message' => 'Street address is required.'
						)	
			),
			'city_name' => array(
						'notEmpty'=> array(
						'rule' => 'notEmpty',  
						'message' => 'City name is required.'
						)	
			)
		)
		
	);	
}
?>