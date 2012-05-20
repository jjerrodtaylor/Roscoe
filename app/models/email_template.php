<?php
/**
 * Specialty
 *
 * PHP version 5
 *
 * @category Model 
 * 
 */
class EmailTemplate extends AppModel{
	/**
	 * Model name
	 *
	 * @var string
	 * @access public
	 */
	var $name = 'EmailTemplate';
	
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
		'admin'	=>	array(			
			'name'=>array(
				'isUnique'	=>	array(
					'rule'	=>	'isUnique',
					'message'	=>	'Title is already exists.'
				),
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Title is required'
				)
			),
			'subject'=>array(			
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Subject is required'
				)
			),		
			'description'=>array(				
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Description is required'
				)
			)	
		)	
	);	
	
	function getTemplate($slug = null){
		if(!empty($slug)){
			$data = $this->find('first', array('conditions'=>array('EmailTemplate.slug'=>$slug)));
			return $data;
		}
	}
	
}
?>