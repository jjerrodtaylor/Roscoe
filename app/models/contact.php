<?php
/**
 * Contact
 *
 * PHP version 5
 *
 * @contact Model 
 * 
 */
class Contact extends AppModel{
	/**
	 * Model name
	 *
	 * @var string
	 * @access public
	 */
	var $name = 'User';
	//var $useTable = false;
	/**
	 * Behaviors used by the Model
	 *
	 * @var array
	 * @access public
	 */
    var $actsAs = array(        
        'Multivalidatable'
    );
	var $hasOne=array(
			'ContactReference'=>array(
				'className'=>'UserReference',
				'foriegnKey'=>'user_id',
				'dependent'=>true
			),
		);	
	/**
     * Custom validation rulesets
     */	
	var $validationSets = array(
		'front'	=>	array(
			'email' =>array(
				'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message' => 'Email is required'
					),
					'email'=>array(
						'rule' => 'email',
						'message' => 'Email is Invalid'
					)					
				),
				'name'=>array(
					'rule'=>'notEmpty',
					'message'=>'Name is required.'
				),
				'subject'=>array(
					'rule'=>'notEmpty',
					'message'=>'Subject is required.'
				),
				'message'=>array(
					'rule'=>'notEmpty',
					'message'=>'Message is required.'
				)				
			)
		);
}
?>