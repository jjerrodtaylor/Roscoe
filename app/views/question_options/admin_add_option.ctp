<div class="adminrightinner">
<?php e($form->create('ProductAttribute', array('url' => array('controller' => 'product_attributes', 'action' => 'add_option'))));  ?>     
	<div class="tablewapper2 AdminForm">
  <h3 class="legend1">Add  Product Attribute </h3>	
	<?php e($this->element('product_attributes/formadd'));?>
	</div>
	<div class="buttonwapper">
		<div>
			<input type="submit" value="Submit" class="submit_button" />
		</div>
		<div class="cancel_button">
			<?php echo $html->link("Cancel", "/admin/product_attributes/index_option/", array("title"=>"", "escape"=>false)); ?>
		</div>
	</div>
<?php e($form->end()); ?>	
</div>