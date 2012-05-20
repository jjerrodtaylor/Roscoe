<?php
/**
 * General Helper
 *
 *
 * @category Helper
 */
class GeneralHelper extends AppHelper {

    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
	   var $helpers = array('Html', 'Session');
	   
	  

				


	function generateTreeList($data = null, $level=0){
		$output 		= '';		
		$delimiter 		= "";
		$delimiters 	= "\n" . str_repeat($delimiter, $level * 2);
		
		foreach($data as $value){	
			$class = ''; 		
			if($value['Category']['parent_id'] == 0) {
			  $class = 'BgTab';
			  if($value['Category']['show_navigation'] == 0) {
				 $class .= ' viewAllCategory';	
			  } 
			
			}	
			$output.= '<li  name="toggle'.$value['Category']['id'].'" class="'.$class.'">'.$this->Html->link($delimiters.$value['Category']['name'],array('controller'=>'fronts','action'=>'product_info',$value['Category']['id']));	
			if(isset($value['children'][0])){
				$output .= '<ul>'.$this->generateTreeList($value['children'], $level+1).'</ul>';	  		
			}
			$output.= '</li>';	
		}	
		return $output;
	  }
 
	/*********************************
	* this function is used in admin for active and deactive link.
	*/
	function changeStatus($options = null){
		App::import('AppHelper', 'View/Helper');
		$html = new HtmlHelper();
		if($options['status'] == 1){
			$status_icon = SITE_URL.'/app/webroot/img/deactive.png';
			$title = 'Active';
		}elseif($options['status'] == 0){
			$status_icon = SITE_URL.'/app/webroot/img/active.png';
			$title = 'Deactive';
		}		
		$actions = "&nbsp;&nbsp;<span id='statuscoloumn_".$options['id']."'>".$html->link($html->image($status_icon,array('width'=>'15','height'=>'14')),'javascript:void(0);', array('title' => $title,'alt'=> $title,"onclick"=>"changeStatus('".$options['id']."','".$options['status']."','".$options['controller']."');",'escape'=>false), false, false)."</span>";
		return $actions;
	}
	/* options for total rooms */
	function totalRooms(){
		$totalRooms = array(''=>'Please Select Total Rooms');
		for($i=1;$i<=10;$i++){
			$totalRooms[$i] = $i;
		}
		return $totalRooms;
	}
	/* options for total bathrooms */
	function totalBathrooms(){
		$totalBathrooms = array(''=>'Please Select Total Bath-Rooms');
		for($i=1;$i<=10;$i++){
			$totalBathrooms[$i] = $i;
		}
		return $totalBathrooms;
	}	
	/* ==========get profile image if found otherwise first image will be return============ */
	function getProfileImage($userImage = null){
		$profileImage = array();
		if($userImage){
			foreach($userImage as $key=>$imageArr){
				$profileImage['image_name'] = $imageArr['image_name'];
				$profileImage['hash'] = $imageArr['hash'];
				if($imageArr['profile_default'] == 1){
					$profileImage['image_name'] = $imageArr['image_name'];
					break;
				}
			}
		}
		return $profileImage;
	}
	
}
?>