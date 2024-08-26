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
class IkBotController extends Controller
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
        $receivedMessageId = $telegram->input->message->message_id;
        $username = $telegram->input->message->chat->username;
        $telegram_id = $telegram->input->message->chat->id;

        try {

            $user = User::findOne([
                'username' => $telegram_id
            ]);

            if (!$user) {
                $user = new User();
                $user->username = $telegram_id;
                $user->user_role = 'student';

                $password = '@ikbol_2001';
                $user->setPassword($password);
                $user->generateAuthKey();
                $user->generateEmailVerificationToken();
                $user->generatePasswordResetToken();
                $user->status = 10;
                $user->telegram_step = 1;

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

            $student = $user->student;
            $step = $user->telegram_step;
            $lang_id = $user->lang_id;


            //ortga knopka uchun
            if ($text == "🔙Назад" || $text == "🔙Orqaga" || $text == "🔙Back") {
                if ($step == 3) {
                    $user->telegram_step = 2;
                    $user->save(false);
                    $textUz = "🇺🇿 \n Hurmatli abiturient bot sizga qaysi tilda javob berishini hohlaysiz? O'zingizga mos tilni tanang! \n\n ";
                    $textEn = "🇺🇸 \n Dear applicant, in what language would you like the bot to respond to you? Choose your own language! \n\n ";
                    $textRu = "🇷🇺 \n Уважаемый соискатель, на каком языке вы бы хотели, чтобы бот вам отвечал? Выберите свой собственный язык!";
                    $stepOneText = self::escapeMarkdownV2($textUz).self::escapeMarkdownV2($textEn).self::escapeMarkdownV2($textRu);
                    return $telegram->sendMessage([
                        'chat_id' => $telegram_id,
                        'text' => $stepOneText,
                        'parse_mode' => 'MarkdownV2',
                        'reply_markup' => self::getLanguages()
                    ]);

                } elseif ($step == 4) {
                    $user->telegram_step = 3;
                    $user->save(false);
                    return $telegram->sendMessage([
                        'chat_id' => $telegram_id,
                        'text' => self::getTranslateMessage('t1' , $user->lang_id),
                        'parse_mode' => 'MarkdownV2',
                        'reply_markup' => json_encode([
                            'keyboard' => [[
                                [
                                    'text' => "☎️",
                                    'request_contact' => true,
                                ],
                                [
                                    'text' => self::undoKeyboardUser($user)
                                ]
                            ]],
                            'resize_keyboard' => true,
                            'one_time_keyboard' => true,
                        ])
                    ]);

                } elseif ($step == 5) {
                    $user->telegram_step = 4;
                    $user->save(false);
                    return $telegram->sendMessage([
                        'chat_id' => $telegram_id,
                        'text' => self::getTranslateMessage('t3' , $lang_id),
                        'parse_mode' => 'MarkdownV2',
                        'reply_markup' => self::undoKeyboard($lang_id)
                    ]);

                } elseif ($step == 6) {
                    $user->telegram_step = 5;
                    $user->save(false);
                    return $telegram->sendMessage([
                        'chat_id' => $telegram_id,
                        'text' => self::getTranslateMessage('t4' , $lang_id),
                        'parse_mode' => 'MarkdownV2',
                        'reply_markup' => self::undoKeyboard($lang_id)
                    ]);

                } elseif ($step == 7) {
                    $user->telegram_step = 6;
                    $user->save(false);
                    return $telegram->sendMessage([
                        'chat_id' => $telegram_id,
                        'text' => self::getTranslateMessage('t5' , $lang_id),
                        'parse_mode' => 'MarkdownV2',
                        'reply_markup' => json_encode([
                            'keyboard' => [
                                [
                                    ['text' => self::getTranslateMessage("t6", $lang_id)],
                                ],
                                [
                                    ['text' => self::getTranslateMessage("t7", $lang_id)],
                                ],
                                [
                                    ['text' => self::getTranslateMessage("t8", $lang_id)],
                                ],
                                [
                                    ['text' => self::getTranslateMessage("t9", $lang_id)],
                                ],
                                [
                                    ['text' => self::undoKeyboardUser($user)]
                                ]
                            ],
                            'resize_keyboard' => true,
                        ])
                    ]);

                } elseif ($step == 8) {
                    $user->telegram_step = 7;
                    $user->save(false);
                    return $telegram->sendMessage([
                        'chat_id' => $telegram_id,
                        'text' => self::getTranslateMessage('t11' , $lang_id),
                        'parse_mode' => 'MarkdownV2',
                        'reply_markup' => json_encode([
                            'keyboard' => [
                                [
                                    ['text' => self::getTranslateMessage("t12", $lang_id)],
                                    ['text' => self::getTranslateMessage("t13", $lang_id)],
                                    ['text' => self::getTranslateMessage("t14", $lang_id)],
                                ],
                                [
                                    ['text' => self::undoKeyboardUser($user)]
                                ]
                            ],
                            'resize_keyboard' => true,
                        ])
                    ]);

                }
            }
            //ortga knopka uchun

            if ($step == 1) {
                $user->telegram_step = 2;
                $user->save(false);

                $textUz = "🇺🇿 \n Hurmatli abiturient bot sizga qaysi tilda javob berishini hohlaysiz? O'zingizga mos tilni tanang! \n\n ";
                $textEn = "🇺🇸 \n Dear applicant, in what language would you like the bot to respond to you? Choose your own language! \n\n ";
                $textRu = "🇷🇺 \n Уважаемый соискатель, на каком языке вы бы хотели, чтобы бот вам отвечал? Выберите свой собственный язык!";
                $stepOneText = self::escapeMarkdownV2($textUz).self::escapeMarkdownV2($textEn).self::escapeMarkdownV2($textRu);
                return $telegram->sendMessage([
                    'chat_id' => $telegram_id,
                    'text' => $stepOneText,
                    'parse_mode' => 'MarkdownV2',
                    'reply_markup' => self::getLanguages()
                ]);
            }

            if ($step == 2) {
                if (self::getSelectLanguage($text)) {
                    $user->lang_id = self::getSelectLanguage($text);
                    $user->telegram_step = 3;
                    $user->save(false);

                    return $telegram->sendMessage([
                        'chat_id' => $telegram_id,
                        'text' => self::getTranslateMessage('t1' , $user->lang_id),
                        'parse_mode' => 'MarkdownV2',
                        'reply_markup' => json_encode([
                            'keyboard' => [[
                                [
                                    'text' => "☎️",
                                    'request_contact' => true,
                                ],
                                [
                                    'text' => self::undoKeyboardUser($user)
                                ]
                            ]],
                            'resize_keyboard' => true,
                            'one_time_keyboard' => true,
                        ])
                    ]);
                }
            }

            if ($step == 3) {
                if (json_encode($telegram->input->message->contact) != "null") {
                    $contact = json_encode($telegram->input->message->contact);
                    $contact_new = json_decode($contact);
                    $phone = preg_replace('/[^0-9]/', '', $contact_new->phone_number);
                    $phoneKod = substr($phone, 0, 3);
                    if ($phoneKod != 998) {
                        return $telegram->sendMessage([
                            'chat_id' => $telegram_id,
                            'text' => self::getTranslateMessage('t2' , $lang_id),
                            'parse_mode' => 'MarkdownV2',
                            'reply_markup' => self::undoKeyboard($lang_id)
                        ]);
                    }
                    $student->student_phone = '+'.$phone;
                    $student->save(false);
                    $user->telegram_step = 4;
                    $user->save(false);

                    return $telegram->sendMessage([
                        'chat_id' => $telegram_id,
                        'text' => self::getTranslateMessage('t3' , $lang_id),
                        'parse_mode' => 'MarkdownV2',
                        'reply_markup' => self::undoKeyboard($lang_id)
                    ]);
                }
            }

            if ($step == 4) {
                $seria = self::seria($text);
                if ($seria) {
                    $student->passport_serial = substr($text, 0, 2);
                    $student->passport_number = substr($text, 2, 9);
                    $user->telegram_step = 5;
                    $user->save(false);
                    $student->save(false);

                    return $telegram->sendMessage([
                        'chat_id' => $telegram_id,
                        'text' => self::getTranslateMessage('t4' , $lang_id),
                        'parse_mode' => 'MarkdownV2',
                        'reply_markup' => self::undoKeyboard($lang_id)
                    ]);
                }
                return $telegram->sendMessage([
                    'chat_id' => $telegram_id,
                    'text' => self::getTranslateMessage('t3' , $lang_id),
                    'parse_mode' => 'MarkdownV2',
                    'reply_markup' => self::undoKeyboard($lang_id)
                ]);
            }

            if ($step == 5) {
                $date = self::date($text);
                if ($date) {
                    $student->birthday = date("Y-m-d", strtotime($text));
                    $passport = self::passport($student);

                    if ($passport['is_ok']) {
                        $student = $passport['student'];
                        $student->save(false);
                        $user->telegram_step = 6;
                        $user->save(false);

                        return $telegram->sendMessage([
                            'chat_id' => $telegram_id,
                            'text' => self::getTranslateMessage('t5' , $lang_id),
                            'parse_mode' => 'MarkdownV2',
                            'reply_markup' => json_encode([
                                'keyboard' => [
                                    [
                                        ['text' => self::getTranslateMessage("t6", $lang_id)],
                                    ],
                                    [
                                        ['text' => self::getTranslateMessage("t7", $lang_id)],
                                    ],
                                    [
                                        ['text' => self::getTranslateMessage("t8", $lang_id)],
                                    ],
                                    [
                                        ['text' => self::getTranslateMessage("t9", $lang_id)],
                                    ],
                                    [
                                        ['text' => self::undoKeyboardUser($user)]
                                    ]
                                ],
                                'resize_keyboard' => true,
                            ])
                        ]);

                    } else {
                        return $telegram->sendMessage([
                            'chat_id' => $telegram_id,
                            'text' => self::getTranslateMessage('t10' , $lang_id),
                            'parse_mode' => 'MarkdownV2',
                            'reply_markup' => self::undoKeyboard($lang_id)
                        ]);
                    }
                } else {
                    return $telegram->sendMessage([
                        'chat_id' => $telegram_id,
                        'text' => self::getTranslateMessage('t4' , $lang_id),
                        'parse_mode' => 'MarkdownV2',
                        'reply_markup' => self::undoKeyboard($lang_id)
                    ]);
                }
            }

            if ($step == 6) {
                $type = self::getSelectEduType($text , $lang_id);
                if ($type['is_ok']) {
                    $eduYearType = $type['data'];
                    $student->edu_year_type_id = $eduYearType->id;
                    $student->edu_type_id = $student->eduYearType->edu_type_id;
                    $student->save(false);
                    $user->telegram_step = 7;
                    $user->save(false);

                    return $telegram->sendMessage([
                        'chat_id' => $telegram_id,
                        'text' => self::getTranslateMessage('t11' , $lang_id),
                        'parse_mode' => 'MarkdownV2',
                        'reply_markup' => json_encode([
                            'keyboard' => [
                                [
                                    ['text' => self::getTranslateMessage("t12", $lang_id)],
                                    ['text' => self::getTranslateMessage("t13", $lang_id)],
                                    ['text' => self::getTranslateMessage("t14", $lang_id)],
                                ],
                                [
                                    ['text' => self::undoKeyboardUser($user)]
                                ]
                            ],
                            'resize_keyboard' => true,
                        ])
                    ]);

                } else {
                    return $telegram->sendMessage([
                        'chat_id' => $telegram_id,
                        'text' => self::getTranslateMessage('t2' , $lang_id),
                        'parse_mode' => 'MarkdownV2',
                        'reply_markup' => self::undoKeyboard($lang_id)
                    ]);
                }
            }

            if ($step == 7) {
                $type = self::getSelectEduForm($text , $lang_id);
                if ($type['is_ok']) {
                    $eduForm = $type['data'];
                    $student->edu_year_form_id = $eduForm->id;
                    $student->edu_form_id = $student->eduYearForm->edu_form_id;
                    $student->save(false);

                    $user->telegram_step = 8;
                    $user->save(false);

                    return $telegram->sendMessage([
                        'chat_id' => $telegram_id,
                        'text' => self::getTranslateMessage('t15' , $lang_id),
                        'parse_mode' => 'MarkdownV2',
                        'reply_markup' => json_encode([
                            'keyboard' => [
                                [
                                    ['text' => self::getTranslateMessage("t16", $lang_id)],
                                    ['text' => self::getTranslateMessage("t17", $lang_id)],
                                ],
                                [
                                    ['text' => self::getTranslateMessage("t18", $lang_id)],
                                    ['text' => self::getTranslateMessage("t19", $lang_id)],
                                ],
                                [
                                    ['text' => self::undoKeyboardUser($user)]
                                ]
                            ],
                            'resize_keyboard' => true,
                        ])
                    ]);
                }
                return $telegram->sendMessage([
                    'chat_id' => $telegram_id,
                    'text' => self::getTranslateMessage('t2' , $lang_id),
                    'parse_mode' => 'MarkdownV2',
                    'reply_markup' => self::undoKeyboard($lang_id)
                ]);
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



    public static function result($userOne)
    {

        if ($userOne->confirm_date == null) {
            $userOne->confirm_date = date("Y-m-d H:i:s");
            $userOne->save(false);
        }

        $gender = ($userOne->gender == 0) ? '👩‍🎓' : '👨‍🎓';

        $ariza = "📤  *Arizangiz muvaffaqiyatli yuborildi\\.* \n\n";
        $full_name = $gender . " *F\\.I\\.O\\:* " . self::escapeMarkdownV2($userOne->last_name . ' ' . $userOne->first_name . ' ' . $userOne->middle_name) . "\n";
        $pass = "📑 *Pasport ma\\'lumoti\\:* " . self::escapeMarkdownV2($userOne->passport_serial . ' ' . $userOne->passport_number) . "\n";
        $birthday = "🗓 *Tug\\'ilgan sana\\:* " . self::escapeMarkdownV2($userOne->birthday) . "\n";
        $phone = "📞 *Telefon raqam\\:* ".self::escapeMarkdownV2($userOne->phone)."\n";

        $hr = "\\- \\- \\- \\- \\- \\- \\- \\- \\- \n";

        if ($userOne->eduYearType->edu_type_id == 1) {
            $examType = 'Online';
            if ($userOne->exam_type == 1) {
                $examType = 'Offline';
            }
        } else {
            $examType = "\\- \\- \\- \\- \\-";
        }

        $admin = "\n\n📌 _Arizangiz ko\\'rib chiqilib tez orada siz bilan 👩‍💻 operatorlarimiz bog\\'lanishadi\\. Aloqa uchun\\: 771292929_";
        $sendSmsDate = "\n\n🕒 ️ _Yuborilgan vaqt\\: ". self::escapeMarkdownV2($userOne->confirm_date) ."_";

        $direc = $userOne->direction;

        $d = "🔘 *Yo\\'nalish\\:* " . self::escapeMarkdownV2($direc->name_uz) . "\n";
        $code = "🔸 *Yo\\'nalish kodi\\:* " . self::escapeMarkdownV2($direc->code) . "\n";
        $edTy = "♦️ *Qabul turi\\:* " . self::escapeMarkdownV2($direc->eduType->name_uz) . "\n";
        $edFo = "🔹 *Ta\\'lim shakli\\:* " . self::escapeMarkdownV2($direc->eduForm->name_uz) . "\n";
        $im_type = "▫️ *Imtixon turi\\:* ".$examType."\n";
        $edLa = "🇺🇿 *Ta\\'lim tili\\:* ". self::escapeMarkdownV2($direc->language->name_uz);
        $mes = $ariza . $full_name . $pass . $birthday. $phone . $hr . $d . $code . $edTy . $edFo . $im_type . $edLa. $admin . $sendSmsDate;

        return $mes;
    }

    private static function escapeMarkdownV2($text)
    {
        $escape_chars = ['[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'];
        $escaped_text = str_replace($escape_chars, array_map(function($char) {
            return '\\' . $char;
        }, $escape_chars), $text);

        return $escaped_text;
    }


    public static function getDirection($name, $userOne)
    {
        $directions = Direction::find()
            ->where([
                'edu_year_id' => 1,
                'language_id' => $userOne->language_id,
                'edu_year_form_id' => $userOne->edu_year_form_id,
                'edu_year_type_id' => $userOne->edu_year_type_id,
                'status' => 1,
                'is_deleted' => 0
            ])->all();
        if (count($directions) > 0) {
            foreach ($directions as $dir) {
                $dir_name = ($userOne->language_id == 1) ? $dir->code . ' - ' . $dir->name_uz : $dir->code . ' - ' . $dir->name_ru;
                if ($dir_name == $name) {
                    return ['is_ok' => true, 'direction' => $dir];
                }
            }
        }
        return ['is_ok' => false];
    }

    public static function seria($text)
    {
        $pattern = '/^[A-Z]{2}\d{7}$/';
        if (preg_match($pattern, $text)) {
            return true;
        } else {
            return false;
        }
    }

    public static function date($text)
    {
        $format = 'Y-m-d';
        $d = \DateTime::createFromFormat($format, $text);
        return $d && $d->format($format) === $text;
    }

    public static function passport($student)
    {
        $client = new Client();
        $url = 'https://api.online-mahalla.uz/api/v1/public/tax/passport';
        $params = [
            'series' => $student->passport_serial,
            'number' => $student->passport_number,
            'birth_date' => $student->birthday,
        ];
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->setData($params)
            ->send();

        if ($response->isOk) {
            $responseData = $response->data;
            $passport = $responseData['data']['info']['data'];
            $student->first_name = $passport['name'];
            $student->last_name = $passport['sur_name'];
            $student->middle_name = $passport['patronymic_name'];
            $student->passport_pin = (string)$passport['pinfl'];

            $student->passport_issued_date = date("Y-m-d", strtotime($passport['expiration_date']));
            $student->passport_given_date = date("Y-m-d", strtotime($passport['given_date']));
            $student->passport_given_by = $passport['given_place'];
            $student->gender = $passport['gender'];
            return ['is_ok' => true, 'student' => $student];
        }
        return ['is_ok' => false];
    }


    public static function undoKeyboard($lang_id)
    {
        if ($lang_id == 2) {
            $text_keybord_undo = "🔙Back";
        } elseif ($lang_id == 3) {
            $text_keybord_undo = "🔙Назад";
        } else {
            $text_keybord_undo = "🔙Orqaga";
        }
        $keyboard_basic_undo = json_encode([
            'keyboard' => [
                [
                    ['text' => $text_keybord_undo]
                ]
            ], 'resize_keyboard' => true
        ]);
        return $keyboard_basic_undo;
    }

    public static function undoKeyboardUser($user)
    {
        if ($user->lang_id == 3) {
            $text_keybord_undo = "🔙Назад";
        } elseif ($user->lang_id == 2) {
            $text_keybord_undo = "🔙Back";
        } else {
            $text_keybord_undo = "🔙Orqaga";
        }
        return $text_keybord_undo;
    }

    public static function getLanguages()
    {
        return json_encode([
            'keyboard' => [
                [
                    ['text' => "🇺🇿O‘zbek🇺🇿"],
                ],
                [
                    ['text' => "🇺🇸English🇺🇸"],
                    ['text' => "🇷🇺Русский🇷🇺"],
                ],
            ], 'resize_keyboard' => true
        ]);
    }

    public static function getSelectEduType($type , $lang_id)
    {
        $types = [
            1 => self::getTranslateMessage('t6', $lang_id),
            2 => self::getTranslateMessage('t7', $lang_id),
            3 => self::getTranslateMessage('t8', $lang_id),
            4 => self::getTranslateMessage('t9', $lang_id),
        ];

        $id = array_search($type, $types);

        if ($id !== false) {
            $eduYearType = EduYearType::findOne($id);
            if ($eduYearType) {
                return ['is_ok' => true, 'data' => $eduYearType];
            }
        }

        return ['is_ok' => false];
    }

    public static function getSelectEduForm($type , $lang_id)
    {
        $types = [
            1 => self::getTranslateMessage('t12', $lang_id),
            2 => self::getTranslateMessage('t13', $lang_id),
            3 => self::getTranslateMessage('t14', $lang_id),
        ];

        $id = array_search($type, $types);

        if ($id !== false) {
            $eduYearForm = EduYearForm::findOne($id);
            if ($eduYearForm) {
                return ['is_ok' => true, 'data' => $eduYearForm];
            }
        }
        return ['is_ok' => false];
    }

    public static function getSelectLanguage($lang)
    {
        if (($lang == '🇺🇿O‘zbek🇺🇿')) {
            return 1;
        }
        if (($lang == '🇺🇸English🇺🇸')) {
            return 2;
        }
        if (($lang == '🇷🇺Русский🇷🇺')) {
            return 3;
        }
        return false;
    }

    public static function getSelectLanguageText($lang)
    {
        $array = [
            1 => "uz",
            2 => "en",
            3 => "ru",
        ];
        return isset($array[$lang]) ? $array[$lang] : null;
    }

    public static function getTranslateMessage($text, $lang_id)
    {
        $phone = '+998 94 505 52 50';
        $lang = self::getSelectLanguageText($lang_id);
        $array = [
            "t1" => [
                "uz" => "_Telefon raqamingizni pastdagi tugma orqali yuboring._",
                "en" => "_Submit your phone number using the button below._",
                "ru" => "_Отправьте свой номер телефона, используя кнопку ниже._",
            ],

            "t2" => [
                "uz" => "⁉️ *Noto'g'ri ma'lumot yuborildi.* \n\n ☎️ _Aloqa uchun: ".$phone."_",
                "en" => "⁉️ *Invalid information was sent.* \n\n ☎️ _For communication: ".$phone."_",
                "ru" => "⁉️ *Отправлена неверная информация.* \n\n ☎️ _Для связи: ".$phone."_",
            ],

            "t3" => [
                "uz" => "✍️ *Pasportingizngiz seriyasi va nomerini yozing!* \n\n 💡_Masalan: AB1234567_",
                "en" => "✍️ *Write your passport series and number!* \n\n 💡_Example: AB1234567_",
                "ru" => "✍️ *Напишите серию и номер паспорта!* \n\n 💡_Например: AB1234567_",
            ],

            "t4" => [
                "uz" => "✍️ *Tug'ilgan sanangizni (yil-oy-sana formatida) yozing!* \n\n💡_Masalan: 2001-10-16_",
                "en" => "✍️ *Enter your date of birth (in year-month-date format)!* \n\n💡_Example: 2001-10-16_",
                "ru" => "✍️ *Введите дату рождения (в формате год-месяц-число)!* \n\n💡_Например: 2001-10-16_",
            ],

            "t5" => [
                "uz" => "🔘 *Qabul turini tanlang!*",
                "en" => "🔘 *Select the type of reception!*",
                "ru" => "🔘 *Выберите тип приема!*",
            ],

            "t6" => [
                "uz" => "Qabul 2024",
                "en" => "Admission 2024",
                "ru" => "Принятие 2024",
            ],

            "t7" => [
                "uz" => "O‘qishni ko‘chirish",
                "en" => "Transfer study",
                "ru" => "Трансферное исследование",
            ],

            "t8" => [
                "uz" => "UZBMB natija",
                "en" => "UZBMB result",
                "ru" => "Результат УЗБМБ",
            ],

            "t9" => [
                "uz" => "Magistratura",
                "en" => "Магистр",
                "ru" => "Masters",
            ],

            "t10" => [
                "uz" => "⁉️ *Pasport seriyasi, raqami va tug'ilgan sana orqali pasport ma'lumoti topilmadi. Qaytadan urinib ko'ring!*",
                "en" => "⁉️ *Passport information not found by passport series, number and date of birth. Please try again!*",
                "ru" => "⁉️ *Паспортные данные не найдены по серии, номеру и дате рождения паспорта. Пожалуйста, попробуйте еще раз!*",
            ],

            "t11" => [
                "uz" => "🔘 *Ta'lim shaklini tanlang!*",
                "en" => "🔘 *Choose the form of education!*",
                "ru" => "🔘 *Выбирайте форму обучения!*",
            ],

            "t12" => [
                "uz" => "Kunduzgi",
                "en" => "Daytime",
                "ru" => "Очный",
            ],

            "t13" => [
                "uz" => "Sirtqi",
                "en" => "Externally",
                "ru" => "Заочный",
            ],

            "t14" => [
                "uz" => "Kechki",
                "en" => "Evening",
                "ru" => "Вечер",
            ],

            "t15" => [
                "uz" => "🔘 *Ta'lim turini tanlang!*",
                "en" => "🔘 *Choose the type of education!*",
                "ru" => "🔘 *Выбирайте тип обучения!*",
            ],

            "t16" => [
                "uz" => "O'zbek",
                "en" => "Uzbek",
                "ru" => "Узбекский",
            ],

            "t17" => [
                "uz" => "English",
                "en" => "English",
                "ru" => "Английский",
            ],

            "t18" => [
                "uz" => "Rus",
                "en" => "Russian",
                "ru" => "Русский",
            ],

            "t19" => [
                "uz" => "Koreya",
                "en" => "Korea",
                "ru" => "Корея",
            ],



//            "t" => [
//                "uz" => "",
//                "en" => "",
//                "ru" => "",
//            ],
        ];
        if (isset($array[$text])) {
            return isset($array[$text][$lang]) ? self::escapeMarkdownV2($array[$text][$lang]) : self::escapeMarkdownV2($text);
        } else {
            return self::escapeMarkdownV2($text);
        }
    }
}
