<?php
/* @var $this Controller */
/* @var $content string */
?>
<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <meta name="keywords" content="<?= $this->keywords ?>">
    <meta name="description" content="<?= $this->description?> ">
    <title><?= $this->siteName.(!empty($this->pageTitle)?' - '.$this->pageTitle:'') ?></title>
    <?php
    $baseUrl = Yii::app()->theme->baseUrl.'/plugins/epub-reader';
    $cs = Yii::app()->getClientScript();
    Yii::app()->clientScript->registerCoreScript('jquery');

//    $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
    $cs->registerCssFile($baseUrl.'/libs/normalize.css');
    $cs->registerCssFile($baseUrl.'/libs/main.css?v13');

//    $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($baseUrl.'/libs/jszip/jszip.js', CClientScript::POS_HEAD);
    $cs->registerScriptFile($baseUrl.'/libs/underscore.js', CClientScript::POS_HEAD);
    $cs->registerScriptFile($baseUrl.'/libs/rsvp.js', CClientScript::POS_HEAD);
    $cs->registerScriptFile($baseUrl.'/libs/fileStorage.min.js', CClientScript::POS_HEAD);
    $cs->registerScriptFile($baseUrl.'/libs/js/epub.min.js', CClientScript::POS_HEAD);
    $cs->registerScriptFile($baseUrl.'/libs/js/reader.min.js', CClientScript::POS_HEAD);
    $cs->registerScriptFile($baseUrl.'/libs/js/reader2.js', CClientScript::POS_HEAD);
    $cs->registerScriptFile($baseUrl.'/libs/js/hooks.min.js', CClientScript::POS_HEAD);
    $cs->registerScriptFile($baseUrl.'/libs/mime-types/mime-types.js', CClientScript::POS_HEAD);
    $cs->registerScriptFile($baseUrl.'/libs/valueSelector.js', CClientScript::POS_HEAD);
    $cs->registerScriptFile($baseUrl.'/libs/jquery.plugin.clipboard.js', CClientScript::POS_HEAD);
    $cs->registerScript('initial', "
        EPUBJS.filePath = \"$baseUrl/reader/js/libs/\";
        EPUBJS.cssPath = \"$baseUrl/reader/css/\";
    ", CClientScript::POS_HEAD);
    ?>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <meta name="apple-mobile-web-app-capable" content="yes">
</head>
<body>
<?= $content ?>
</body>
</html>