<div class="adminrightinner">
<div class="tablewapper2 AdminForm">
<table border="0" class="Admin2Table" width="100%">		
	<tr>
		<td valign="middle" width="20%" class="Padleft26"><?php e(__('Country_Name',true)) ;?></td>
		<td width="80%"> <?php e($data['Country']['name']);?></td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26"><?php e(__('ISO_Code',true)) ;?></td>
		<td><?php e($data['Country']['iso_code']);?></td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26"><?php e(__('Created',true)) ;?></td>
		<td><?php e(date('Y-m-d',strtotime($data['Country']['date_created'])));?></td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26"><?php e(__('Modified',true)) ;?></td>
		<td><?php e(date('Y-m-d',strtotime($data['Country']['date_updated'])));?></td>
	</tr>
</table>
</div>	
	<div class="Addnew_button" style="margin-top:15px;">
	 <?php echo $html->link(__("Back",true), array('controller'=>'countries', 'action'=>'index'), array("title"=>"", "escape"=>false)); ?>
	</div>	
</div>