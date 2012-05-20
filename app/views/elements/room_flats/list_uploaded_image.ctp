<?php 
$i = 0;
if(isset($this->data['RoomFlatImage']) && count($this->data['RoomFlatImage'])>0){?>
	<ul class="qq-upload-list">
		<?php
		foreach($this->data['RoomFlatImage'] as $key=>$image){?>
			<li class=" qq-upload-success">
				<span class="qq-upload-file"><?php e($image['image_name']); ?></span>
				<?php e($form->hidden('RoomFlatImage.'.$key.'.image_name',array('value'=>$image['image_name']))); ?>
				<?php e($form->hidden('RoomFlatImage.'.$key.'.hash',array('value'=>$image['hash']))); ?>
			
			</li>
			<?php
			$i++;
		}?>
	</ul>
	<?php
}?>
<?php e($form->hidden('image_count',array('value'=>$i,'id'=>'image_count'))); ?>
