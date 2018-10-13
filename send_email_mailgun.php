<?php
/* mailgun setting */

    /*---------   (1) live   -------*/
	$service_url = 'https://api.mailgun.net/v3/realcustomerapp.com/messages'; // v3/register domain/messages
	$from ='RealCustomer<support@realcustomerapp.com>'; //name@register domain
	$api_key="api:key-b0a688966f1505b4ff98960de4cfd8c7"; //api key set here


	/*---------    (2) dev a/c for testing   -------*/
	// $service_url = 'https://api.mailgun.net/v3/sandboxa0084931db164126a01609854beceea9.mailgun.org/messages';
	// $from ='Mailgun Sandbox <postmaster@sandboxa0084931db164126a01609854beceea9.mailgun.org>'; 
	// $api_key="api:key-c8800c200311acb8a0edfb4fc287a54b";

/* end mailgun setting*/

$to=isset($_POST['to'])?$_POST['to']:'';
$subject=isset($_POST['subject'])?$_POST['subject']:'';
$text=(isset($_POST['msg']))?$_POST['msg']:'';


if(empty($to) || empty($subject) || empty($text) ){

	   $response=array("status"=>0,"msg"=>"please provide required fields.");
	   echo json_encode($response); 
       exit();
	
}else
{

		$headers = array( 
		'Content-Type: multipart/form-data' 

		);

																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																								
		$curl_post_data=array(
		    'from'    => $from,
		    'to'      => $to,
		    'subject' => $subject,
		    'text'    => $text
		);

   
		//$service_url = 'https://api.mailgun.net/v3/sandboxa0084931db164126a01609854beceea9.mailgun.org/messages';
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD,$api_key); 

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);  // set header type
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 


		$curl_response = curl_exec($curl);  
		$response = json_decode($curl_response);
		curl_close($curl);
		$response=array("status"=>1,"msg"=>"Email Sent.","data"=>$response);
	    echo json_encode($response); 
        exit();
 }
//echo "<pre>"; print_r($response); exit();

// 192.168.0.151/RealCustomer/api/send_email_mailgun.php.
// Req:
// to
// subject
// msg



//Response
// {
//     "status": 1,
//     "msg": "Email Sent.",
//     "data": {
//         "id": "<20171101071019.45891.9586ED894B5B312E@sandboxa0084931db164126a01609854beceea9.mailgun.org>",
//         "message": "Queued. Thank you."
//     }
// }

//  {
//     "status": 0,
//     "msg": "please provide required fields."
// }
?>