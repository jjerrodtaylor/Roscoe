<?php
class UserImage extends AppModel {
    var $name = 'UserImage';

	var $actsAs = array('Multivalidatable');
	var $belongsTo = array(
		"User" => array(
			'className'=> 'User',
			'foreignKey' => 'user_id'
		)
	);
	var $validationSets = array(
			'admin'=>array(
				'image_name'=>array(
					'rule'=>'notEmpty',
					'message'=>'This is required.'
				)
			)
		);
		/* =================delete images========================= */
	function deleteImages($filesArr = null){
	
		if(!empty($filesArr)){
		
			$folders = array('uploaded','uploaded_thumb');
			foreach($filesArr as $key=>$image){
				$file_name = $image['image_name'];
				$hash = $image['hash'];
				foreach($folders as $index=>$folder){					
				   $path = WWW_ROOT.'img'.DS.IMAGE_USER_FOLDER_NAME.DS.$hash.DS.$folder.DS. $file_name;
					if(file_exists($path)) {
						unlink($path);
					}
				}
				
			}
		}		
		
		
	}
	/* =========================set user id in Userimage array============================= */
	function setUserId($data = null,$user_id=null){
		if(count($data)>0 && $user_id){
			foreach($data as $key=>$value){
				$data[$key]['user_id'] = $user_id ;
			}
			
			//$dataArr['UserImage'] = array('user_id'=>21,'hash'=>'132214334','image_name'=>'image name');	
			return $data;
		}else{
			return false;
		}
	}
	
	function readImagesAdded($folderName = null){
		$files = array();
		if(!empty($folderName)){								
								
			$path = WWW_ROOT.'fileupload_server/php'.DS.$folderName.DS.'files/';
			$dh = opendir($path);
			$i = 0;
			
			while(($file = readdir($dh)) !== false) {
				if($file !='.' && $file !='..' && $file !='Thumbs.db'){
					$files[$i]['image_name'] = $file;					
				}
				$i++;
			}
			
		}
		return $files;
	}


}
?>