<div class="adminrightinner">	
	
	<?php e($form->create(null,array('controller'=>'registers','action'=>'question_answer',$user_id))); ?>
	<?php e($form->hidden('User.user_id',array('value'=>$user_id))); ?>
	<div class="tablewapper2 AdminForm">
	<h3 class="legend1">Update Question's Answer</h3>
		<table border="0" class="Admin2Table" width="100%">	
			<?php 
			if(!empty($data)){?>
				<?php 
				$count = 1;
				foreach ($data as $key=>$value){
					if(count($value['Child']) >0){?>
						<tr>
							<td><b>
							<?php
							e($count++.'. '.$value['QuestionOption']['question_option_name']);
							$question_id = $value['QuestionOption']['id'];
							?></b>
							</td>
						</tr>						
						<tr>
							<?php
							$childOption = array();
							$checked = '';
							foreach($value['Child'] as $child){
								$childOption[$child['id']] = $child['question_option_name'];
								if(in_array($child['id'],$select)){
									$checked = $child['id'];
								}
								
							}?>
							<td>
							<?php								
							echo $form->radio('QuestionOption.'.$question_id,$childOption,array('default'=>$checked,'label'=>false,'div'=>false,'separator'=>'<br>','legend'=>false));
							?>
							</td>
						</tr>								
						<?php 
					}
				} 
			}else{?>
				<tr>
					<td>Not Found Records.Please Add first Questions.</td>
				</tr>		
				<?php
			}?>	
		</table>
	
	</div>
	<div class="buttonwapper">
		<div>
			<input type="submit" value="Submit" class="submit_button" />
		</div>
	</div>	
	<?php e($form->end()); ?>
</div>