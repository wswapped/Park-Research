<?php
include("../db.php");
//Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0)
{
    
	
	//Not a post
	$sql = $outCon->query("INSERT INTO intouchResponses(statusdesc,statusStatus) 
	VALUES ('Not a post','not_seen')")or die(mysqli_error($outCon));
	echo 'Not a post';
}
else
{
	//Make sure that the content type of the POST request has been set to application/json
	$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
	if(strcasecmp($contentType, 'application/json') != 0)
	{
    	//content type wasent json
		$sql = $outCon->query("INSERT INTO intouchResponses(statusdesc,statusStatus) 
		VALUES ('Content type wasent json','not_seen')")or die(mysqli_error($outCon));
		echo 'content type wasent json';

	}
	else
	{
		
		//Receive the RAW post data.
		$content = trim(file_get_contents("php://input"));
		 
		//Attempt to decode the incoming RAW post data from JSON.
		$decoded = json_decode($content, true);
		 
		//If json_decode failed, the JSON is invalid.
		if(is_array($decoded))
		{
			if (empty($decoded)) {
			     // decoded is empty.
				$sql = $outCon->query("INSERT INTO intouchResponses(statusdesc,statusStatus) 
				VALUES ('Decoded is empty','not_seen')")or die(mysqli_error($outCon));
				echo 'Decoded is empty';
			}
			else
			{
				foreach($decoded as $key => $value)
				{
				  	$requesttransactionid	= $value['requesttransactionid'];
					$transactionid			= $value['transactionid'];
					$responsecode			= $value['responsecode'];
					$status					= $value['status'];
					$statusdesc				= $value['statusdesc'];
					$referenceno			= $value['referenceno'];

					// Everything was fine

					$sql = $outCon->query("INSERT INTO intouchResponses(
						requesttransactionid, transactionid, responsecode,
						status, statusdesc, referenceno,
						 statusStatus) 
						VALUES (
						'$requesttransactionid', '$transactionid', '$responsecode',
						'$status', '$statusdesc', '$referenceno',
						'not_seen')")or die(mysqli_error($outCon));
					
					if($outCon){
						if (!isset($returnedinformation)) $returnedinformation = new stdClass();

						$returnedinformation->message = "success";
						$returnedinformation->success = True;
						$returnedinformation->request_id = "$requesttransactionid";


						$returnedinformation = json_encode($returnedinformation);
						header('Content-Type: application/json');
						echo $returnedinformation;
					}
					else
					{
						if (!isset($returnedinformation)) $returnedinformation = new stdClass();
						
						$returnedinformation->message = "fail";
						$returnedinformation->success = false;
						$returnedinformation->request_id = "$requesttransactionid";


						$returnedinformation = json_encode($returnedinformation);
						header('Content-Type: application/json');
						echo $returnedinformation;
					}
				}
				
			}
			

		    
		}
		else
		{
			//Received content contained invalid JSON!
			$sql = $outCon->query("INSERT INTO intouchResponses(statusdesc,statusStatus) 
			VALUES ('Received content contained invalid JSON!','not_seen')")or die(mysqli_error($outCon));
			echo 'Received content contained invalid JSON!';
		}
	}
}

?>
