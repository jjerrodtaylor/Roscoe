<?php 
$i = 0;
if(isset($this->data['UserImage']) && count($this->data['UserImage'])>0){?>
	<ul class="qq-upload-list">
		<?php
		foreach($this->data['UserImage'] as $key=>$image){?>
			<li class=" qq-upload-success">
				<span class="qq-upload-file"><?php e($image['image_name']); ?></span>
				<?php e($form->hidden('UserImage.'.$key.'.image_name',array('value'=>$image['image_name']))); ?>
				<?php e($form->hidden('UserImage.'.$key.'.hash',array('value'=>$image['hash']))); ?>
			
			</li>
			<?php
			$i++;
		}?>
	</ul>
	<?php
}?>
<?php e($form->hidden('image_count',array('value'=>$i,'id'=>'image_count'))); ?>
