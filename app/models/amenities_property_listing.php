<?php
class AmenitiesPropertyListing extends AppModel{

   var $name = "AmenitiesPropertyListing";
   var $belongsTo = array('PropertyListing','Amenity');
  	 

}
?>