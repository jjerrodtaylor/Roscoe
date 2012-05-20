<div class="adminrightinner">
<div class="tablewapper2 AdminForm">
<table border="0" class="Admin2Table formTable" width="100%">		
	<tr>
		<td valign="middle" width="20%" class="Padleft26"><?php e(__('Country_Name',true)) ;?></td>
		<td width="80%"> <?php e($data['Country']['name']);?></td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26"><?php e(__('State_Name',true)) ;?></td>
		<td><?php e($data['SpanState']['name']);?></td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26"><?php e(__('City_Name',true)) ;?></td>
		<td><?php e($data['City']['name']);?></td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26"><?php e(__('Created',true)) ;?></td>
		<td><?php e(date('Y-m-d',strtotime($data['City']['created'])));?></td>
	</tr>
	<tr>
		<td valign="middle" class="Padleft26"><?php e(__('Modified',true)) ;?></td>
		<td><?php e(date('Y-m-d',strtotime($data['City']['modified'])));?></td>
	</tr>
</table>
</div>	
	<div class="Addnew_button" style="margin-top:15px;">
	 <?php echo $html->link(__("Back",true), array('controller'=>'cities', 'action'=>'index'), array("title"=>"", "escape"=>false)); ?>
	</div>	
</div>