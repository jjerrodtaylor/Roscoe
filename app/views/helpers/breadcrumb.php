<?php
class BreadcrumbHelper extends Helper { 

    var $helpers    = array('Html'); 
    var $sHome      = 'Home'; 
    var $sAdmin     = 'Admin'; 

    public function display($aBreadcrumbs) { 
	

        if (is_array($aBreadcrumbs)) { 
       
        $sBreadcrumbsID = isset($this->params['admin']) ? 'breadcrumbs_admin' : 'breadcrumbs'; 
        $returnHTML = '<ul id="' . $sBreadcrumbsID . '">'; 

        # Build the first breadcrumb dependent on if admin area is active or the front end   
        $this->aFirstBreadcrumb = isset($this->params['admin']) ? array('title' => $this->sAdmin, 'slug' => 'admin/') : array('title' => $this->sHome, 'slug' => ''); 
        $returnHTML .= '<li>' . $this->Html->link($this->aFirstBreadcrumb['title'], "/" . $this->aFirstBreadcrumb['slug']) . '</li>'; 
        $total = count($aBreadcrumbs);
		$lessOne = $total -1 ;
		for($count = 0; $count < $total; $count++){
            if($count == $lessOne){
			   $returnHTML .= '<li>' .$aBreadcrumbs[$count]['title']. '</li>';
            }
            else{			
             $returnHTML .= '<li>' . $this->Html->link($aBreadcrumbs[$count]['title'], $aBreadcrumbs[$count]['slug']) . '</li>';		   }
		}
        $returnHTML .= '</ul>'; 
        return $returnHTML; 
        } 

    } 

} 
?>