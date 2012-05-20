<div class="adminrightinner">
	<div class="tablewapper2 AdminForm">
	<h3 class="legend1">View State</h3>
		<?php 
			foreach ($data as $key=>$value){
		?>
		<table border="0" class="Admin2Table formTable" width="100%">		
			<tr>
				<td colspan="2" style="color:#CC0000;font-size: 14px;">State Information</td>
			</tr>
			<tr>
				<td>Country   Name:</td>
				<td><?php $product_attributes_array = ClassRegistry::init('Country')->getCountryListData($value['State']['country_id']);
			echo $product_attributes_array['Country']['name'];
			?></td>
			</tr>
			<tr>
				<td>State  Name:</td>
				<td><?php e($value['State']['name']);?></td>
			</tr>
			<tr>
				<td>Created Date:</td>
				<td><?php e($value['State']['created']);?></td>
			</tr>
			<tr>
				<td>Modified Date:</td>
				<td><?php e($value['State']['modified']);?></td>
			</tr>
		</table>
		<?php } ?>
		</div>
		<div class="buttonwapper">
			<div class="cancel_button">
				<?php echo $html->link("Back", "/admin/States/index/", array("title"=>"", "escape"=>false)); ?>
			</div>
		</div>
</div>

