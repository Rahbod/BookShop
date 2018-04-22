<?php
/** @var $this Controller */
/** @var $model Books */
/** @var $cs CClientScript */

$previewPath = Yii::getPathOfAlias("webroot") . "/uploads/books/previews/";
$filePath = Yii::getPathOfAlias("webroot") . "/uploads/books/files/";
$msg = 'متاسفانه در نمایش مشکلی بوجود آمده است! لطفا مجددا تلاش فرمایید.';

$baseUrl = Yii::app()->theme->baseUrl . '/plugins';
$cs = Yii::app()->clientScript;
$view = false;
if (isset($_GET['preview']) && is_file($previewPath . $model->preview_file)) {
    $filename = $model->preview_file;
    $url = Yii::app()->getBaseUrl(true) . '/uploads/books/previews/' . $model->preview_file;
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $view = true;
    if ($ext == 'pdf') {
        $msg = 'بخش نمایش فایل PDF در دست انجام است، لطفا بعدا مراجعه فرمایید.';
        $view = false;
    }
}
//else {
//    $package = $model->lastPackage;
//    if ($package->epub_file_name && is_file($filePath . pathinfo($package->epub_file_name, PATHINFO_FILENAME) . '.epub')) {
//        $url = Yii::app()->getBaseUrl(true) . '/uploads/books/files/' . pathinfo($package->epub_file_name, PATHINFO_FILENAME) . '.epub';
//        $ext = 'epub';
//        $view = true;
//    } elseif ($package->pdf_file_name && is_file($filePath . pathinfo($package->pdf_file_name, PATHINFO_FILENAME) . '.pdf')) {
//        $url = Yii::app()->baseUrl . '/uploads/books/files/' . pathinfo($package->pdf_file_name, PATHINFO_FILENAME) . '.pdf';
//        $ext = 'pdf';
////        $view = true;
//        $msg = 'بخش نمایش فایل PDF در دست انجام است، لطفا بعدا مراجعه فرمایید.';
//    }else
//        $msg = 'فایل کتاب ناقص است، لطفا با بخش پشتیبانی تماس حاصل فرمایید.';
//}
?>
<?php
if ($view):
    if ($ext == 'pdf'):


    elseif ($ext == 'epub'):
        ?>
        <div id="main" class="">
            <div id="prev" class="arrow">&#xe902;</div>
            <div id="next" class="arrow">&#xe903</div>

            <div id="lastPage" style="display: none;">
                <div class="content">
                    <div class="left">
                        <img src="https://cdn.ketabrasan.com/image/79813_36988_normal.jpg"/>
                    </div>
                    <div class="right">
                        <div class="head">با دانلود اپلیکیشن، کتاب را کامل بخوانید</div>
                        <div class="desc">
                            شما به آخر نسخه نمونه کتاب رسیده‌اید؛ برای خواندن نسخه کامل این کتاب، با توجه به دستگاه خود
                            اپلیکیشن کتابرسان را نصب کنید و از مطالعه لذت ببرید.
                        </div>
                        <div style="text-align: center">
                            <a class="btn download" href="http://ketabrasan.com/apps">
                                دانلود اپلیکیشن
                            </a>

                            <a class="btn buy" href="http://ketabrasan.com/basket?add=79813">خرید نسخه کامل</a>

                        </div>

                    </div>
                </div>
            </div>

            <div id="container">
                <div id="header">
                    <div id="logo">
                        <a href="<?= Yii::app()->getBaseUrl(true) ?>"><img
                                    src="<?= "$baseUrl/$ext-reader/img/ketabrasan-logo.png" ?>"/></a>
                    </div>
                    <div class="btns-panel">
                        <a href="#" class="setting curved-btn" style="line-height: 27px;">
                            &#xe900;
                            <div style="font-size: 7pt;font-family: IRANSans-web;position: absolute;bottom: 12px;line-height: 1em;margin-left: 10px;">
                                تنظیمات
                            </div>
                        </a>
                        <a href="#" class="toc curved-btn" style="line-height: 25px;">
                            &#xe901;
                            <div style="font-size: 7pt;font-family: IRANSans-web;position: absolute;bottom: 12px;line-height: 1em;margin-left: 14px;">
                                فهرست
                            </div>
                        </a>
                        <a href="http://ketabrasan.com/basket?add=79813" class="buy large curved-btn">دریافت نسخه
                            کامل</a>
                        <a href="http://ketabrasan.com/book/79813-?landing=digikala" class="buy small curved-btn"
                           style="display: none;">ebook</a>
                    </div>
                </div>

                <div id="viewer">
                    <div class="floatingMenu close setting">
                        <ul class="sections">
                            <li>
                                <ul id="fontSizeSelector" class="value-selector">
                                    <li class="left"></li>
                                    <li class="right"></li>
                                    <span class="value"></span>
                                </ul>
                            </li>
                            <li>
                                <ul id="lineHeightSelector" class="value-selector">
                                    <li class="left"></li>
                                    <li class="right"></li>
                                    <span class="value"></span>
                                </ul>
                            </li>
                            <li>
                                <div id="fontNameSelect">
                                    <a href="#" class="sans rtl" data-val="IRANSans-web">ایران</a>
                                    <a href="#" class="nazanin rtl" data-val="fidibo_nazanin">نازنین</a>
                                    <a href="#" class="badr rtl" data-val="fidibo_badr">بدر</a>
                                    <a href="#" class="sans-serif ltr" data-val="sans-serif">sans serif</a>
                                    <a href="#" class="serif ltr" data-val="serif">serif</a>
                                    <a href="#" class="cursive ltr" data-val="">cursive</a>
                                </div>
                            </li>
                            <li>
                                <div id="backgroundSelect">
                                    <a href="#" class="white" data-theme="white"></a>
                                    <a href="#" class="sepia" data-theme="sepia"></a>
                                    <a href="#" class="dark" data-theme="dark"></a>
                                    <a href="#" class="black" data-theme="black"></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="floatingMenu close toc" id="tocView">
                        <ul>
                        </ul>
                    </div>
                </div>

                <div id="footer">
                    <a href="<?= $this->createUrl('/apps') ?>" target="_blank" id="platforms"><img
                                src="<?= "$baseUrl/$ext-reader/img/platforms.png" ?>"></a>
                    <a href="<?= $this->createUrl('/apps') ?>" target="_blank" id="app" class="curved-btn">دریافت
                        اپلیکیشن</a>
                </div>

                <div id="loader">
                    <div class="spinner"></div>
                </div>
            </div>
        </div>

        <script>
            'use strict';
            var reader = null;
            $('document').ready(function () {
                var bookDirection = 'rtl';
                var settings = {};
                settings.styles = {};

                settings.layoutOveride = {
                    spread: 'none',
                    direction: bookDirection
                };

                if (bookDirection === 'rtl') {
                    settings.styles.fontFamily = 'Tahoma';//'IRANSans-web';
                } else {
                    settings.styles.fontFamily = 'Tahoma';
                }

                settings.styles.textAlign = 'justify';

                // Path of extracted epub book
                var bookPath = '<?= $url ?>';
                reader = new EPUBJS.Reader(bookPath, settings);
            });
        </script>
    <?php
    endif;
else:
    Yii::app()->user->setFlash('failed', $msg);
    $this->redirect($model->getViewUrl());
endif;