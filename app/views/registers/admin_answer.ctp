<div class="adminrightinner">
	<?php e($form->create('QuestionOption', array('url' => array('controller' => 'registers', 'action' => 'edit_answer'))));?>     
	<?php e($form->hidden('User.user_id',array('value'=>$user_id))); ?>	
	<div class="tablewapper2 AdminForm">
		<h3 class="legend1">Update Question's Answer</h3>
		<table border="0" class="Admin2Table" width="100%">				 
			<?php
			if(!empty($data)){?>
				<?php
				$i = 1;
				foreach($data as $key=>$quesArr){
					if(!empty($quesArr['Child'])){?>
						<tr>
							<td><b>Q<?php e($i.'. '.$quesArr['QuestionOption']['question_option_name']); ?></b></td>
						</tr>
						<?php
						$childOption = array();
						$checked = '';
						foreach($quesArr['Child'] as $child){
							$childOption[$child['id']] = $child['question_option_name'];							
							//if(in_array($child['id'],$select)){
								//$checked = $child['id'];
							//}							
						}?>
						<tr>
							<td><?php e($form->radio('QuestionOption.'.$quesArr['QuestionOption']['id'],$childOption,array('default'=>$checked,'label'=>false,'div'=>false,'separator'=>'<br>','legend'=>false))); ?></td>
						</tr>		
						<?php
					}					
				}			
			}else{?>
				<div style="color:blue, font-size:20; padding-bottom:30px;padding-top:30px;padding-left:280px" ><strong>Please First Add Question & Options</strong></div>
				<?php
			}?>
		</table>		
	</div>
	<div class="buttonwapper">
		<div><input type="submit" value="Submit" class="submit_button" /></div>
		</div>
	</div>
	<?php e($form->end()); ?>	
</div>
