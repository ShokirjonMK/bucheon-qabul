<?php

namespace frontend\controllers;

use common\models\AuthAssignment;
use common\models\Direction;
use common\models\EduYear;
use common\models\EduYearForm;
use common\models\EduYearType;
use common\models\Student;
use common\models\Target;
use common\models\Telegram;
use common\models\TelegramDtm;
use common\models\TelegramOferta;
use common\models\TelegramPerevot;
use common\models\User;
use Yii;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\Response;


/**
 * Site controller
 */
class IkTestBotController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionBot()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $telegram = Yii::$app->telegram;
        $text = $telegram->input->message->text;
        $telegram_id = $telegram->input->message->chat->id;

        try {
            if (json_encode($telegram->input->message->contact) != "null") {
                $contact = json_encode($telegram->input->message->contact);
                $contact_new = json_decode($contact);
                $phone = preg_replace('/[^0-9]/', '', $contact_new->phone_number);
                $phoneKod = substr($phone, 0, 3);
                if ($phoneKod != 998) {
                    return $telegram->sendMessage([
                        'chat_id' => $telegram_id,
                        'text' => $this->textPhoneError(),
                        'parse_mode' => 'MarkdownV2',
                        'reply_markup' => self::phoneKeyboard(),
                    ]);
                }
                self::userSearchOne($phone , $telegram_id);
            }

            if ($text == '/start') {
                return $telegram->sendMessage([
                    'chat_id' => $telegram_id,
                    'text' => $this->textStart(),
                    'parse_mode' => 'MarkdownV2',
                    'reply_markup' => self::phoneKeyboard(),
                ]);
            }

            $user = User::findOne(['chat_id' => $telegram_id]);
            if (!$user) {
                return $telegram->sendMessage([
                    'chat_id' => $telegram_id,
                    'text' => $this->textStart(),
                    'parse_mode' => 'MarkdownV2',
                    'reply_markup' => self::phoneKeyboard(),
                ]);
            } else {
                if ($user->lang_id == null) {
                    $user->lang_id = 1;
                    $user->save(false);
                }
            }




            

        } catch (\Exception $e) {
            return $telegram->sendMessage([
                'chat_id' => 1841508935,
                'text' => $e->getMessage(),
            ]);
        } catch (\Throwable $t) {
            return $telegram->sendMessage([
                'chat_id' => 1841508935,
                'text' => $t->getMessage(), " at ", $t->getFile(), ":", $t->getLine(),
            ]);
        }
    }

    public function text1234()
    {
        $textUz = "📑 \n\n🇺🇿\n Arizangiz yuborilgan. Ariza xolatini tekshirish uchun quyidagi havolani bosing!\n\n";
        $textRu = "\n\n🇷🇺\n📑 Ваша заявка отправлена. Нажмите на ссылку ниже, чтобы проверить статус вашего заявления!\n\n ";
        $icon = "👇👇👇👇👇";
        return self::ikV2($textUz).self::ikV2($textRu).$icon;
    }

    public static function userSearchOne($phone , $telegram_id)
    {
        $phone = self::formatPhoneNumber($phone);
        $user = User::findOne(['username' => $phone]);
        if ($user) {
            User::updateAll(['chat_id' => null] , ['chat_id' => $telegram_id]);
            $user->chat_id = $telegram_id;
            $user->save(false);
        } else {
            $user = new User();
            $user->username = $phone;
            $user->user_role = 'student';
            $user->chat_id = $telegram_id;
            $user->lang_id = 1;
            $password = rand(100000 , 999999);

            $user->setPassword($password);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            $user->generatePasswordResetToken();
            $user->status = 10;
            $user->cons_id = 1;

            if ($user->save(false)) {
                $newAuth = new AuthAssignment();
                $newAuth->item_name = 'student';
                $newAuth->user_id = $user->id;
                $newAuth->created_at = time();
                $newAuth->save(false);

                $newStudent = new Student();
                $newStudent->user_id = $user->id;
                $newStudent->username = $user->username;
                $newStudent->password = $password;
                $newStudent->created_by = 0;
                $newStudent->updated_by = 0;
                $newStudent->save(false);
            }
        }
        return true;
    }

    public function textStart()
    {
        $text = "*TASHKENT PERFECT UNIVERSITY*\n\n🇺🇿\n_Telefon raqamingizni yuboring_\\.\n\n🇷🇺\n_Отправьте свой номер телефона_\\.";
        return $text;
    }

    public function phoneKeyboard()
    {
        $text = json_encode([
            'keyboard' => [[
                [
                    'text' => "☎️",
                    'request_contact' => true,
                ]
            ]],
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ]);
        return $text;
    }

    public function textPhoneError()
    {
        $phone = '+998771292929';
        $phone = self::ikV2($phone);
        $text = "⁉️⛔️\n\n🇺🇿\nBOT faqat UZB telefon raqamlari uchun xizmat qiladi\\. \n*Aloqa uchun\\: ".$phone."*\n\n🇷🇺\nБОТ работает только для номеров УЗБ\\. \n*Для общения\\: ".$phone."*";
        return $text;
    }

    private static function ikV2($text)
    {
        $escape_chars = ['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'];
        $escaped_text = str_replace($escape_chars, array_map(function($char) {
            return '\\' . $char;
        }, $escape_chars), $text);

        return $escaped_text;
    }

    private static function formatPhoneNumber($phoneNumber) {
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);
        $formattedNumber = sprintf("+%s (%s) %s-%s-%s",
            substr($phoneNumber, 0, 3),
            substr($phoneNumber, 3, 2),
            substr($phoneNumber, 5, 3),
            substr($phoneNumber, 8, 2),
            substr($phoneNumber, 10, 2)
        );
        return $formattedNumber;
    }
}
