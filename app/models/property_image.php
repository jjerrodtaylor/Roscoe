<?php
class PropertyImage extends AppModel {
    var $name = 'PropertyImage';

	
	var $belongsTo = array(
		"PropertyListing" => array(
			'className'=> 'PropertyListing',
			'foreignKey' => 'property_id'
		)
	);
	function deleteImages($filesArr = null){
	
		if(!empty($filesArr)){
		
			$folders = array('uploaded','uploaded_thumb','uploaded_small','uploaded_large');
			foreach($filesArr as $key=>$image){
				$file_name = $image['PropertyImage']['image_name'];					
				foreach($folders as $index=>$folder){					
				   $path = WWW_ROOT.'img'.DS.$folder.DS. $file_name;
					if(file_exists($path)) {
						unlink($path);
					}
				}
				
			}
		}		
		
		
	}

}
?>