<?php 
/*********************************************************** 
This File Sets Up Calls to Amazon by arranging url information. 
***********************************************************/ 
class Amazon{ 
    
    function getFormValue($data){
			$merchant_id = 'ABXUOI32PS2O9';
			$aws_access_key_id = 'AKIAI37KHQQIHLZYC7GQ'; 
			$aws_secret_access_key = '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';
			$form['aws_access_key_id'] = $aws_access_key_id;
			$form['currency_code'] = 'USD';
			$form['processImmediate'] = '1';
			$form['shipping_method_service_level_1'] = "standard";
			$form['shipping_method_region_1'] = "us_all";
			$form['shipping_method_price_per_shipment_amount_1'] = 5.90;
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
			$order = '';
			foreach ($form as $key => $value) {
				$order .= $key . "=" . rawurlencode($value) . "&";
			}
			$calculator = new SignatureCalculator();
			$signature = $calculator->calculateRFC2104HMAC($order, $aws_secret_access_key);
			//$form['merchant_signature'] = base64_encode(hash_hmac('sha1', $order, $aws_secret_access_key, true));
			$form['merchant_signature']=$signature;
			$amazon_order_html = 
				'
				<script type="text/javascript" src="https://images-na.ssl-images-amazon.com/images/G/01/cba/js/widget/widget.js"></script>
				<form method="post" action="https://payments-sandbox.amazon.com/checkout/' . $merchant_id . '">';
			foreach ( $form as $key => $value ) {   
				$amazon_order_html .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
			}
			$amazon_order_html .= '<input alt="Checkout with Amazon Payments" src="https://payments-sandbox.amazon.com/gp/cba/button?ie=UTF8&color=orange&background=white&cartOwnerId=' . $merchant_id . '&size=large" type="image"></form>';
			return $amazon_order_html;    
    } 
} 
class SignatureCalculator {
	protected static $HMAC_SHA1_ALGORITHM = "sha1";
	public function SignatureCalculator() {
  }
	public function calculateRFC2104HMAC($data, $key) {
		$rawHmac = hash_hmac(SignatureCalculator::$HMAC_SHA1_ALGORITHM, $data, $key, true);
		return base64_encode($rawHmac);
  }
}
?> 