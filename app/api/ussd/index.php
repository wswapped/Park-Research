<?php
// Reads the variables sent via POST from our gateway
$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];
if ( $text == "" ) {
		// This is the first request. Note how we start the response with CON
		$response  = "CON DOA Hitamo ibyo ushaka gutanda \n";
		$response .= "1. Umutungo \n";
		$response .= "2. Uburere \n";
		$response .= "3. Ubuziranenge \n";
		$response .= "4. Kwivuza \n";
		$response .= "5. Umuryango";
}
else if ( $text == "1" ) {
	// Business logic for first level response
	$response = "CON Choose account information you want to view \n";
	$response .= "1. Yego \n";
	$response .= "2. Hoya";
	
 }
 else if($text == "2") {
	// Business logic for first level response
	// This is a terminal request. Note how we start the response with END
	$response = "END Your phone number is $phoneNumber";
 }
 else if($text == "1*1") {
	// This is a second level response where the user selected 1 in the first instance
	$accountNumber  = "ACC1001";
	// This is a terminal request. Note how we start the response with END
	$response = "END Your account number is $accountNumber";
 }
		
 else if ( $text == "1*2" ) {
	
		 // This is a second level response where the user selected 1 in the first instance
		 $balance  = "RWF 10,000";
		 // This is a terminal request. Note how we start the response with END
		 $response = "END Your balance is $balance";
}
// Print the response onto the page so that our gateway can read it
header('Content-type: text/plain');
echo $response;
// DONE!!!
?>
