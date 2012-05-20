<?php
class Language extends AppModel 
{
	var $name = 'Language';
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
				'lang' => array(
                    'name' => array(
                  	    'alphaNumeric'=>array(
								'rule'=>'alphaNumeric',
	                            'message'=>'language name must only contain letters and numbers. ' 
							),
							
		                'between'=>array(
		                        'rule'=> array('between', 4, 20),
		                        'message'=>'language name must be between 4 and 20 characters long'  
		                
		                ),
		                'isUnique' => array(
		                    'rule' => 'isUnique',
		                    'message' => 'The language name has already been taken.'
		                ),
		              'notEmpty' =>
		                array(
		                    'rule' => 'notEmpty',						
		                    'message' => 'language name is required'
		                ),  
					),
					'code' => array(
						'alphaNumaric'=> array(
						'rule' => 'notEmpty',  
						'message' => 'Please language Code Name.'
						)	
					),
			)
    		
	);
 	
	
  
 

	
   
    
}
?>