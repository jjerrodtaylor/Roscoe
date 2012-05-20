<?php 
/*********************************************************** 
This File Sets Up Calls to Paypal by arranging url information. 
***********************************************************/ 
class Amazon{ 
     
    function getFormValue($data){
			$merchant_id = 'ABXUOI32PS2O9';
			$aws_access_key_id = 'AKIAI37KHQQIHLZYC7GQ'; 
			$aws_secret_access_key = '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';
			$price=23;
			$quantity=2;
			$sku=1;
			$item_name="sds";
			
			// Set up cart
			$form['aws_access_key_id'] = $aws_access_key_id;
			$form['currency_code'] = 'USD';
			$form['immediateReturn'] = '1';
			$form['referenceId'] = '109';
			$form['signatureVersion'] = 2;
			$form['signatureMethod'] = 'HmacSHA256';
			$form['amazonPaymentsAccountId'] = 'ABXUOI32PS2O9';
			$form['ipnUrl'] = 'http://192.168.1.122/cellsolo/orders/thanks';
			$form['returnUrl'] = 'http://192.168.1.122/cellsolo/orders/thanks';
			$form['processImmediate'] = '1';
			$form['abandonUrl'] = 'http://192.168.1.122/cellsolo/abandon';
			
			$key=0;
			foreach($data as $key=>$datavalue){
				$key++;
				$form['item_merchant_id_'.$key] = $merchant_id;
				$form['item_price_'.$key] = $datavalue['price'];
				$form['item_quantity_'.$key] = $datavalue['quantity'];
				//$form['item_sku_'.$key] = $datavalue['sell_item_id'];
				
				$form['item_title_'.$key] = $datavalue['sell_item_name'];
			}
			ksort($form);
			
			// Encode order as string and calculate signature
			$order = '';
			foreach ($form as $key => $value) {
				$order .= $key . "=" . rawurlencode($value) . "&";
			}
			$form['merchant_signature'] = Base64Encode(HmacSHA256('',$merchant_id, $aws_secret_access_key ));

			// Return string with Amazon javascript and HTML form
			// Assumes you already have jQuery loaded elsewhere on page
			// URL's link to live site, not sandbox!
			$amazon_order_html = 
				'<script type="text/javascript" src="https://images-na.ssl-images-amazon.com/images/G/01/cba/js/widget/widget.js"></script>
				<form method="post" action="https://authorize.payments-sandbox.amazon.com/pba/paypipeline">';
			foreach ( $form as $key => $value ) {   
				$amazon_order_html .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
			}
			$amazon_order_html .= '<input alt="Checkout with Amazon Payments" src="https://payments.amazon.com/gp/cba/button?ie=UTF8&color=orange&background=white&cartOwnerId=' . $merchant_id . '&size=large" type="image"></form>';
			return $amazon_order_html;    
    } 
} 


	//	$shipping_array['zip'] ='19312';
	//	$shipping_array['state']='PA';
	//	$shipping_array['country']='US';
	//	$shipping_array['city']='Berwyn';
	
	
	Stephen Kratsios
123 Main St, 510 iLoBao
Apt. 2B - 39 HPnu
abxQbNKFwtOpfwA
Dallas, TX
73054
5551234567 
?> 