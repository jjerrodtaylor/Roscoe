<?php
class QuestionOption extends AppModel{
	
   var $name = "QuestionOption";
  	 /**
     * Behaviors used by the Model
     *
     * @var array
     * @access public
     */
    var $actsAs = array(        
        'Multivalidatable'
    );
	var $hasAndBelongsToMany = array(
			'User' =>
				array(
					 'className'              => 'User',
					 'joinTable'              => 'question_options_users',
					 'foreignKey'             => 'question_option_id',
					 'associationForeignKey'  => 'user_id',
					 
					 
				)
		);
					
 	var $hasMany = array( 
						'Child' => array(
							'className' => 'QuestionOption',
							'foreignKey' => 'parent_id',
							'dependent' => true,
							'conditions' => '',
							'fields' => '',
							'order' => '',
							'limit' => '',
							'offset' => '',
							'exclusive' => true,
							'finderQuery' => '',
							'counterQuery' => ''
						),

					);  					
	/**
     * Custom validation rulesets
     */	
	var $validationSets = array(
	   'admin'=>array(
	      'question_option_name'=>array(		              	
			 'notEmpty'=>array(
						'rule'=>'notEmpty',
						'message'=>'This  is required'		  
						)
  
	        ),
		)
	);
		
	
}
?>