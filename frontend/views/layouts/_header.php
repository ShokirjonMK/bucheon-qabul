<?php
use yii\helpers\Url;
use common\models\Languages;
$languages = Languages::find()->where(['is_deleted' => 0, 'status' => 1])->all();
$lang = Yii::$app->language;
$langId = 1;
if ($lang == 'ru') {
    $langId = 3;
} elseif ($lang == 'en') {
    $langId = 2;
}
?>


<div class="head_desktop">
    <div class="header-center">
        <div class="header-center-item">
            <div class="head-center">
                <div class="head-logo">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="white" version="1.1" viewBox="0 0 139.29 139.29"><g id="Слой_x0020_1"><metadata id="CorelCorpID_0Corel-Layer"></metadata><path class="fil0" d="M0 139.29l30.7 0 0 -139.29 -30.7 0 0 139.29zm108.59 0l30.7 0 0 -139.29 -30.7 0 0 139.29zm-36.2 0l30.7 0 0 -139.29 -30.7 0 0 139.29zm-36.18 -50.09l30.69 0 0 -89.2 -30.69 0 0 89.2z"></path></g></svg>

                </div>
                <h1>TASHKENT PERFECT <br> UNIVERSITY</h1>
            </div>
        </div>
    </div>


    <div class="header">
        <div class="root-item">
            <div class="head-item">
                <div class="head-left">
                    <ul>
                        <li><a href="#"><?= Yii::t("app" , "a45") ?></a></li>
                        <li><a href="#"><?= Yii::t("app" , "a47") ?></a></li>
                    </ul>
                </div>
                <div class="head-right">
                    <div class="translation">
                        <div class="dropdown">

                            <button class="dropdown-toggle link-hover" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <p>Uzb</p> <img src="/frontend/web/images/uzb.png" alt="">
                            </button>

                            <ul class="dropdown-menu">
                                <ul class="drop_m_ul">
                                    <li>
                                        <a href="/admin/supper-admin/view?id=1">
                                            <span>Russian</span>
                                            <img src="/frontend/web/images/rus.png" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span>English</span>
                                            <img src="/frontend/web/images/eng1.png" alt="">
                                        </a>
                                    </li>

                                </ul>
                            </ul>

                        </div>
                    </div>
                    <div class="register">
                        <a href="<?= Url::to(['site/login']) ?>" class="link-hover">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="21" viewBox="0 0 18 21" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.47458 0.715265C5.16252 -0.41003 7.37968 0.621618 7.70853 2.51637H11C12.5188 2.51637 13.75 3.74759 13.75 5.26637C13.75 5.68058 13.4142 6.01637 13 6.01637C12.5858 6.01637 12.25 5.68058 12.25 5.26637C12.25 4.57601 11.6904 4.01637 11 4.01637H7.75V16.5164H11C11.6904 16.5164 12.25 15.9567 12.25 15.2664C12.25 14.8522 12.5858 14.5164 13 14.5164C13.4142 14.5164 13.75 14.8522 13.75 15.2664C13.75 16.7852 12.5188 18.0164 11 18.0164H7.70853C7.37968 19.9111 5.16252 20.9428 3.47458 19.8175L1.47457 18.4841C0.709528 17.9741 0.25 17.1155 0.25 16.196V4.33674C0.25 3.41727 0.709528 2.55863 1.47457 2.0486L3.47458 0.715265ZM12.5302 7.73603C12.8231 8.02892 12.8231 8.50379 12.5302 8.79669L11.8105 9.51636L16.9998 9.51636C17.4141 9.51636 17.7499 9.85214 17.7499 10.2664C17.7499 10.6806 17.4141 11.0164 16.9998 11.0164L11.8105 11.0164L12.5302 11.736C12.8231 12.0289 12.8231 12.5038 12.5302 12.7967C12.2373 13.0896 11.7624 13.0896 11.4695 12.7967L10.1766 11.5038C9.49321 10.8204 9.49321 9.71234 10.1766 9.02892L11.4695 7.73603C11.7624 7.44313 12.2373 7.44313 12.5302 7.73603Z" fill="white"></path></svg>
                            <?= Yii::t("app" , "a23") ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="header-info">
        <div class="root-item">
            <div class="header-info-item">
                <div class="header-info-left">
                    <div class="h-i-l-mail">
                        <a href="#">
                            <svg viewBox="0 0 39 18" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M38.5453 5.94375C38.7281 5.79844 39 5.93437 39 6.16406V15.75C39 16.9922 37.9922 18 36.75 18H17.25C16.0078 18 15 16.9922 15 15.75V6.16875C15 5.93438 15.2672 5.80312 15.4547 5.94844C16.5047 6.76406 17.8969 7.8 22.6781 11.2734C23.6672 11.9953 25.3359 13.5141 27 13.5047C28.6734 13.5188 30.375 11.9672 31.3266 11.2734C36.1078 7.8 37.4953 6.75938 38.5453 5.94375ZM27 12C28.0875 12.0188 29.6531 10.6313 30.4406 10.0594C36.6609 5.54531 37.1344 5.15156 38.5687 4.02656C38.8406 3.81562 39 3.4875 39 3.14062V2.25C39 1.00781 37.9922 0 36.75 0H17.25C16.0078 0 15 1.00781 15 2.25V3.14062C15 3.4875 15.1594 3.81094 15.4312 4.02656C16.8656 5.14687 17.3391 5.54531 23.5594 10.0594C24.3469 10.6313 25.9125 12.0188 27 12Z" fill="currentColor"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.1288 4.45829C9.40894 4.58179 8.51118 4.14935 8.96465 3.41562C9.10612 3.18697 10.0842 3 11.1387 3C12.7584 3 13.0363 3.104 12.9293 3.66912C12.8356 4.16121 12.3599 4.36997 11.1288 4.45829ZM9.59438 8.27379C6.44227 8.38353 5.38506 8.08224 5.91462 7.22462C6.08744 6.94512 7.34079 6.83309 9.49459 6.90459C12.1366 6.99253 12.8088 7.13094 12.8088 7.58824C12.8088 8.04362 12.147 8.18471 9.59438 8.27379ZM8.06077 12.0931C3.47521 12.1975 2.29221 11.9608 2.85388 11.0516C3.03168 10.7641 4.70103 10.6597 7.96326 10.7316C11.968 10.8199 12.8088 10.9376 12.8088 11.4118C12.8088 11.8851 11.9784 12.004 8.06077 12.0931ZM6.52791 16C0.229029 16 0 15.9729 0 15.2261C0 14.4756 0.195 14.4553 6.39944 14.557C12.1416 14.6511 12.8123 14.7306 12.9277 15.3309C13.0459 15.9469 12.5393 16 6.52791 16Z" fill="currentColor"></path>
                            </svg>
                            &nbsp;
                            info@perfectuniversity.uz
                        </a>

                    </div>
                </div>
                <div class="header-info-right">
                    <div class="target">

                        <a href="#">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#">
                            <i class="fa-brands fa-telegram"></i>
                        </a>
                        <a href="#">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                        <a href="#">
                            <i class="fa-brands fa-youtube"></i>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="head_mobile">
    <div class="root-item">
        <div class="mb_head d-flex justify-content-between align-items-center">
            <div class="mb_head_left">
                <a href="<?= Url::to(['site/index']) ?>">
                    <img src="/frontend/web/images/white_l.svg" alt="">
                </a>
            </div>
            <div class="mb_head_right">
                <div class="translation cab_flag" style="background: #2F5786;">
                    <div class="dropdown">

                        <button class="dropdown-toggle link-hover" style="background: none;" type="button" data-bs-toggle="dropdown" aria-expanded="true">
                            <?php foreach ($languages as $language): ?>
                                <?php if ($language->id == $langId): ?>
                                    <p style="color: #fff;"><?= $language['name_'.$lang] ?></p>
                                    <?php if ($language->id == 1): ?>
                                        <img src="/frontend/web/images/uzb.png" alt="">
                                    <?php elseif ($language->id == 2) : ?>
                                        <img src="/frontend/web/images/eng1.png" alt="">
                                    <?php elseif ($language->id == 3) : ?>
                                        <img src="/frontend/web/images/rus.png" alt="">
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </button>

                        <ul class="dropdown-menu">
                            <ul class="drop_m_ul">
                                <?php foreach ($languages as $language): ?>
                                    <?php if ($language->id != $langId): ?>
                                        <li>
                                            <a href="<?= Url::to(['site/lang' , 'id' => $language->id]) ?>">
                                                <span><?= $language['name_'.$lang] ?></span>
                                                <?php if ($language->id == 1): ?>
                                                    <img src="/frontend/web/images/uzb.png" alt="">
                                                <?php elseif ($language->id == 2) : ?>
                                                    <img src="/frontend/web/images/eng1.png" alt="">
                                                <?php elseif ($language->id == 3) : ?>
                                                    <img src="/frontend/web/images/rus.png" alt="">
                                                <?php endif; ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </ul>

                    </div>
                </div>
            </div>
        </div>

        <div class="mb_content">
            <div class="line_white"></div>
            <div class="line_red"></div>


            <div class="mb_menu_list2">
                <p><?= Yii::t("app" , "a1") ?></p>
                <ul>
                    <li>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#connectionModal">
                            <i class="fa-solid fa-phone"></i>
                            <span><?= Yii::t("app" , "a2") ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="#ik_direc">
                            <i class="fa-solid fa-sitemap"></i>
                            <span><?= Yii::t("app" , "a3") ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['site/login']) ?>">
                            <i class="fa-solid fa-file-import"></i>
                            <span><?= Yii::t("app" , "a4") ?></span>
                        </a>
                    </li>
                </ul>
            </div>


            <div class="mb_menu_list">
                <p><?= Yii::t("app" , "a5") ?></p>
                <ul>
                    <li><a href="https://www.instagram.com/perfect.university?igsh=ODhqOWJpMnM0YTFk"><i class="fa-brands fa-instagram"></i></a></li>
                    <li><a href="https://t.me/perfect_university"><i class="fa-brands fa-telegram"></i></a></li>
                    <li><a href="https://www.facebook.com/perfectuniversity.uz?mibextid=kFxxJD"><i class="fa-brands fa-facebook"></i></a></li>
                    <li><a href="https://youtube.com/@perfectuniversity4471?si=1hvUQR7t5bATWlcI"><i class="fa-brands fa-youtube"></i></a></li>
                </ul>
            </div>

            <img src="/frontend/web/images/logo-vector.svg" class="mb_vector_img">
        </div>
    </div>
</div>


<div class="modal fade" id="connectionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="ikmodel aloqa_model">
                <div class="ikmodel_item">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modalBody">
                        <img src="/frontend/web/images/wh_logo.png" alt="">
                        <div class="ik_connection">
                            <h5><?= Yii::t("app" , "a6") ?></h5>
                            <ul>
                                <li><p><?= Yii::t("app" , "a7") ?></p></li>
                                <li>
                                    <a href="tel:+998771292929">+998 (77) 129-29-29</a>
                                </li>
                            </ul>

                            <ul>
                                <li><p><?= Yii::t("app" , "a8") ?></p></li>
                                <li>
                                    <a href="tel:+998555000250">+998 (55) 500-02-50</a>
                                </li>
                            </ul>

                            <ul>
                                <li><p><?= Yii::t("app" , "a9") ?></p></li>
                                <li>
                                    <a href="https://maps.app.goo.gl/1aK5espkYi5Hvjde8">
                                        <?= Yii::t("app" , "a10") ?>
                                    </a>
                                </li>
                            </ul>

                            <div class="modal_vector_img">
                                <img src="/frontend/web/images/logo-vector.svg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>