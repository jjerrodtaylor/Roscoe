<?php
class StaticPage extends AppModel{
	
   var $name = "StaticPage";
  	 /**
     * Behaviors used by the Model
     *
     * @var array
     * @access public
     */
    var $actsAs = array(        
        'Multivalidatable'
    );
	/**
     * Custom validation rulesets
     */	
	var $validationSets = array(
	   'admin'=>array(
	      'title'=>array(		              	
			 'notEmpty'=>array(
						'rule'=>'notEmpty',
						'message'=>'Title is required'		  
						),
			 'isUnique'=>array(
						'rule'=>'isUnique',
						'message'=>'Title is already exists.'
						)   
	        ),
		   'slug'=>array(
				'notEmpty'=>array(
							'rule'=>'notEmpty',
							'message'=>'Slug is required'		
							),
				 'isUnique'=>array(
							  'rule'=>'isUnique',
							  'message'=>'Slug is already exists'
				 )					
		   ),
		  'description'=>array(
				'notEmpty'=>array(
							'rule'=>'notEmpty',
							'message'=>'Description is required'		
							)		 				
		   )      		   
			
		 )
	
	);
}
?>