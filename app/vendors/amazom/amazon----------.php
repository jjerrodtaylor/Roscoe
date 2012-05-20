<?php 
/*********************************************************** 
This File Sets Up Calls to Paypal by arranging url information. 
***********************************************************/ 
class Amazon{ 
     
    function getFormValue($data){

			//pr($dataarr);
			
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
			$key=0;
			foreach($data as $key=>$datavalue){
				$key++;
				$form['item_merchant_id_'.$key] = $merchant_id;
				$form['item_price_'.$key] = $datavalue['price'];
				$form['item_quantity_'.$key] = $datavalue['quantity'];
				$form['item_sku_'.$key] = $datavalue['sell_item_id'];
				$form['item_title_'.$key] = $datavalue['sell_item_name'];
			}
			ksort($form);

			// Encode order as string and calculate signature
			$order = '';
			foreach ($form as $key => $value) {
				$order .= $key . "=" . rawurlencode($value) . "&";
			}
			$form['merchant_signature'] = base64_encode(hash_hmac('sha1', $order, $aws_secret_access_key, true));

			// Return string with Amazon javascript and HTML form
			// Assumes you already have jQuery loaded elsewhere on page
			// URL's link to live site, not sandbox!
			$amazon_order_html = 
				'<script type="text/javascript" src="https://images-na.ssl-images-amazon.com/images/G/01/cba/js/widget/widget.js"></script>
				<form method="post" action="https://payments-sandbox.amazon.com/checkout/' . $merchant_id . '">';
			foreach ( $form as $key => $value ) {   
				$amazon_order_html .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
			}
			$amazon_order_html .= '<input alt="Checkout with Amazon Payments" src="https://payments.amazon.com/gp/cba/button?ie=UTF8&color=orange&background=white&cartOwnerId=' . $merchant_id . '&size=large" type="image"></form>';
			return $amazon_order_html;    
    } 
} 
?> 