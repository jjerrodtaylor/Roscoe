	<table border="0" class="Admin2Table" width="100%">			   
		<tr>
			<td valign="middle" class="Padleft26"><?php echo $res['Setting']['name']; ?><span class="input_required">*</span></td>
			<td><?php e($form->input($modelName.'.value', array('div'=>false, 'label'=>false, "class" => "TextBox5")));?></td>
		</tr>
	</table>