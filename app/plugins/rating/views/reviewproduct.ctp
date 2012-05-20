
<?php e($form->create('RatingReview', array('name'=>'RatingReview','id'=>'formailreview', 'class'=>'good-form')));
e($form->hidden('RatingReview.product_id',array('value'=>$data[0]['Product']['id'],'id'=>'product_id')));
?>
	<table>
	<tr>
		<td>Tell the community about your experience using the <?php e($data[0]['ProductDescription']['products_name']);?>
		<br>
			<?php echo $form->input('RatingReview.description', array('id'=>'description','cols'=>'70','rows'=>'4','div'=>false,'label'=>false,'type'=>'textarea'));?>
		</td>
	</tr>
	<tr>
		<td>The bottom line. Summarize your experience with this product in one sentence. This will also serve as the title of your review.
		<br>
			<?php echo $form->input('RatingReview.title', array('id'=>'text','div'=>false,'label'=>false,'type'=>'text','style'=>'width:582px;'));?>
		</td>
	</tr>
	<tr>
		<td>
		<div class="submit">							
		<?php e($form->button('<span>Submit</span>', array('type'=>'submit', 'escape'=>false,'id'=>'sendreview','class'=>'OrngBtn')));?>						
		</div>	
		</td>
	</tr>
	</table>
<?php
		e($form->end());
	?>