	<?php
	//print_r($this->params['paging'][$ModelName]['page']);
	if($this->params['paging'][$ModelName]['pageCount'] >1){?>	
		<div id="pagination-flickr">
			<?php
			$paginator->options(array('update'=>'CustomerPaging','url'=>array('controller'=>$ControllerName, 'action'=>$action),'indicator' => 'LoadingDiv'));
			echo $paginator->prev('<< Previous', array('class' => 'previous-off'), null);
			echo $paginator->numbers(array('separator'=>'')); 
			echo $paginator->next('Next >>', array('class' => 'next next-off'), null);
			?>
		</div>
		<?php
	}?>