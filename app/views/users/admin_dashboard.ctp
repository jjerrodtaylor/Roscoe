	<div class="adminrightinner">
		<div class="DashboardManager AdminForm" style="border:1px solid #666666;">
			<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
				<tr>
					<td  height="100" align="center"  >
					<?php e($html->link($html->image('/img/admin/admin_common_image.png', array('border'=>'0')).'<br/>Admin Management', array('controller'=>'users', 'action'=>'index'), array('escape'=>false)));?>			
					</td>
					<td  height="100" align="center">			
					<?php e($html->link($html->image('/img/admin/admin_common_image.png', 
					array('border'=>'0')).'<br/>User Management', array('controller'=>'registers', 'action'=>'index'), 
					array('escape'=>false, 'class'=>'dashboardLink')));
					?>	
					</td>
					<td height="100" align="center">			
					<?php e($html->link($html->image('/img/admin/admin_common_image.png', 
					array('border'=>'0')).'<br/>Static Page Management', array('controller'=>'static_pages', 
					'action'=>'index'), array('escape'=>false)));
					?>	
					</td>
					<td  height="100" align="center" >
					<?php e($html->link($html->image('/img/admin/admin_common_image.png', array('border'=>'0')).'<br/>Global Setting Management', array('controller'=>'settings', 'action'=>'index'), array('escape'=>false)));?>			
					</td>
				</tr>
				<tr>
					<td  height="100" align="center"  >
					<?php e($html->link($html->image('/img/admin/admin_common_image.png', array('border'=>'0')).'<br/>Email Template Management', array('controller'=>'email_templates', 'action'=>'index'), array('escape'=>false)));?>			
					</td>
					<td  height="100" align="center">			
					<?php /* e($html->link($html->image('/img/admin/admin_common_image.png', 
					array('border'=>'0')).'<br/>User Management', array('controller'=>'registers', 'action'=>'index'), 
					array('escape'=>false, 'class'=>'dashboardLink'))); */
					?>	
					</td>
					<td height="100" align="center">			
					<?php /* e($html->link($html->image('/img/admin/admin_common_image.png', 
					array('border'=>'0')).'<br/>Static Page Management', array('controller'=>'static_pages', 
					'action'=>'index'), array('escape'=>false))); */
					?>	
					</td>
					<td  height="100" align="center" >
					<?php //e($html->link($html->image('/img/admin/admin_common_image.png', array('border'=>'0')).'<br/>Global Setting Management', array('controller'=>'settings', 'action'=>'index'), array('escape'=>false)));?>			
					</td>
				</tr>				
			</table>
		</div>
	</div>