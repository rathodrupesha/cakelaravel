<?php
/**
msg91  thirdparty api



 * Created by PhpStorm.
 * User: Rashmi Dholakiya
 * Date: 14/6/17
 * Time: 3:19 PM
 */

namespace App\Services;


/**
 * Class SMS
 * @package App\Services
 */
class SMS
{
    /**
     * @var mixed
     */
    protected $authKey;
    /**
     * @var string
     */
    protected $senderId;
    /**
     * @var string
     */
    protected $otpUrl;
    /**
     * @var string
     */
    protected $smsUrl;
    /**
     * @var string
     */
    protected $route;
    /**
     * @var string
     */
    protected $verifyOtpUrl;

    /**
     * @var int
     */
    protected $digits;

    /**
     * constuctor
     */
    public function __construct()
    {
        $this->authKey = config('constants.sms_api_key');//156178Aixs1tCkfUOP5940eb72
        $this->senderId = "saudaa";
        $this->smsUrl = "https://control.msg91.com/api/sendhttp.php";
        $this->otpUrl = "https://control.msg91.com/api/sendotp.php";
        $this->verifyOtpUrl = "https://control.msg91.com/api/verifyRequestOTP.php";
        $this->route = "4";
        $this->digits = 4;
    }


    /**
     * @param $phone_no
     * @return int
     */
    public function sendOtp($phone_no,$country_code)
    {
        $otp = rand(pow(10, $this->digits-1), pow(10, $this->digits)-1);

        $postData = array(
            'authkey' => $this->authKey,
            'mobiles' => $country_code.$phone_no,
            'message' => "Your OTP is $otp",
            'sender' => $this->senderId,
            'route' => $this->route,
        );

        $this->send($postData, $this->smsUrl);

        return $otp;
    }

    /**
     * @param $postData
     * @param $url
     * @return bool|mixed
     */
    public function send($postData, $url)
    {
        /*$ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
        ));

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            //return 'error:' . curl_error($ch);
            return false;
        }
        curl_close($ch);
        return $output;*/
    }

    /**
     * @param $phone_no
     * @param $otp
     */
    public function verifyOtp($phone_no, $otp)
    {
        $postData = array(
            'authkey' => $this->authKey,
            'mobile' => $phone_no,
            'otp' => $otp
        );

        $result = $this->send($postData, $this->verifyOtpUrl);
    }

    /**
     * @param $phone_no
     * @param $message
     */
    public function sendMessage($phone_no, $message,$country_code)
    {

        $postData = array(
            'authkey' => $this->authKey,
            'mobiles' => $country_code.$phone_no,
            'message' => $message,
            'sender' => $this->senderId,
            'route' => $this->route,
        );

        $result = $this->send($postData, $this->smsUrl);

    }
}