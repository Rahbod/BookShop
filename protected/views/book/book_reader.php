<?php
/** @var $this Controller */
/** @var $model Books */
/** @var $cs CClientScript */

$previewPath = Yii::getPathOfAlias("webroot") . "/uploads/books/previews/";
$filePath = Yii::getPathOfAlias("webroot") . "/uploads/books/files/";
$msg = 'متاسفانه در نمایش مشکلی بوجود آمده است! لطفا مجددا تلاش فرمایید.';

$baseUrl = Yii::app()->theme->baseUrl.'/plugins';
$cs = Yii::app()->clientScript;
$view = false;
if(isset($_GET['preview']) && is_file($previewPath.$model->preview_file)){
    $filename = $model->preview_file;
    $url = Yii::app()->getBaseUrl(true).'/uploads/books/previews/'.$model->preview_file;
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $view = true;
    if($ext == 'pdf'){
        $msg = 'بخش نمایش فایل PDF در دست انجام است، لطفا بعدا مراجعه فرمایید.';
        $view = false;
    }
}else {
    $package = $model->lastPackage;
    if ($package->epub_file_name && is_file($filePath . pathinfo($package->epub_file_name, PATHINFO_FILENAME) . '.epub')) {
        $url = Yii::app()->getBaseUrl(true) . '/uploads/books/files/' . pathinfo($package->epub_file_name, PATHINFO_FILENAME) . '.epub';
        $ext = 'epub';
        $view = true;
    } elseif ($package->pdf_file_name && is_file($filePath . pathinfo($package->pdf_file_name, PATHINFO_FILENAME) . '.pdf')) {
        $url = Yii::app()->baseUrl . '/uploads/books/files/' . pathinfo($package->pdf_file_name, PATHINFO_FILENAME) . '.pdf';
        $ext = 'pdf';
//        $view = true;
        $msg = 'بخش نمایش فایل PDF در دست انجام است، لطفا بعدا مراجعه فرمایید.';
    }else
        $msg = 'فایل کتاب ناقص است، لطفا با بخش پشتیبانی تماس حاصل فرمایید.';
}
?>
<?php
if($view):
    if($ext == 'pdf'):


    elseif($ext == 'epub'):
        $cs->registerScriptFile($baseUrl.'/epub-reader/epub.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($baseUrl.'/epub-reader/libs/localforage.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($baseUrl.'/epub-reader/libs/zip.min.js', CClientScript::POS_HEAD);
        $cs->registerCss('reader-css', "
            body {
                overflow: hidden;
                overflow-y:auto;
            }
            #main {
                position: absolute;
                width: 100%;
                height: 100%;
            }
            #area {
                width: 70%;
                height: 90%;
                margin: 2% auto;
                max-width: 1250px;
            }
            #area iframe {
                border: none;
            }
            #prev {
                -webkit-transform: rotate(180deg);
                -moz-transform: rotate(180deg);
                -ms-transform: rotate(180deg);
                -o-transform: rotate(180deg);
                transform: rotate(180deg);
                left: 40px;
            }
            #next {
                -webkit-transform: rotate(180deg);
                -moz-transform: rotate(180deg);
                -ms-transform: rotate(180deg);
                -o-transform: rotate(180deg);
                transform: rotate(180deg);
                right: 40px;
            }
            .arrow {
                position: absolute;
                top: 50%;
                margin-top: -32px;
                font-size: 64px;
                color: #E2E2E2;
                font-family: arial, sans-serif;
                font-weight: bold;
                cursor: pointer;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }
            .arrow:hover {
                color: #777;
            }
            .arrow:active {
                color: #000;
            }
        ");
    ?>
    <div id="main">
        <div id="prev" onclick="Book.prevPage();" class="arrow">‹</div>
        <div id="area"></div>
        <div id="next" onclick="Book.nextPage();" class="arrow">›</div>
    </div>
    <script>
        "use strict";
        var Book = ePub("<?= $url ?>");
        Book.renderTo("area");

        localforage.config({
            name: 'epubjs'
        });
    </script>
    <?php
    endif;
else:
    Yii::app()->user->setFlash('failed',$msg);
    $this->redirect($model->getViewUrl());
endif;