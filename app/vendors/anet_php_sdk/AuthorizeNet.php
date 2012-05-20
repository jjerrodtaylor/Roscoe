<?php
require dirname(__FILE__) . '/lib/AuthnetCIM.class.php';

try
{
    // Create AuthnetCIM object. Set third parameter to "true" for developer account
    // or use the built in constant USE_DEVELOPMENT_SERVER for better readability.
    $cim = new AuthnetCIM('8v4Y9y7LG', '34T4c83mDhG2LsS3', 
                                               AuthnetCIM::USE_DEVELOPMENT_SERVER);
		// Step 1: create Customer Profile
    //
    // Create unique fake email address, description, and customer ID
    $email_address = 'user' . time() . '@domain.com';
    $description   = 'Monthly Membership No. ' . md5(uniqid(rand(), true));
    $customer_id   = substr(md5(uniqid(rand(), true)), 16, 16);
		// Create the profile
    $cim->setParameter('email', $email_address);
    $cim->setParameter('description', $description);
    $cim->setParameter('merchantCustomerId', $customer_id);
    $cim->createCustomerProfile();
		// Get the profile ID returned from the request
    if ($cim->isSuccessful())
    {
        $profile_id = $cim->getProfileID();
    }
 
    // Print the results of the request
    echo '<b>createCustomerProfileRequest Response Summary:</b> ' . 
                                          $cim->getResponseSummary() . '<br />';
    echo '<b>Profile ID:</b> ' . $profile_id . '<br /><br />';
 
    // Step 2: create Payment Profile
    //
    // Create fake user billing information
    $b_first_name   = 'John';
    $b_last_name    = 'Conde';
    $b_address      = '123 Main Street';
    $b_city         = 'Townsville';
    $b_state        = 'NJ';
    $b_zip          = '12345';
    $b_country      = 'US';
    $b_phone_number = '800-555-1234';
    $b_fax_number   = '800-555-2345';
    $credit_card    = '4111111111111111';
    $expiration     = (date("Y") + 1) . '-12';
 
    // Create the Payment Profile
    $cim->setParameter('customerProfileId', $profile_id);
    $cim->setParameter('billToFirstName', $b_first_name);
    $cim->setParameter('billToLastName', $b_last_name);
    $cim->setParameter('billToAddress', $b_address);
    $cim->setParameter('billToCity', $b_city);
    $cim->setParameter('billToState', $b_state);
    $cim->setParameter('billToZip', $b_zip);
    $cim->setParameter('billToCountry', $b_country);
    $cim->setParameter('billToPhoneNumber', $b_phone_number);
    $cim->setParameter('billToFaxNumber', $b_fax_number);
    $cim->setParameter('cardNumber', $credit_card);
    $cim->setParameter('expirationDate', $expiration);
    $cim->createCustomerPaymentProfile();
 
    // Get the payment profile ID returned from the request
    if ($cim->isSuccessful())
    {
        $payment_profile_id = $cim->getPaymentProfileId();
    }
 
    // Print the results of the request
    echo '<b>createCustomerPaymentProfileRequest Response Summary:</b> ' . 
                                              $cim->getResponseSummary() . '<br />';
    echo '<b>Payment Profile ID:</b> ' . $payment_profile_id . '<br /><br />';
 
 
    // Step 3: create Shipping Profile
    //
    // Create fake user shipping information
    $s_first_name   = 'John';
    $s_last_name    = 'Conde';
    $s_address      = '1001 Other Road';
    $s_city         = 'Townsville';
    $s_state        = 'NJ';
    $s_zip          = '12345';
    $s_country      = 'US';
    $s_phone_number = '800-555-3456';
    $s_fax_number   = '800-555-4567';
 
    // Create the shipping profile
    $cim->setParameter('customerProfileId', $profile_id);
    $cim->setParameter('shipToFirstName', $s_first_name);
    $cim->setParameter('shipToLastName', $s_last_name);
    $cim->setParameter('shipToAddress', $s_address);
    $cim->setParameter('shipToCity', $s_city);
    $cim->setParameter('shipToState', $s_state);
    $cim->setParameter('shipToZip', $s_zip);
    $cim->setParameter('shipToCountry', $s_country);
    $cim->setParameter('shipToPhoneNumber', $s_phone_number);
    $cim->setParameter('shipToFaxNumber', $s_fax_number);
    $cim->createCustomerShippingAddress();
 
    // Get the payment profile ID returned from the request
    if ($cim->isSuccessful())
    {
        $shipping_profile_id = $cim->getCustomerAddressId();
    }
 
    // Print the results of the request
    echo '<b>createCustomerShippingAddressRequest Response Summary:</b> ' . 
                                               $cim->getResponseSummary() . '<br />';
    echo '<b>Shipping Profile ID:</b> ' . $shipping_profile_id . '<br /><br />';
 
 
    // Step 4: Process a transaction
    //
    // Create fake transaction information
    $purchase_amount = '5.00';
 
    // Process the transaction
    $cim->setParameter('amount', $purchase_amount);
    $cim->setParameter('customerProfileId', $profile_id);
    $cim->setParameter('customerPaymentProfileId', $payment_profile_id);
    $cim->setParameter('customerShippingAddressId', $shipping_profile_id);
    $cim->setParameter('cardCode', '123');
    $cim->setLineItem('12', 'test item', 'it lets you test stuff', '1', '1.00');
		
    $cim->createCustomerProfileTransaction();
 
    // Get the payment profile ID returned from the request
    if ($cim->isSuccessful())
    {
        $approval_code = $cim->getAuthCode();
    }
 
    // Print the results of the request
    echo '<b>createCustomerProfileTransactionRequest Response Summary:</b> ' . 
                               $cim->getResponseSummary() . '<br />';
    echo '<b>Approval code:</b> ' . $approval_code;
}
	catch (AuthnetCIMException $e)
	{
			echo $e;
			echo $cim;
	}
?>