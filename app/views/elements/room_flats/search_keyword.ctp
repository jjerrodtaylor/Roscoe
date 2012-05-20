<?php
$sortOptions = array(
	"" => "Sort by",
	"1" => "Newest to Oldest",
	"2" => "Oldest to Newest",
	"3" =>"highest price to lowest price",
	"4" =>"lowest price to highest price"
);
?>
<?php
if($this->params['action'] =='advance_search_result'){?>
	<li>
		<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td align="right">
					<?php  e($form->create('RoomFlat', array('url' => array('controller' => 'room_flats', 'action' => 'advance_search_result'), 'id'=>'sortAdvancedSearch'))); ?>  		
					<?php e($form->input('sort_price',array('options'=>$sortOptions,'div'=>false,'label'=>false))); ?>
					<?php e($form->end()); ?>						
				</td>
			</tr>
		</table>
	</li>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#RoomFlatSortPrice").change(function(){
				var sort_price = jQuery(this).val();
				jQuery('#LoadingDiv').html('<img src="'+SiteUrl+'/img/ajax-loader.gif'+'">');
				jQuery('#CustomerPaging').css('opacity','0.5');			
				var url =SITE_URL+'/room_flats/advance_search_result/page:<?php e($page); ?>';
				
				jQuery('#CustomerPaging').load(url,{'sort_price':sort_price},function(response, status, xhr) {			
					jQuery('#LoadingDiv').html('');
					jQuery('#CustomerPaging').css('opacity','1');			
						
				});		


			});

		})
	</script>	
	<?php
}else{?>
	<li>
		<label class="MyAccLbl">Search Keyword:</label>
		<span class="MySearchKeyVal">
		<?php
		
		if($session->read('Search.keyword') != 'Please Enter your keyword here'){
			$keyword = $session->read('Search.keyword');
		}else{
			$keyword = 'Null';
		}
		?>
		<?php e($keyword); ?>
		
		</span>
		<label class="sortOp">		
			<?php  e($form->create('RoomFlat', array('url' => array('controller' => 'room_flats', 'action' => 'search'), 'id'=>'sortSearch'))); ?>  		
			<?php e($form->input('sort_price',array('options'=>$sortOptions,'div'=>false,'label'=>false))); ?>
			<?php e($form->end()); ?>			
		</label>
	</li>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#RoomFlatSortPrice").change(function(){
				var sort_price = jQuery(this).val();
				jQuery('#LoadingDiv').html('<img src="'+SiteUrl+'/img/ajax-loader.gif'+'">');
				jQuery('#CustomerPaging').css('opacity','0.5');			
				var url =SITE_URL+'/room_flats/search/page:<?php e($page); ?>';
				
				jQuery('#CustomerPaging').load(url,{'sort_price':sort_price},function(response, status, xhr) {			
					jQuery('#LoadingDiv').html('');
					jQuery('#CustomerPaging').css('opacity','1');			
						
				});		


			});

		})
	</script>
	<?php
}?>
