<div class="PagingTable">
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
     <?php 
       if($paginator->params['paging'][$paging_model_name]['pageCount'] >= 2){
     ?>
      <tr>
            <td class="paging">
			 <?php
			    echo $paginator->prev($html->image('/img/admin/prev.gif', array('border' => '0')), array('escape' => false));
			    echo $paginator->numbers();			           
			    echo $paginator->next($html->image('/img/admin/next.gif', array('border' => '0')), array('escape' => false));
			  ?>				
		 </td>
		</tr>
	<?php 
       }
	?>	
	 <tr>
            <td>
                <strong> <?php echo "Total ".$total_title." : " . $this->params["paging"][$paging_model_name]["count"]; ?> </strong>
            </td>
            
        </tr>
</table>
</div>