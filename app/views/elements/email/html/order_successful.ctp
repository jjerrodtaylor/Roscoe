<div>
	<table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-left:10px; margin-top:10px;">
		<tbody>
			<tr><td align="left"><img src="<?php e(SITE_URL);?>/img/logo.jpg" width="271" height="77"></td></tr>
  
		</tbody>
	</table>
	<br clear="all"><br clear="all">
	<div style="padding-left:10px;">

			<div  style="margin-bottom:10px;">

				  Order Confirmation Rattano<br><br>

				  <?php echo ucfirst(strtolower($data['User']['first_name']));?> <?php echo ucfirst(strtolower($data['User']['last_name']));?>,<br>

				  Thanks for shopping with us today!<br>

				  The following are the details of your order.<br><br>
				 	Order Number:  RT-<?php echo date('Y').date('m').date('d');?>-<?php echo $data['Order']['id'];?><br>
					Date Ordered: <?php echo strftime("%d-%b-%Y",strtotime($data['Order']['created']));?><br>
					
			</div>
	</div>
	 <?php 		
	  if(!empty($data)){
	?>
	<div style="color:#ccc;" width="100%">
		
				<table cellspacing="0"  style="background-color:#181818;border:1px solid #CCC;" width="100%">
						 <tr>
								<th width="50%" height="30px;" align="left" style="background-color:#181818;padding-left:5px;padding-right:5px;	color:#ccc;font-weight:bold;font-size:13px;"><strong>Billing Information</strong></th>
								<th width="50%" height="30px;"  align="left"  style="background-color:#181818;padding-left:5px;padding-right:5px;	color:#ccc;font-weight:bold;font-size:13px;"><strong>Shipping Information</strong></td>
							  </th>
							  <tr bgcolor="white">
								<td width="50%" style="color:#000000;font-size:12px; padding-bottom:10px;" >
								    <?php echo ucfirst(strtolower($data['User']['first_name']));?> <?php echo ucfirst(strtolower($data['User']['last_name']));?> <br>
								    <?php echo $data['User']['address1'];?><br>
									<?php echo $data['User']['address2'];?><br>
									<?php echo $data['User']['phone'];?><br>
									<?php echo $data['User']['city'];?><br>
									<?php echo $data['User']['state'];?><br>
									<?php echo $data['User']['country'];?><br>
									<?php echo $data['User']['postcode'];?><br>
									Email: <?php echo $data['User']['email'];?>
								</td>
								<td width="50%" style="color:#000000;font-size:12px;padding-bottom:10px;">
								<?php echo ucfirst(strtolower($data['User']['shipping_first_name']));?> <?php echo ucfirst(strtolower($data['User']['shipping_last_name']));?> <br>
									<?php echo $data['User']['shipping_address1'];?><br>
									<?php echo $data['User']['shipping_address2'];?><br>
									<?php echo $data['User']['shipping_phone'];?><br>
									<?php echo $data['User']['shipping_city'];?><br>
									<?php echo $data['User']['shipping_state'];?><br>
									<?php echo $data['User']['shipping_country'];?><br>
									<?php echo $data['User']['shipping_postcode'];?><br>
									Email: <?php echo $data['User']['shipping_email'];?>
									</td>
							  </tr>
							</tbody>
							</table>
	
	</div>
	<?php 
	}
	?>
	<br clear="all">
		  <div style="width:100%;">
			  	<?php 
			  	
			  	if(!empty($data['OrdersProduct'])){
			  	?>
			  
			  		 <table border="1" cellpadding="0" cellspacing="0"  id="shopping_table" style="width:100%;
	border-collapse:collapse;font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#CCC;border:1px solid;">
			  		 	<tr>
			  		 		<th width="2%" height="30px;" style="background-color:#181818;padding-left:5px;padding-right:5px;
	border:1px solid #CCC;">Qty</th>
			  		 		
			  		 		<th width="30%" height="30px;" style="background-color:#181818;padding-left:5px;padding-right:5px;
	border:1px solid #CCC;">Product Name </th>
							 <th width="15%" height="30px;" style="background-color:#181818;padding-left:5px;padding-right:5px;
	border:1px solid #CCC;">Unit Price</th>
							 
							 <th width="10%" height="30px;"style="background-color:#181818;padding-left:5px;padding-right:5px;
	border:1px solid #CCC;">Subtotal</th>
						</tr>
						<?php 
						
						 foreach($data['OrdersProduct'] as $key1=>$value){
						?>
						<tr>
							<td valign="top" height="30px;" style="text-align:center;padding-left:5px;padding-right:5px;padding-top:5px;padding-bottom:5px;border:1px solid #CCC;color:#000000;">
							<?php echo $data['OrdersProduct'][$key1]['quantity'];?>
							</td>
					
							<td valign="top" height="30px;" style="text-align:center;padding-left:5px;padding-right:5px;padding-top:5px;padding-bottom:5px;border:1px solid #CCC;color:#000000;">
							<?php 
							echo $prd_name = $general->getshopping_name($data['OrdersProduct'][$key1]['product_id']);
							
							?>
							</td>
							<td valign="top" height="30px;" style="text-align:center;padding-left:5px;padding-right:5px;padding-top:5px;padding-bottom:5px;border:1px solid #CCC;color:#C72D30;font-weight:bold;">&pound; <?php echo $prd_price = $general->getproduct_price($data['OrdersProduct'][$key1]['product_id']);?></td>
							
							<td valign="top" height="30px;" style="text-align:center;padding-left:5px;padding-right:5px;padding-top:5px;padding-bottom:5px;border:1px solid #CCC;color:#C72D30;font-weight:bold;">
							<?php 
							$total_price=$prd_price*$data['OrdersProduct'][$key1]['quantity'];
							?>
							&pound; <?php echo $total_price;?></td>
						</tr>
						<?php 
							}
						?>
						
					</table>
				
					 <div align="right" class="CheckoutTotal">
					   <table border="0" cellpadding="0" width="40%" align="right">
					      <tr>
						     <td>Grand Total</td>
						     <?php 
						  
							$subtotal_cart = $general->getorder_total($data['Order']['id']);
							?>						     
							<td>&pound; <?php echo $subtotal_cart;?></td>
						   </tr>	 
					   </table>
					</div>
					<div class="Clear"></div>
				
				<?php 
			  	}else{
			  		echo "Shopping Basket empty";
			  	
			  	}
				?>
			  
			  </div>
	<div class="Clear"></div>
<div class="footer">
    <div style="border-bottom:0px solid #9a9a9a;padding:5px;min-height:50px;">&copy; Copyright rattangardenfurniture-rattano.co.uk <a href="<?php echo SITE_URL;?>" target="_blank" rel="nofollow">Rattano</a>.</div>
  </div>
</div>