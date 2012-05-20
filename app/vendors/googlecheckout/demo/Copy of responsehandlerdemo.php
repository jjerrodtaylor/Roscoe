<?php
			chdir("..");
			define('__ROOT__', dirname(dirname(__FILE__)));
			include(__ROOT__.'/library/googleresponse.php'); 
			include(__ROOT__.'/library/googlemerchantcalculations.php'); 
			include(__ROOT__.'/library/googleresult.php'); 
			include(__ROOT__.'/library/googlerequest.php'); 
			include(__ROOT__.'/database.php');
				$databaseObj =	new  DB();
			
			  define('RESPONSE_HANDLER_ERROR_LOG_FILE', __ROOT__.'/googleerror.log');
			  define('RESPONSE_HANDLER_LOG_FILE',__ROOT__.'/googlemessage.log');

			  $merchant_id = "874298113276811";  // Your Merchant ID
			  $merchant_key = "tjMH0Ec5x_epjyjpkJPr8w";  // Your Merchant Key
			  $server_type = "sandbox";  // change this to go live
			  $currency = 'USD';  // set to GBP if in the UK

			  $Gresponse = new GoogleResponse($merchant_id, $merchant_key);

			  $Grequest = new GoogleRequest($merchant_id, $merchant_key, $server_type, $currency);

			  //Setup the log file
			  $Gresponse->SetLogFiles(RESPONSE_HANDLER_ERROR_LOG_FILE, 
													RESPONSE_HANDLER_LOG_FILE, L_ALL);

			  // Retrieve the XML sent in the HTTP POST request to the ResponseHandler
			  $xml_response = isset($HTTP_RAW_POST_DATA)?
								$HTTP_RAW_POST_DATA:file_get_contents("php://input");
			  if (get_magic_quotes_gpc()) {
				$xml_response = stripslashes($xml_response);
			  }
			  list($root, $data) = $Gresponse->GetParsedXML($xml_response);
			  $Gresponse->SetMerchantAuthentication($merchant_id, $merchant_key);
				
				//print_r($Gresponse->GetParsedXML($xml_response));
				$googleOrderData	=	$Gresponse->GetParsedXML($xml_response);
				$paymentData['contact_name'] 	= $googleOrderData[1]['new-order-notification']['buyer-billing-address']['contact-name']['VALUE'];
				$paymentData['company_name'] 	= $googleOrderData[1]['new-order-notification']['buyer-billing-address']['company-name']['VALUE'];
				$paymentData['address1']     	= $googleOrderData[1]['new-order-notification']['buyer-billing-address']['address1']['VALUE'];
				$paymentData['address2']     	= $googleOrderData[1]['new-order-notification']['buyer-billing-address']['address2']['VALUE'];
				$paymentData['email']       	= $googleOrderData[1]['new-order-notification']['buyer-billing-address']['email']['VALUE'];
				$paymentData['phone']        	= $googleOrderData[1]['new-order-notification']['buyer-billing-address']['phone']['VALUE'];
				$paymentData['fax'] 					= $googleOrderData[1]['new-order-notification']['buyer-billing-address']['country_code']['VALUE'];
				$paymentData['country_code']  = $googleOrderData[1]['new-order-notification']['buyer-billing-address']['country-code']['VALUE'];
				$paymentData['city']       		= $googleOrderData[1]['new-order-notification']['buyer-billing-address']['city']['VALUE'];
				$paymentData['region']  			= $googleOrderData[1]['new-order-notification']['buyer-billing-address']['region']['VALUE'];
				$paymentData['postal_code']  	= $googleOrderData[1]['new-order-notification']['buyer-billing-address']['postal-code']['VALUE'];
				
				
				$paymentData['contact_name_shipping'] 	= $googleOrderData[1]['new-order-notification']['buyer-shipping-address']['contact-name']['VALUE'];
				$paymentData['company_name_shipping'] 	= $googleOrderData[1]['new-order-notification']['buyer-shipping-address']['company-name']['VALUE'];
				$paymentData['address1_shipping']     	= $googleOrderData[1]['new-order-notification']['buyer-shipping-address']['address1']['VALUE'];
				$paymentData['address2_shipping']     	= $googleOrderData[1]['new-order-notification']['buyer-shipping-address']['address2']['VALUE'];
				$paymentData['email_shipping']       		= $googleOrderData[1]['new-order-notification']['buyer-shipping-address']['email']['VALUE'];
				$paymentData['phone_shipping']        	= $googleOrderData[1]['new-order-notification']['buyer-shipping-address']['phone']['VALUE'];
				$paymentData['fax_shipping'] 						= $googleOrderData[1]['new-order-notification']['buyer-shipping-address']['fax']['VALUE'];
				$paymentData['country_code_shipping']  	= $googleOrderData[1]['new-order-notification']['buyer-shipping-address']['country-code']['VALUE'];
				$paymentData['city_shipping']       		= $googleOrderData[1]['new-order-notification']['buyer-shipping-address']['city']['VALUE'];
				$paymentData['region_shipping']  				= $googleOrderData[1]['new-order-notification']['buyer-shipping-address']['region']['VALUE'];
				$paymentData['postal_code_shipping']  	= $googleOrderData[1]['new-order-notification']['buyer-shipping-address']['postal-code']['VALUE'];
				$paymentData1['merchant_private_data']    = $googleOrderData[1]['new-order-notification']['order-summary']['shopping-cart']['merchant-private-data']['VALUE'];
				$str	=	$paymentData1['merchant_private_data'];
				$arr = explode('-',$str);
				$paymentData['sell_item_buyer_id'] = $arr[1];
				$paymentData['seller_user_id'] = $arr[3];
				$paymentData['created'] = date('Y-m-d H:i:s');
				$paymentData['order_total']  	= $googleOrderData[1]['new-order-notification']['order-total']['VALUE'];
				$paymentData['shipping_name']  	= $googleOrderData[1]['new-order-notification']['order-adjustment']['shipping']['flat-rate-shipping-adjustment']['shipping-name']['VALUE'];
				$paymentData['shipping_handling']  	= $googleOrderData[1]['new-order-notification']['order-adjustment']['shipping']['flat-rate-shipping-adjustment']['shipping-cost']['VALUE'];
				$paymentData['order_summary']  	= $googleOrderData[1]['new-order-notification']['order-summary']['shopping-cart']['items']['shipping-cost']['VALUE'];
				$paymentData['shopping-cart']  	= $googleOrderData[1]['new-order-notification']['order-summary']['shopping-cart']['items']['item'];
				
				$paymentData['buyer_id']   = $googleOrderData[1]['new-order-notification']['order-summary']['buyer-id']['VALUE'];
				$paymentData['purchase_date']   = $googleOrderData[1]['new-order-notification']['order-summary']['purchase-date']['VALUE'];
				$paymentData['timestamp']    	= $googleOrderData[1]['new-order-notification']['timestamp']['VALUE'];
				$paymentData['google_order_number']    	= $googleOrderData[1]['new-order-notification']['order-summary']['google-order-number']['VALUE'];
				
				$datagoogle=$databaseObj->sqlinsert("select * FROM  orders WHERE  google_order_number='".$paymentData['google_order_number']."'");
				$number_of_record=$databaseObj->mysql_number($datagoogle);
				//echo  $product=count($paymentData['shopping-cart']);
				//print_r($paymentData['shopping-cart']);
				 if($number_of_record==0)	
				{
						$databaseObj->sqlinsert("insert into orders set 
											user_id										='".$paymentData['seller_user_id']."' ,
											seller_user_id						='".$paymentData['sell_item_buyer_id']."' ,
											google_order_number				='".$paymentData['google_order_number']."',
											card_info_id							='0' ,
											user_shipping_address_id	='0',
											user_billing_address_id		='0' ,
											amount										='".$paymentData['order_total']."',
											shipping_handling					='".$paymentData['shipping_handling']."',
											shipping_name							='".$paymentData['shipping_name']."',
											created 									='".$paymentData['created']."'
										"); 
						$last_order_id=mysql_insert_id();
						$databaseObj->sqlinsert("insert into google_eaddresses
																							set 
																								user_id								='".$paymentData['sell_item_buyer_id']."' ,
																								order_id							='".$last_order_id."',
																								contact_name					='".$paymentData['contact_name']."',
																								company_name					='".$paymentData['company_name']."',
																								address1							='".$paymentData['address1']."',
																								address2							='".$paymentData['address2']."',
																								email									='".$paymentData['email']."',
																								phone									='".$paymentData['phone']."',
																								fax										='".$paymentData['fax']."',
																								country_code					='".$paymentData['country_code']."',
																								city									='".$paymentData['city']."',
																								region								='".$paymentData['region']."',
																								postal_code						='".$paymentData['postal_code']."',
																								contact_name_shipping	='".$paymentData['contact_name_shipping']."',
																								company_name_shipping	='".$paymentData['company_name_shipping']."',
																								address1_shipping			='".$paymentData['address1_shipping']."'	,
																								address2_shipping			='".$paymentData['address2_shipping']."',
																								email_shipping				='".$paymentData['email_shipping']."',
																								phone_shipping				='".$paymentData['phone_shipping']."',
																								fax_shipping					='".$paymentData['fax_shipping']."',
																								country_code_shipping	='".$paymentData['country_code_shipping']."',
																								city_shipping					='".$paymentData['city_shipping']."',
																								region_shipping				='".$paymentData['region_shipping']."',
																								postal_code_shipping	='".$paymentData['postal_code_shipping']."',
																								buyer_id							='".$paymentData['buyer_id']."',
																								purchase_date					='".$paymentData['purchase_date']."',
																								timestamp							='".$paymentData['timestamp']."'
						");
						if(isset($paymentData['shopping-cart']['item-name']))
						{
								$databaseObj->sqlinsert("insert into order_items set 
														order_id 			='".$last_order_id."',
														sell_item_id 	='".$paymentData['shopping-cart']['merchant-item-id']['VALUE']."',
														item_amount 	='".$paymentData['shopping-cart']['unit-price']['VALUE']."',
														quantity 			='".$paymentData['shopping-cart']['quantity']['VALUE']."'
								");
								
						}else{
							foreach($dataRes['shopping-cart']['items']['item'] as $key=>$orderArr){
								$orderItemArr['Order'][$i]['product_id'] 		= $orderArr['merchant-item-id']['VALUE'];
								$orderItemArr['Order'][$i]['item_name'] 		= $orderArr['item-name']['VALUE'];
								$orderItemArr['Order'][$i]['sku'] 				= $orderArr['merchant-private-item-data']['VALUE'];
								$orderItemArr['Order'][$i]['quantity'] 			= $orderArr['quantity']['VALUE'];
								$orderItemArr['Order'][$i]['price'] 			= $orderArr['unit-price']['VALUE'];
								$i++;
							}	
						
						}
					} 
					
			
				
			/* */
					
  /*$status = $Gresponse->HttpAuthentication();
  if(! $status) {
    die('authentication failed');
  }*/

  /* Commands to send the various order processing APIs
   * Send charge order : $Grequest->SendChargeOrder($data[$root]
   *    ['google-order-number']['VALUE'], <amount>);
   * Send process order : $Grequest->SendProcessOrder($data[$root]
   *    ['google-order-number']['VALUE']);
   * Send deliver order: $Grequest->SendDeliverOrder($data[$root]
   *    ['google-order-number']['VALUE'], <carrier>, <tracking-number>,
   *    <send_mail>);
   * Send archive order: $Grequest->SendArchiveOrder($data[$root]
   *    ['google-order-number']['VALUE']);
   *
   */

  switch ($root) {
    case "request-received": {
      break;
    }
    case "error": {
      break;
    }
    case "diagnosis": {
      break;
    }
    case "checkout-redirect": {
      break;
    }
    case "merchant-calculation-callback": {
      // Create the results and send it
      $merchant_calc = new GoogleMerchantCalculations($currency);

      // Loop through the list of address ids from the callback
      $addresses = get_arr_result($data[$root]['calculate']['addresses']['anonymous-address']);
      foreach($addresses as $curr_address) {
        $curr_id = $curr_address['id'];
        $country = $curr_address['country-code']['VALUE'];
        $city = $curr_address['city']['VALUE'];
        $region = $curr_address['region']['VALUE'];
        $postal_code = $curr_address['postal-code']['VALUE'];

        // Loop through each shipping method if merchant-calculated shipping
        // support is to be provided
        if(isset($data[$root]['calculate']['shipping'])) {
          $shipping = get_arr_result($data[$root]['calculate']['shipping']['method']);
          foreach($shipping as $curr_ship) {
            $name = $curr_ship['name'];
            //Compute the price for this shipping method and address id
            $price = 12; // Modify this to get the actual price
            $shippable = "true"; // Modify this as required
            $merchant_result = new GoogleResult($curr_id);
            $merchant_result->SetShippingDetails($name, $price, $shippable);

            if($data[$root]['calculate']['tax']['VALUE'] == "true") {
              //Compute tax for this address id and shipping type
              $amount = 15; // Modify this to the actual tax value
              $merchant_result->SetTaxDetails($amount);
            }

            if(isset($data[$root]['calculate']['merchant-code-strings']
                ['merchant-code-string'])) {
              $codes = get_arr_result($data[$root]['calculate']['merchant-code-strings']
                  ['merchant-code-string']);
              foreach($codes as $curr_code) {
                //Update this data as required to set whether the coupon is valid, the code and the amount
                $coupons = new GoogleGiftcerts("true", $curr_code['code'], 10, "debugtest");
                $merchant_result->AddGiftCertificates($coupons);
              }
             }
             $merchant_calc->AddResult($merchant_result);
          }
        } else {
          $merchant_result = new GoogleResult($curr_id);
          if($data[$root]['calculate']['tax']['VALUE'] == "true") {
            //Compute tax for this address id and shipping type
            $amount = 15; // Modify this to the actual tax value
            $merchant_result->SetTaxDetails($amount);
          }
          $codes = get_arr_result($data[$root]['calculate']['merchant-code-strings']
              ['merchant-code-string']);
          foreach($codes as $curr_code) {
            //Update this data as required to set whether the coupon is valid, the code and the amount
            $coupons = new GoogleGiftcerts("true", $curr_code['code'], 10, "debugtest");
            $merchant_result->AddGiftCertificates($coupons);
          }
          $merchant_calc->AddResult($merchant_result);
        }
      }
      $Gresponse->ProcessMerchantCalculations($merchant_calc);
      break;
    }
    case "new-order-notification": {
      $Gresponse->SendAck();
      break;
    }
    case "order-state-change-notification": {
      $Gresponse->SendAck();
      $new_financial_state = $data[$root]['new-financial-order-state']['VALUE'];
      $new_fulfillment_order = $data[$root]['new-fulfillment-order-state']['VALUE'];

      switch($new_financial_state) {
        case 'REVIEWING': {
          break;
        }
        case 'CHARGEABLE': {
          //$Grequest->SendProcessOrder($data[$root]['google-order-number']['VALUE']);
          //$Grequest->SendChargeOrder($data[$root]['google-order-number']['VALUE'],'');
          break;
        }
        case 'CHARGING': {
          break;
        }
        case 'CHARGED': {
          break;
        }
        case 'PAYMENT_DECLINED': {
          break;
        }
        case 'CANCELLED': {
          break;
        }
        case 'CANCELLED_BY_GOOGLE': {
          //$Grequest->SendBuyerMessage($data[$root]['google-order-number']['VALUE'],
          //    "Sorry, your order is cancelled by Google", true);
          break;
        }
        default:
          break;
      }

      switch($new_fulfillment_order) {
        case 'NEW': {
          break;
        }
        case 'PROCESSING': {
          break;
        }
        case 'DELIVERED': {
          break;
        }
        case 'WILL_NOT_DELIVER': {
          break;
        }
        default:
          break;
      }
      break;
    }
    case "charge-amount-notification": {
      //$Grequest->SendDeliverOrder($data[$root]['google-order-number']['VALUE'],
      //    <carrier>, <tracking-number>, <send-email>);
      //$Grequest->SendArchiveOrder($data[$root]['google-order-number']['VALUE'] );
      $Gresponse->SendAck();
      break;
    }
    case "chargeback-amount-notification": {
      $Gresponse->SendAck();
      break;
    }
    case "refund-amount-notification": {
      $Gresponse->SendAck();
      break;
    }
    case "risk-information-notification": {
      $Gresponse->SendAck();
      break;
    }
    default:
      $Gresponse->SendBadRequestStatus("Invalid or not supported Message");
      break;
  }
  /* In case the XML API contains multiple open tags
     with the same value, then invoke this function and
     perform a foreach on the resultant array.
     This takes care of cases when there is only one unique tag
     or multiple tags.
     Examples of this are "anonymous-address", "merchant-code-string"
     from the merchant-calculations-callback API
  */
  function get_arr_result($child_node) {
    $result = array();
    if(isset($child_node)) {
      if(is_associative_array($child_node)) {
        $result[] = $child_node;
      }
      else {
        foreach($child_node as $curr_node){
          $result[] = $curr_node;
        }
      }
    }
    return $result;
  }

  /* Returns true if a given variable represents an associative array */
  function is_associative_array( $var ) {
    return is_array( $var ) && !is_numeric( implode( '', array_keys( $var ) ) );
  }
?>
