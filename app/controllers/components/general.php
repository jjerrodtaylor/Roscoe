<?php
/**
 * General Component
 *
 * PHP version 5
 *
 * @category Component 
 */
class GeneralComponent extends Object{	
	
	function createSlug($string){		
		return low(Inflector::slug($string, '-'));		
	}
	function truncate($string){
	  return substr($string, 0, 300);	
	}	
	function getCatgoriesPhone(){	
		$Category = new Category ;	  			
		
		
		$category_list = $Category->find('threaded',array('fields' => array('name', 'lft', 'rght', 'parent_id','id','show_navigation'), 'order' => 'lft ASC','conditions'=>array('Category.category_type'=>Configure::read('App.PhoneProduct'))));
		return $category_list ; 					
	}
	function getCatgoriesAccessory(){	
		$Category = new Category ;
	  	$accessories_cat_array=$Category->find('all',array('conditions'=>array('Category.category_type'=>Configure::read('App.AccessoryProduct'))));
	  	return $accessories_cat_array ; 	
	}
	function getProductAccessory(){
	
		$Product = new Product ;
		return $Product->getProduct_Accessory();
	
	}
	/* add new at 27-3-12  */
	function myclean($data = null){
		if($data){
			foreach($data as $key=>$value){
				$data[$key] = trim($value);
			
			}
		}
		return $data;
	
	}
	/* To delete tree structure of given folder or directory */
	function deleteDirectory($dirname) {
		chmod($dirname,0777);
		if (is_dir($dirname)){
			
			$dir_handle = opendir($dirname);
			chmod($dir_handle,0777);
		}
		if (!$dir_handle){
			return false;
		}
		while($file = readdir($dir_handle)) {
			
			if ($file != "." && $file != ".." && $file != "Thumbs.db") {
				if (!is_dir($dirname."/".$file)){
					chmod($dirname."/".$file,0777);
					@unlink($dirname."/".$file);
				}else{
					chmod($dirname."/".$file,0777);
					$this->deleteDirectory($dirname.'/'.$file);
				}
			}
		}
		if(file_exists($dirname.'/Thumbs.db')){
			unlink($dirname.'/Thumbs.db');
		} 		
		closedir($dir_handle);
		rmdir($dirname);
		return true;
	}
	
}

?>