<?php
  e($javascript->link(array('jquery/jquery.min', 'product'), false));
?>
<div id="InBanner">
		<div class="InBanner1">			
			<h1>Sitemap</h1>
		</div>
	</div>
	<div class="paddingTopBottom">
	     <ul class="Foternavi">
          <li>
            <h2>Our Store</h2>
          </li>
		  <?php
		  $categories = $general->getCategories();		   
		   if(!empty($categories)){
		    foreach($categories as $key=>$value){			
		 ?>
		<li>
		<?php e($html->link($key, array('controller'=>'products', 'action'=>'product_list', 'cat'=>$value)));?>	
		</li>		
		<?php
		   }
		 }
		?>         
        </ul>
		 <ul class="Foternavi">
		  <li>
            <h2>Other Links</h2>
          </li>
		      <li><?php e($html->link('About Us', array('controller'=>'static_pages', 'action'=>'view', 'title'=>'about-us')));?></li>
			  <?php /*<li><?php e($html->link('Clearance', array('controller'=>'static_pages', 'action'=>'view', 'title'=>'clearance')));?></li>*/?>
			  <li><?php e($html->link('Delivery', array('controller'=>'static_pages', 'action'=>'view', 'title'=>'delivery')));?></li>
			  <li><?php e($html->link('Faq\'s', array('controller'=>'static_pages', 'action'=>'view', 'title'=>'faq')));?></li>
			<li><?php e($html->link(' Contact', array('controller'=>'static_pages', 'action'=>'contact')));?></li>
			  <li><?php e($html->link('View Shopping Basket', array('controller'=>'orders', 'action'=>'cart')));?></li>
			  <li><?php e($html->link('Blog', SITE_URL.'/blog/'));?></li>
		 </ul>
		 <ul class="Foternavi">
		  <li>
            <h2>Our Products</h2>
		 </li>
		 <?php
		  if(isset($data)){
		 ?>
		 <?php e($form->create('Products', array('url'=>array('controller'=>'products', 'action'=>'view'), 'id' => 'ProductsnewListForm')));		 
		 e($form->hidden('product_id', array('id'=>'newproduct_id')));
		 ?>
		<?php	
		   foreach($data as $values){
		?> 
		<li>
		 <?php e($html->link($values['Product']['name'], array('controller'=>'products', 'action'=>'view',  
				'category'=>$values['Category']['slug'],'slug'=>$values['Product']['slug'], 'ext'=>CUSTOM_URL_EXT),
				array('onclick' => 'return viewnewProduct(this, '.$values['Product']['id'].')', 
				'class'=>'productList','title'=>$values['Product']['name']), '', false));?>
		</li>
		<?php
		 }
		 e($form->end());
		}
		?>
        </ul>		 
	</div>
	<div class="Clear"></div>		
	</div>
	<?php e($this->element('middle_container'));?>