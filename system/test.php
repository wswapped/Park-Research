<?php
	//intouch posts data here for transaction request status
	if($_POST['requesttransactionid']){
		$status = $_POST['status'];

		$transactionId = $_POST['transactionid'];


		$conn->query("UPDATE transactions SET status = \"$status\" WHERE transId = \"$transactionid\" ");

		$ret = array();
		echo json_encode();
	}

?>