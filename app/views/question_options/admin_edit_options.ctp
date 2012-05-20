<script type="text/javascript">
function addElement(parent_id) {
	
    var ni = document.getElementById('myDiv');
    var numi = document.getElementById('theValue');
    var num = (document.getElementById('theValue').value -1)+ 2;
    numi.value = num;
    var newdiv = document.createElement('div');
    var divIdName = 'my'+num+'Div';
    newdiv.setAttribute('id',divIdName);                

	if(num <= 50)
    {
		var table = '<table width="100%">';
			table +=	'<tr>';
			table +=		'<input type="hidden" id="QuestionOption'+num+'parent_id" name="data[QuestionOption]['+num+'][parent_id]" value ='+parent_id+'>';
			table +=		'<td align="left" width="64%">';
			table +=			'<input type="type" id="QuestionOption'+num+'question_option_name" name="data[QuestionOption]['+num+'][question_option_name]" size="95" class="newInput">';
			table +=		'</td>';
			table +=		'<td align="left">';
			table +=			'<a href=\'javascript:void(0)\' onclick=\'removeElement("'+divIdName+'")\' style="color:#C2D4C9;font-size:18px;">Remove</a>';
			table +=		'</td>';
			table +=	'</tr>';
			table +='</table>';
		
		newdiv.innerHTML =table;
        ni.appendChild(newdiv);
    }
}
function removeElement(divNum) { 
	
	var d = document.getElementById('myDiv');
	var olddiv = document.getElementById(divNum);
	d.removeChild(olddiv);
	
}

</script>
<div class="adminrightinner">

  	 <?php e($form->create('QuestionOption', array('url' => array('controller' => 'question_options', 'action' => 'edit_options'))));?>
 	 <?php //e($form->hidden('QuestionOption.id',array('div'=>false,'label'=>false)));?>
	  <div class="tablewapper2 AdminForm">

        <table border="0" class="Admin2Table" width="100%">
		<tr>
			<td align='left' colspan="2"> 
				<h2>Question : </h2><?php e($this->data['QuestionOption']['question_option_name']);?>
			</td>
		</tr>        
        <tr>
        	<td colspan='2'>&nbsp;</td>
        </tr>
           
		<tr>
			<td align='left' width ='65%'><B>Options</B></td>
			<td><B>Action</B</td>
		</tr>
		<tr>
			<td colspan="2">
				<table width="100%">
					<tr>
						<td>
							<div id="contentNav">
								<ul style='list-style-type: none;'>
									<?php 
									$rows = 1;
									foreach($this->data['Child'] as $key=>$value){?>										
										<li class = 'romove<?php e($value['id']); ?>' id="recordsArray_<?php e($value['id']);?>">														
											<?php 
											e($form->hidden('QuestionOption.'.$rows.'.id',array('value'=>$value['id']))); 
											e($form->hidden('QuestionOption.'.$rows.'.parent_id',array('value'=>$value['parent_id'])));											
											?>											
											<span class ='Navsubitem1'>
												<?php e($form->input('QuestionOption.'.$rows.'.question_option_name',array('type'=>'text','size'=>'95','div'=>false,'label'=>false,'value'=>$value['question_option_name'])));?>
											</span>
											<span class ='Navsubitem2'>
												<?php e($html->link('Delete',array('admin'=>true,'controller'=>'question_options','action'=>'delete_option',$value['parent_id'],$value['id']),array('style'=>'color:#C2D4C9;font-size:18px;','class'=>'deleteItem')));?>				
											</span>											
										</li>
										<?php 
										$rows++;
									}?>									
								</ul>
							</div>
						</td>
					</tr>
					<tr>
						<td>
						<input type="hidden" value="<?php e(--$rows);?>" id="theValue" name="theValue" />
						<div id="myDiv"></div>
						</td>
					</tr>
					<tr>
						<td  align='left'>
						<?php e($html->link('Add option...','javascript:void(0);',
										array('onclick'=>'addElement('.$this->data['QuestionOption']['id'].');','style'=>'color:#C2D4C9;font-size:18px;')));?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
      	</table>

    </div>
    <div class="buttonwapper">
        <div><?php e($form->submit('Update',array('div'=>false,'label'=>false,'class'=>'submit_button')));?></div>
		<div class="cancel_button">
			<?php e($html->link("Cancel", array('admin'=>true, 'controller'=>'question_options', 'action'=>'index'), 
			array("title"=>"", "escape"=>false)));
			?>
		</div>   
    </div>
    <?php  e($form->end());	 ?>

</div>
