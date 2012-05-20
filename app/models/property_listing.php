<?php
class PropertyListing extends AppModel 
{
    var $name = 'PropertyListing';
	
	
	
	var $belongsTo = array(
		"PropertyType" => array(
			'className'=> 'PropertyType',
			'foreignKey' => 'property_type_id'
		),
		"User" => array(
			'className'=> 'User',
			'foreignKey' => 'property_user_id'
		),
		"State" => array(
			'className'=> 'State',
			'foreignKey' => 'property_state_id'
		)
	);
	
	
	var $hasMany = array(
		"PropertyImage" => array(
			'className'=> 'PropertyImage',
			'foreignKey' => 'property_id'
		)
	);

	var $hasAndBelongsToMany = array(
			'Amenity' =>
				array(
					 'className'              => 'Amenity',
					 'joinTable'              => 'amenities_property_listings',
					 'foreignKey'             => 'property_listing_id',
					 'associationForeignKey'  => 'amenity_id',
					 
					 
				)
		);		
	
	var $validate = array(
		'property_address' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Address is Required.'
			)
		),
		'property_city' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'City is Required.'
			)
		),
		'property_zip' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Zip Code is Required.'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Enter numeric value.',
				'allowEmpty' => true
			)
		),
		/*'total_rooms' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Total Room is Required.'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Enter numeric value.',
				'allowEmpty' => true
			)
		),
		'total_bedroom' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Bedroom is Required.'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Enter numeric value.',
				'allowEmpty' => true
			)
		),
		'total_bathroom' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Bathroom is Required.'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Enter numeric value.',
				'allowEmpty' => true
			)
		),*/
		'price' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Price is Required.'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Enter numeric value.',
				'allowEmpty' => true
			)
		),
		'property_tax' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Tax is Required.'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Enter numeric value.',
				'allowEmpty' => true
			)
		),
		'total_area' => array(
			'total_area_validation' => array(
				'rule' => array("total_area_validation"),
				'message'     => 'Only integer and float values are allowed.'
				)
		),
		'year_built' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Built Year is Required.'
			)
		),
		'parking' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Parking is Required.'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Enter numeric value.',
				'allowEmpty' => true
			)
		),
	);


function total_area_validation($field=array())
{
        //print_r($field["total_area"]);
    /*foreach($field as $key => $value)
    {
        $v1 = $value;
        $v2 = $this->data[$this->name][$compare_field];
        if($v1 !== $v2)
        {
            return false;
        }
        else
        {
            continue;
        }
    }
    return true;*/

    $subject = $field["total_area"];
    $pattern = '/^([0-9]{1,7}\.[0-9]{2}|[0-9]{1,10})$/';
    if(preg_match($pattern, $subject))
    {
        return true;
        //echo "match found";
    }
    else
    {
         return false;
        // echo "match not found";
    }
    //print_r($matches);
    
}
	
}
?>