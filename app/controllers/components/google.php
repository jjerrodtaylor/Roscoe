<?php
	class GoogleComponent extends Object
	{
		var $mode = 'development'; //production or development
		var $controller;
		var $merchant_id;
		var $merchant_key;
		var $server_type;
		var $currency;
		function initialize() {	
			if($this->mode=='production'){
				$this->merchant_id = "721366974969602";
				$this->merchant_key = "_Q2u6m2AjJDfekSJ1BgktQ";
				$this->server_type = "checkout";
				$this->currency = "USD";
				
			}else{
				$this->merchant_id = "721366974969602"; 
				$this->merchant_key = "_Q2u6m2AjJDfekSJ1BgktQ"; 
				$this->server_type = "sandbox";
				$this->currency = "USD";
				
			}
		}
		function CartContents($dataArr = null,$Discount_Product_shipping = null,$shipping_information = Null)	{
			//pr($dataArr);
			//die();
			$this->initialize();
			return $this->startup($dataArr,$Discount_Product_shipping,$shipping_information);
		}
		function startup($dataArr = null ,$Discount_Product_shipping = null ,$shipping_information =  Null){
			
			App::import('Vendor', 'googlecheckout/library/googlecart');
			App::import('Vendor', 'googlecheckout/library/googleitem');
			App::import('Vendor', 'googlecheckout/library/googleshipping');
			App::import('Vendor', 'googlecheckout/library/googletax');
			$cart = new GoogleCart($this->merchant_id, $this->merchant_key, $this->server_type,$this->currency);
			$total_count = 0;
			foreach($dataArr as $key=>$datavalue){
				$item_1 = new GoogleItem($datavalue['sell_item_name'],      // Item name
                               $datavalue['sell_item_description'], // Item      description
                               $datavalue['quantity'], // Quantity
                               $datavalue['price']); // Unit price
				
				$item_1->SetMerchantItemId($datavalue['sell_item_id']);
				$item_1->SetMerchantPrivateItemData($datavalue['product_id']);
				$cart->AddItem($item_1);
			}
			$cart->SetMerchantPrivateData('buyer_user_id-'.$dataArr[0]['sell_item_buyler_id'].'-seller_user_id-'.$dataArr[0]['seller_user_id']);
     /*  if($total_count < 3){
             $ship_1 = new GoogleFlatRateShipping("USPS Priority Mail", 0);
      }else{
             $ship_1 = new GoogleFlatRateShipping("USPS Priority Mail", 0);
      } */
			//echo $shipping_information;
			//die();
			$ship_1 = new GoogleFlatRateShipping("'.$shipping_information.'",$Discount_Product_shipping);
			$Gfilter = new GoogleShippingFilters();
      $Gfilter->SetAllowedCountryArea('CONTINENTAL_48');
      $ship_1->AddShippingRestrictions($Gfilter);
      $cart->AddShipping($ship_1);
      // Add tax rules
      $tax_rule = new GoogleDefaultTaxRule(0.05);
      $tax_rule->SetStateAreas(array("MA"));
      $cart->AddDefaultTaxRules($tax_rule);
      // Specify <edit-cart-url>
      $cart->SetEditCartUrl(SITE_URL."/orders/cart/");
      // Specify "Return to xyz" link
      $cart->SetContinueShoppingUrl(SITE_URL."/orders/successful");
      // Request buyer's phone number
      $cart->SetRequestBuyerPhone(true);
      // Display Google Checkout button
      echo $cart->CheckoutButtonCode("SMALL");
			// Display XML data
     //echo "<pre>";
     //echo htmlentities($cart->GetXML());
     //echo "</pre>";
		}
		
		function Response(){
			chdir("..");
			App::import('Vendor', 'googlecheckout/library/googleresponse');
			App::import('Vendor', 'googlecheckout/library/googlemerchantcalculations');
			App::import('Vendor', 'googlecheckout/library/googlerequest');
			App::import('Vendor', 'googlecheckout/library/googlenotificationhistory');
			define('RESPONSE_HANDLER_ERROR_LOG_FILE', 'googlecheckout/googleerror.log');
			define('RESPONSE_HANDLER_LOG_FILE', 'googlecheckout/googlemessage.log');

			//Definitions
			$merchant_id = "721366974969602";  // Your Merchant ID
			$merchant_key = "_Q2u6m2AjJDfekSJ1BgktQ";  // Your Merchant Key
			$server_type = "sandbox";  // change this to go live
			$currency = 'USD';  // set to GBP if in the UK

			//Create the response object
			$Gresponse = new GoogleResponse($merchant_id, $merchant_key);

			//Setup the log file
			$Gresponse->SetLogFiles('', '', L_OFF);  //Change this to L_ON to log

			//Retrieve the XML sent in the HTTP POST request to the ResponseHandler
			$xml_response = isset($HTTP_RAW_POST_DATA)?
			$HTTP_RAW_POST_DATA:file_get_contents("php://input");

			//If serial-number-notification pull serial number and request xml


			if(strpos($xml_response, "xml") == FALSE){

				//Find serial-number ack notification
				$serial_array = array();
				parse_str($xml_response, $serial_array);

				$serial_number = $serial_array["serial-number"];

				//Request XML notification
				$Grequest = new GoogleNotificationHistoryRequest($merchant_id, $merchant_key, $server_type);
				$raw_xml_array = $Grequest->SendNotificationHistoryRequest($serial_number);
				if ($raw_xml_array[0] != 200){
					//Add code here to retry with exponential backoff
				} else {
					$raw_xml = $raw_xml_array[1];
				}

				$Gresponse->SendAck($serial_number, false);
			}else{

				//Else assume pre 2.5 XML notification
				//Check Basic Authentication
				$Gresponse->SetMerchantAuthentication($merchant_id, $merchant_key);
				$status = $Gresponse->HttpAuthentication();
				if(! $status) {
					die('authentication failed');
				}
				$raw_xml = $xml_response;
				//$Gresponse->SendAck(null, false);
			}

			if (get_magic_quotes_gpc()) {
				$raw_xml = stripslashes($raw_xml);
			}

			//Parse XML to array
			list($root, $data) = $Gresponse->GetParsedXML($raw_xml);
			
			/**********************Updated part************************************/

			$serial_number =  $data[$root]['serial-number'];	
			$Gresponse->SendAck($serial_number, false);
			/**********************************************************/

			switch($root){
				case "new-order-notification": {
					$this->GoogleUpdateOrders($data[$root]);
					break;
				}
				case "risk-information-notification": {
					break;
				}
				case "charge-amount-notification": {
					break;
				}
				case "authorization-amount-notification": {
					$google_order_number = $data[$root]['google-order-number']['VALUE'];
					$tracking_data = array("Z12345" => "UPS", "Y12345" => "Fedex");
					$GChargeRequest = new GoogleRequest($merchant_id, $merchant_key, $server_type);
					$GChargeRequest->SendChargeAndShipOrder($google_order_number, $tracking_data);
					break;
				}
				case "refund-amount-notification": {
					break;
				}
				case "chargeback-amount-notification": {
					break;
				}
				case "order-numbers": {
					break;
				}
				case "invalid-order-numbers": {
					break;
				}
				case "order-state-cahnge-notification": {
					break;
				}
				default: {
					break;
				}
			}	
		}
		function GoogleUpdateOrders($dataRes = null){
				//print_r($dataRes);
				//die();
				/*****************************Extracting data Order Table*************************
				*******************************************************************************/
		$i = 0;
		$orderItemArr=array();
		$paymentData1['merchant_private_data']					=$dataRes['order-summary']['shopping-cart']['merchant-private-data']['VALUE'];
		$str																						=$paymentData1['merchant_private_data'];
		$arr = explode('-',$str);
		$paymentData['Order']['seller_user_id'] 				= 			$arr[3];
		$paymentData['Order']['user_id'] 								= 			$arr[1];
		$paymentData['Order']['created'] 								= 			date('Y-m-d H:i:s');
		$paymentData['Order']['google_order_number']    = 			$dataRes['order-summary']['google-order-number']['VALUE'];
		$paymentData['Order']['amount']  								= 			$dataRes['order-total']['VALUE'];
		$paymentData['Order']['shipping_name']  				= 			$dataRes['order-adjustment']['shipping']['flat-rate-shipping-adjustment']['shipping-name']['VALUE'];
		$paymentData['Order']['shipping_handling']  		= 			$dataRes['order-adjustment']['shipping']['flat-rate-shipping-adjustment']['shipping-cost']['VALUE'];
		$paymentData['Order']['card_info_id']    				= 			'0';
		$paymentData['Order']['user_shipping_address_id']= 			'0';
		$paymentData['Order']['user_billing_address_id'] 	= 	  '0';
		$paymentData['Order']['payment_type'] 						= 	  'googlecheckout';
		$paymentData['Order']['feeback_buyer_to_seller'] 	= 	  '0';
		$paymentData['Order']['feedback_seller_to_buyer'] = 	'0';
		
		
		
		/*****************************Extracting data Order Item Table*************************
		*******************************************************************************/
		if(isset($dataRes['shopping-cart']['items']['item']['item-name']))
		{
			$arrReference = $dataRes['shopping-cart']['items']['item'];
			$paymentData['OrderItem'][$i]['order_id'] 				= $this->controller->Order->id;
			$paymentData['OrderItem'][$i]['sell_item_id'] 		= $arrReference['merchant-item-id']['VALUE'];
			$paymentData['OrderItem'][$i]['product_id'] 			= $arrReference['merchant-private-item-data']['VALUE'];
			$paymentData['OrderItem'][$i]['item_amount'] 			= $arrReference['unit-price']['VALUE'];
			$paymentData['OrderItem'][$i]['quantity'] 				= $arrReference['quantity']['VALUE'];

		}
		else
		{
			foreach($dataRes['shopping-cart']['items']['item'] as $key=>$orderArr){
				$paymentData['OrderItem'][$i]['order_id'] 				= $this->controller->Order->id;
				$paymentData['OrderItem'][$i]['sell_item_id'] 		= $orderArr['merchant-item-id']['VALUE'];
				$paymentData['OrderItem'][$i]['product_id'] 			= $orderArr['merchant-private-item-data']['VALUE'];
				$paymentData['OrderItem'][$i]['item_amount'] 			= $orderArr['unit-price']['VALUE'];
				$paymentData['OrderItem'][$i]['quantity'] 				= $orderArr['quantity']['VALUE'];
				$i++;
			}
		}	
		/*************************** Order tabale data reord save*******************************************/
		$this->controller->Order->save($paymentData['Order'],false);
		$paymentData['Order']['id'] = $this->controller->Order->id;
		//print_r($paymentData['Order']);
		//die();
		
		/************OrderItem ****************************************************************************/
		foreach($paymentData['OrderItem'] as $key=>$value){
			$paymentData['OrderItem'][$key]['order_id'] = $paymentData['Order']['id'];	
			$sellItemIdArr[]  = $value['sell_item_id'];
		}
		$this->controller->OrderItem->saveAll($paymentData['OrderItem'],false);	
		/*****************************Extracting data GoogleAddressOrder table*************************
		*******************************************************************************/
		$paymentData['GoogleAddress']['order_id']  								= 			$paymentData['Order']['id'];
		$paymentData['GoogleAddress']['contact_name']							=				$dataRes['buyer-billing-address']['contact-name']['VALUE'];
		$paymentData['GoogleAddress']['company_name']							=				$dataRes['buyer-billing-address']['company-name']['VALUE'];
		$paymentData['GoogleAddress']['address1']									=				$dataRes['buyer-billing-address']['address1']['VALUE'];
		$paymentData['GoogleAddress']['address2']									=				$dataRes['buyer-billing-address']['address2']['VALUE'];
		$paymentData['GoogleAddress']['email']										=				$dataRes['buyer-billing-address']['email']['VALUE'];
		$paymentData['GoogleAddress']['phone']										=				$dataRes['buyer-billing-address']['phone']['VALUE'];
		$paymentData['GoogleAddress']['fax']											=				$dataRes['buyer-billing-address']['fax']['VALUE'];
		$paymentData['GoogleAddress']['country_code']							=				$dataRes['buyer-billing-address']['country-code']['VALUE'];
		$paymentData['GoogleAddress']['city']											=				$dataRes['buyer-billing-address']['city']['VALUE'];
		$paymentData['GoogleAddress']['region']										=				$dataRes['buyer-billing-address']['region']['VALUE'];
		$paymentData['GoogleAddress']['postal_code']							=				$dataRes['buyer-billing-address']['postal-code']['VALUE'];
		
		$paymentData['GoogleAddress']['contact_name_shipping'] 		= 			$dataRes['buyer-shipping-address']['contact-name']['VALUE'];
		$paymentData['GoogleAddress']['company_name_shipping'] 		= 			$dataRes['buyer-shipping-address']['company-name']['VALUE'];
		$paymentData['GoogleAddress']['address1_shipping']     		= 			$dataRes['buyer-shipping-address']['address1']['VALUE'];
		$paymentData['GoogleAddress']['address2_shipping']     		= 			$dataRes['buyer-shipping-address']['address2']['VALUE'];
		$paymentData['GoogleAddress']['email_shipping']       		= 			$dataRes['buyer-shipping-address']['email']['VALUE'];
		$paymentData['GoogleAddress']['phone_shipping']        		= 			$dataRes['buyer-shipping-address']['phone']['VALUE'];
		$paymentData['GoogleAddress']['fax_shipping'] 						= 			$dataRes['buyer-shipping-address']['fax']['VALUE'];
		$paymentData['GoogleAddress']['country_code_shipping']  	= 			$dataRes['buyer-shipping-address']['country-code']['VALUE'];
		$paymentData['GoogleAddress']['city_shipping']       			= 			$dataRes['buyer-shipping-address']['city']['VALUE'];
		$paymentData['GoogleAddress']['region_shipping']  				= 			$dataRes['buyer-shipping-address']['region']['VALUE'];
		$paymentData['GoogleAddress']['postal_code_shipping']  		= 			$dataRes['buyer-shipping-address']['postal-code']['VALUE'];
		$paymentData['GoogleAddress']['timestamp']								=				$dataRes['timestamp']['VALUE'];
		$this->controller->GoogleAddress->save($paymentData['GoogleAddress']);	
		
		$this->controller->CustomerBasket->deleteAll(array('CustomerBasket.sell_item_id'=>$sellItemIdArr,'CustomerBasket.buyer_user_id'=>$arr[1]));
		}
	}