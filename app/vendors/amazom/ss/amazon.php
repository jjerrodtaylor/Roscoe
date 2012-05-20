<?php 	$merchant_id = 'ABXUOI32PS2O9';	$aws_access_key_id = 'AKIAI37KHQQIHLZYC7GQ'; 	$aws_secret_access_key = 'N/JSfQxTTfG3/IXqnuswc/SX2BVxZZkQ9ERUi+dz';	$form['aws_access_key_id'] = $aws_access_key_id;	$form['currency_code'] = 'USD';	$form['item_merchant_id_1'] = $merchant_id;	$form['item_price_1'] = 1;	$form['item_quantity_1'] = 1;	$form['item_sku_1'] = 1;	$form['item_title_1'] = "prodycttc";	$form['shipping_method_service_level_1'] = "standard";	$form['shipping_method_region_1'] = "us_all";	$form['shipping_method_price_per_shipment_amount_1'] = 5.90;	$form['returnUrl'] = 'http://cellsolo.com/amazon.php';	$form['continue_shopping_URL'] = 'http://cellsolo.com/amazon.php';	$form['continue_shopping_URL'] = 'http://cellsolo.com/amazon.php';	ksort($form);	$order = '';	foreach ($form as $key => $value) {		$order .= $key . "=" . rawurlencode($value) . "&";	}$form['merchant_signature'] = base64_encode(hash_hmac('sha1', $order, $aws_secret_access_key, true));$amazon_order_html =   '<script type="text/javascript" src="https://images-na.ssl-images-amazon.com/images/G/01/cba/js/widget/widget.js"></script>	<form method="post" action="https://payments-sandbox.amazon.com/checkout/' . $merchant_id . '">';foreach ( $form as $key => $value ) {     $amazon_order_html .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';}$amazon_order_html .= '<input alt="Checkout with Amazon Payments" src="https://payments-sandbox.amazon.com/gp/cba/button?ie=UTF8&color=orange&background=white&cartOwnerId=' . $merchant_id . '&size=large" type="image"></form>';echo  $amazon_order_html;  ?>










