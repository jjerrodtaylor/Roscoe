<div class="adminrightinner">
	<div class="tablewapper2 AdminForm">
	<h3 class="legend1">View Country</h3>
		<?php 
			foreach ($data as $key=>$value){
			//prd($value);
		?>
		<table border="0" class="Admin2Table formTable" width="100%">		
			<tr>
				<td colspan="2" style="color:#CC0000;font-size: 14px;">Country Information</td>
			</tr>
			<tr>
				<td>Country  Name:</td>
				<td><?php e($value['Country']['name']);?></td>
			</tr>
			<tr>
				<td>Created Date:</td>
				<td><?php e($value['Country']['created']);?></td>
			</tr>
			<tr>
				<td>Modified Date:</td>
				<td><?php e($value['Country']['modified']);?></td>
			</tr>
		</table>
		<?php } ?>
		</div>
		<div class="buttonwapper">
			<div class="cancel_button">
				<?php echo $html->link("Back", "/admin/countries/index/", array("title"=>"", "escape"=>false)); ?>
			</div>
		</div>
</div>

