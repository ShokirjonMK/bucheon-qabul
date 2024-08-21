<?php

namespace common\models;

use Yii;
use DateTime;
use DateTimeZone;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "sms".
 *
 * @property int $id
 * @property int $kimdan
 * @property int $kimga
 * @property string $title
 * @property int $status
 * @property int $date
 */

class Message extends \yii\db\ActiveRecord
{
    public static function sendSms($phone, $text)
    {
        $phone = preg_replace("/[^0-9]/", "", $phone);
        $text = 'TASHKENT PERFECT UNIVERSITY  - tasdiqlash kodi: '. $text;
        $data = '{
                "messages":
                    [
                        {
                        "recipient":'.$phone.',
                        "message-id":"abc000000001",
                            "sms":{
                                "originator": "TPU",
                                "content": {
                                    "text": "'.$text.'"
                                }
                            }
                        }
                    ]
                }';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://send.smsxabar.uz/broker-api/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic ".base64_encode("perfectuniversity:i_A~87mSz8@H"),
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return $phone." --- ".$response;
    }



    public static function sendedSms($phone, $text)
    {
        $phone = preg_replace("/[^0-9]/", "", $phone);
        $data = '{
                "messages":
                    [
                        {
                        "recipient":'.$phone.',
                        "message-id":"abc000000001",
                            "sms":{
                                "originator": "TPU",
                                "content": {
                                    "text": "'.$text.'"
                                }
                            }
                        }
                    ]
                }';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://send.smsxabar.uz/broker-api/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic ".base64_encode("perfectuniversity:i_A~87mSz8@H"),
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return $phone." --- ".$response;
    }


}

