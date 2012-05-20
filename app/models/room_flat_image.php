<?php
class RoomFlatImage extends AppModel {
    var $name = 'RoomFlatImage';

	var $actsAs = array('Multivalidatable');
	var $belongsTo = array(
		"RoomFlat" => array(
			'className'=> 'RoomFlat',
			'foreignKey' => 'room_flat_id'
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
		
			$folders = array('uploaded','uploaded_thumb','uploaded_large');
			foreach($filesArr as $key=>$image){
				$file_name = $image['image_name'];
				$hash = $image['hash'];
				foreach($folders as $index=>$folder){					
				   $path = WWW_ROOT.'img'.DS.IMAGE_ROOM_FLAT_FOLDER_NAME.DS.$hash.DS.$folder.DS. $file_name;
					if(file_exists($path)) {
						unlink($path);
					}
				}
				
			}
		}		
		
		
	}
	/* =========================set user id in Userimage array============================= */
	function setRoomFlatId($data = null,$room_flat_id=null){
		if(count($data)>0 && $room_flat_id){
			foreach($data as $key=>$value){
				$data[$key]['room_flat_id'] = $room_flat_id ;
			}
			return $data;
		}else{
			return false;
		}
	}	



}
?>