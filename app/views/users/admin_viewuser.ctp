<div class="adminrightinner">
	<div class="tablewapper2 AdminForm">
	<h3 class="legend1">View User</h3>
		<?php 
			foreach ($data as $key=>$value){
			//prd($value);
		?>
		<table border="0" class="Admin2Table formTable" width="100%">		
			<tr>
				<td>Email Address:</td>
				<td style="color: #0099FF;font-size: 15px;"><?php e($value['User']['email']);?></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td colspan="2" style="color:#CC0000;font-size: 14px;">Personal Information</td>
			</tr>
			<tr>
				<td>User  Name:</td>
				<td><?php e($value['User']['username']);?></td>
			</tr>
			<tr>
				<td>First Name:</td>
				<td><?php e($value['UserReference']['first_name']);?></td>
			</tr>
			<tr>
				<td>Lsat  Name:</td>
				<td><?php e($value['UserReference']['last_name']);?></td>
			</tr>
			<tr>
				<td>Created Date:</td>
				<td><?php e($value['User']['created']);?></td>
			</tr>
			<tr>
				<td>Modified Date:</td>
				<td><?php e($value['User']['modified']);?></td>
			</tr>
		</table>
		<?php } ?>
		</div>
		<div class="buttonwapper">
			<div class="cancel_button">
				<?php echo $html->link("Back", "/admin/users/index/", array("title"=>"", "escape"=>false)); ?>
			</div>
		</div>
</div>

