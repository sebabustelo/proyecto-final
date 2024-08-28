<?php
namespace App\Controller\Component;


use Cake\Controller\Component;

class RecaptchaComponent extends Component
{

    public function verifyReCaptcha($recaptchaCode, $captcha_verify_url, $captcha_secret){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,$captcha_verify_url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "secret=".$captcha_secret."&remoteip=".$_SERVER['REMOTE_ADDR']."&response=".$recaptchaCode);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $captcha_output = curl_exec ($curl);
        curl_close ($curl);
        $decoded_captcha = json_decode($captcha_output);
        return $decoded_captcha->success; 
}

}
