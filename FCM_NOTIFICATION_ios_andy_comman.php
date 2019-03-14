<?php
/**
SEND FCM NOTIFICATION FOR BOTH IOS/ANDROID DEVICES


First
-----------
change the file name to Fcm.php
make Services folder in app directory
put Fcm.php in this directory 

FOR MOBILE DEVELOPER
-----------------------
create Project in FCM
make app for android in this project
make app for ios in same project
give to php developer FCM API KEY
php developer use this key 


code from controller side for call to Fcm services
---------------------------
use App\Services\Fcm;
class BidController extends Controller
{
    
    public function __construct(SMS $sms_service,Fcm $fcm)
    {
        $this->sms = $sms_service;
        $this->fcm = $fcm;
    }
    public function sendBidTimeAlerts()
    {

     $responce[] = $this->fcm->send(1,[$value->gcm_id],'Bid time will over in next 15 minutes.',$value->device);
        
     }
 }



 * Created by PhpStorm.
 * User: Rashmi Dholakiya
 * Date: 2/6/17
 * Time: 6:32 PM
 */

 
/*
make Services folder in app directory

*/
namespace App\Services;


class Fcm
{
    protected $api_key;

    protected $ios_certificate;

    protected $path;

    public function __construct()
    {
        /*Write here your FCM API KEY */
        //AAAAmvEGaJw:APA91bGNdvbgg4Cq87WubXtstQz5tiZiWEixVgLV0lws4l96w3pZ4AsppV2zS9rj0ZP1-WBa6YD9iphkozYZqOedEcq-BdYpzklaunfEr_jbq5z_pUNXogqHizd25dJuuzV7UlUaOxhD
        $this->api_key          = config('constants.fcm_api_key');
        $this->ios_certificate  = config('constants.ios_certi_path'); //no need bcoz send push for ios/andy by FCM
        $this->path             = "https://fcm.googleapis.com/fcm/send"; //keep it same
    }

    public function ios($arrayToSend)
    {
        $json       = json_encode($arrayToSend);
        $headers    = array();
        $headers[]  = 'Content-Type: application/json';
        $headers[]  = 'Authorization: key= '.$this->api_key;
        $ch         = curl_init($this->path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);

        $response   = curl_exec($ch);

        curl_close($ch);
        return $response;
    }

    public function android($fields)
    {

        $headers    = array(
            'Authorization:key='.$this->api_key,
            'Content-Type:application/json'
        );
        $ch         = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->path);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result     = curl_exec($ch);

        curl_close($ch);
        return $result;
    }

    public function send($count,$tokens,$message,$device,$extra = null)
    {
        $temp['type'] = "MESSAGE";
        $temp['title'] = "New Notification";
        if($extra!=null && !isset($extra['title']))
        {
            $extra['title'] = "New Notification";
        }
        if($device == 'android') {
            $extra_param['badge'] = $count;
            $extra_param['extra'] = ($extra!=null) ? $extra : $temp;
            $fields     = array(
                'registration_ids' => $tokens,
                'data' => array('message' => $message, 'extra' => $extra_param, 'vibrate' => 1),
            );
            $result     = $this->android($fields);
        }
        else {
            $arrayToSend    = array('to' => $tokens, 'notification' => $message, 'priority' => 'high');
            $result         = $this->ios($arrayToSend);
        }

        return $result;
    }

}