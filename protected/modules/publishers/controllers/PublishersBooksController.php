<?php

class PublishersBooksController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $formats = '.doc ,.docx';

    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'frontend' => array(
                'create',
                'update',
                'delete',
                'uploadImage',
                'deleteImage',
                'upload',
                'deleteUpload',
                'uploadFile',
                'deleteUploadFile',
                'images',
                'savePackage'
            ),
        );
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'delete', 'uploadImage', 'deleteImage', 'upload', 'deleteUpload', 'uploadFile', 'deleteUploadFile', 'images', 'savePackage'),
                'roles' => array('publisher'),
            ),
            array(
                'deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }


    public function actions(){
        return array(
            'upload' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
                'attribute' => 'icon',
                'rename' => 'random',
                'validateOptions' => array(
                    'dimensions' => array(
                        'minWidth' => 400,
                        'minHeight' => 590,
                    ),
                    'acceptedTypes' => array('jpg','jpeg','png')
                )
            ),
            'uploadFile' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
                'attribute' => 'file_name',
                'rename' => 'random',
                'validateOptions' => array(
                    'acceptedTypes' => array('doc','docx')
                )
            ),
            'uploadImage' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
                'attribute' => 'image',
                'rename' => 'random',
                'validateOptions' => array(
                    'acceptedTypes' => array('jpg','jpeg','png')
                )
            ),
            'deleteUpload' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
                'modelName' => 'Books',
                'attribute' => 'icon',
                'uploadDir' => 'uploads/books/icons',
                'storedMode' => 'field'
            ),
            'deleteUploadFile' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
                'modelName' => 'BookPackages',
                'attribute' => 'file_name',
                'uploadDir' => 'uploads/books/files',
                'storedMode' => 'record'
            ),
            'deleteImage' => array(
                'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
                'modelName' => 'BookImages',
                'attribute' => 'image',
                'uploadDir' => 'uploads/books/images',
                'storedMode' => 'record'
            )
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        if (Yii::app()->user->isGuest || Yii::app()->user->type != 'admin') {
            $user = UserDetails::model()->findByPk(Yii::app()->user->getId());
            if ($user->details_status == 'refused') {
                Yii::app()->user->setFlash('failed', 'اطلاعات قرارداد شما رد شده است و نمیتوانید کتاب ثبت کنید. در صورت نیاز نسبت به تغییر اطلاعات خود اقدام کنید.');
                $this->redirect(array('/publishers/panel/account'));
            } elseif ($user->details_status == 'pending') {
                Yii::app()->user->setFlash('warning', 'اطلاعات قرارداد شما در انتظار تایید می باشد،لطفا پس از تایید اطلاعات مجددا تلاش کنید.');
                $this->redirect(array('/publishers/panel/account'));
            }
            if (!$user->publisher_id) {
                $devIdRequestModel = UserDevIdRequests::model()->findByAttributes(array('user_id' => Yii::app()->user->getId()));
                if ($devIdRequestModel)
                    Yii::app()->user->setFlash('warning', 'درخواست شما برای شناسه ناشر در انتظار تایید می باشد، لطفا شکیبا باشید.');
                else
                    Yii::app()->user->setFlash('failed', 'شناسه ناشر تنظیم نشده است. برای ثبت کتاب شناسه ناشر الزامیست.');
                $this->redirect(array('/publishers/panel/account'));
            }
            Yii::app()->getModule('setting');
            $tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
            if (!is_dir($tmpDIR))
                mkdir($tmpDIR);
            $bookIconsDIR = Yii::getPathOfAlias("webroot") . '/uploads/books/icons/';
            if (!is_dir($bookIconsDIR))
                mkdir($bookIconsDIR);
            $bookIconsThumbDIR = Yii::getPathOfAlias("webroot") . '/uploads/books/icons/150x150/';
            if (!is_dir($bookIconsThumbDIR))
                mkdir($bookIconsThumbDIR);
            $tmpUrl = Yii::app()->baseUrl.'/uploads/temp/';

            Yii::app()->theme = 'market';
            $this->layout = '//layouts/panel';
            $model = new Books;
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model);
            $icon = array();
            if (isset($_POST['Books'])) {
                $iconFlag = false;
                if (isset($_POST['Books']['icon']) && file_exists($tmpDIR . $_POST['Books']['icon'])) {
                    $file = $_POST['Books']['icon'];
                    $icon = array(array('name' => $file, 'src' => $tmpUrl . '/' . $file, 'size' => filesize($tmpDIR . $file), 'serverName' => $file,));
                    $iconFlag = true;
                }
                $model->attributes = $_POST['Books'];
                $model->publisher_id = $user->user_id;
                $model->confirm = 'pending';
                if ($model->save()) {
                    if ($iconFlag) {
                        $thumbnail = new Imager();
                        $thumbnail->createThumbnail($tmpDIR . $model->icon, 150, 150, false, $bookIconsThumbDIR . $model->icon);
                        @rename($tmpDIR . $model->icon,$bookIconsDIR . $model->icon);
                    }
                    Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد. لطفا مراحل بعدی را نیز انجام دهید.');
                    $this->redirect(array('/publishers/books/update/' . $model->id.'?step=2'));
                } else {
                    Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
                }
            }
            $this->render('create', array(
                'model' => $model,
                'icon' => $icon,
                'tax' => SiteSetting::model()->findByAttributes(array('name' => 'tax'))->value,
                'commission' => SiteSetting::model()->findByAttributes(array('name' => 'commission'))->value,
            ));
        } else {
            Yii::app()->user->setFlash('failed', 'از طریق مدیریت اقدام کنید');
            $this->redirect(array('/admins/dashboard'));
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $step = 1;
        Yii::app()->theme = 'market';
        $this->layout = '//layouts/panel';
        $model = $this->loadModel($id);
        if ($model->publisher_id != Yii::app()->user->getId()) {
            Yii::app()->user->setFlash('images-failed', 'شما اجازه دسترسی به این صفحه را ندارید.');
            $this->redirect($this->createUrl('/publishers/panel'));
        }
        $tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
        if (!is_dir($tmpDIR))
            mkdir($tmpDIR);
        $tmpUrl = Yii::app()->createAbsoluteUrl('/uploads/temp/');
        $bookIconsDIR = Yii::getPathOfAlias("webroot") . '/uploads/books/icons/';
        $bookImagesDIR = Yii::getPathOfAlias("webroot") . '/uploads/books/images/';
        $bookFilesDIR = Yii::getPathOfAlias("webroot") . "/uploads/books/files/";
        if (!is_dir($bookFilesDIR))
            mkdir($bookFilesDIR);
        $bookIconsUrl = Yii::app()->createAbsoluteUrl('/uploads/books/icons');
        $bookImagesUrl = Yii::app()->createAbsoluteUrl('/uploads/books/images');
        $bookFilesUrl = Yii::app()->createAbsoluteUrl("/uploads/books/files/");

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        $icon = array();
        if (!is_null($model->icon))
            $icon = array(
                'name' => $model->icon,
                'src' => $bookIconsUrl . '/' . $model->icon,
                'size' => filesize($bookIconsDIR . $model->icon),
                'serverName' => $model->icon
            );
        $images = array();
        if ($model->images)
            foreach ($model->images as $image)
                if (file_exists($bookImagesDIR . $image->image))
                    $images[] = array(
                        'name' => $image->image,
                        'src' => $bookImagesUrl . '/' . $image->image,
                        'size' => filesize($bookImagesDIR . $image->image),
                        'serverName' => $image->image,
                    );

        if (isset($_POST['packages-submit'])) {
            if (empty($model->packages))
                Yii::app()->user->setFlash('failed', 'نوبت چاپ ای تعریف نشده است.');
            else
                $this->redirect($this->createUrl('/publishers/books/update/' . $model->id . '?step=3'));
        }

        if (isset($_POST['Books'])) {
            $iconFlag = false;
            if (isset($_POST['Books']['icon']) && file_exists($tmpDIR . $_POST['Books']['icon']) && $_POST['Books']['icon'] != $model->icon) {
                $file = $_POST['Books']['icon'];
                $icon = array(array('name' => $file, 'src' => $tmpUrl . '/' . $file, 'size' => filesize($tmpDIR . $file), 'serverName' => $file,));
                $iconFlag = true;
            }
            $model->attributes = $_POST['Books'];
            $model->confirm = 'pending';
            if ($model->save()) {
                if ($iconFlag) {
                    $thumbnail = new Imager();
                    $thumbnail->createThumbnail($tmpDIR . $model->icon, 150, 150, false, $bookIconsDIR . $model->icon);
                    @rename($tmpDIR . $model->icon,$bookIconsDIR . $model->icon);
                }
                Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ویرایش شد.');
                $this->redirect(array('/publishers/books/update/' . $model->id . '?step=2'));
            } else {
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
            }
        }

        if (isset($_GET['step']) && !empty($_GET['step']))
            $step = (int)$_GET['step'];

        $criteria = new CDbCriteria();
        $criteria->addCondition('book_id=:book_id');
        $criteria->params = array(
            ':book_id' => $id,
        );
        $packagesDataProvider = new CActiveDataProvider('BookPackages', array('criteria' => $criteria));

        Yii::app()->getModule('setting');
        $this->render('update', array(
            'model' => $model,
            'imageModel' => new BookImages(),
            'images' => $images,
            'icon' => $icon,
            'packagesDataProvider' => $packagesDataProvider,
            'step' => $step,
            'tax' => SiteSetting::model()->findByAttributes(array('name' => 'tax'))->value,
            'commission' => SiteSetting::model()->findByAttributes(array('name' => 'commission'))->value,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        Books::model()->updateByPk($id, array('deleted' => 1));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/publishers/panel'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Books the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Books::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Books $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'books-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionImages($id)
    {
        $tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
        $uploadDir = Yii::getPathOfAlias("webroot") . '/uploads/books/images/';
        if (isset($_POST['BookImages']['image'])) {
            $flag = true;
            foreach ($_POST['BookImages']['image'] as $image) {
                if (file_exists($tempDir . $image)) {
                    $model = new BookImages();
                    $model->book_id = (int)$id;
                    $model->image = $image;
                    rename($tempDir . $image, $uploadDir . $image);
                    if (!$model->save(false))
                        $flag = false;
                }
            }
            if ($flag) {
                Yii::app()->user->setFlash('images-success', 'اطلاعات با موفقیت ثبت شد.');
                $this->redirect($this->createUrl('/publishers/panel'));
            } else
                Yii::app()->user->setFlash('images-failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        } else
            Yii::app()->user->setFlash('images-failed', 'تصاویر کتاب را آپلود کنید.');
        $this->redirect('update/' . $id . '/?step=3');
    }

    /**
     * Save book package info
     */
    public function actionSavePackage()
    {
        if (isset($_POST['book_id'])) {
            $uploadDir = Yii::getPathOfAlias("webroot") . '/uploads/books/files';
            $tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp';
            if (!is_dir($uploadDir))
                mkdir($uploadDir);

            $model = new BookPackages();
            $model->book_id = $_POST['book_id'];
            $model->create_date = time();
            $model->for = $_POST['for'];
            $model->price = $_POST['price'];
            $model->printed_price = $_POST['printed_price'];
            $model->version = $_POST['version'];
            $model->package_name = $_POST['package_name'];
            $model->file_name = $_POST['Books']['file_name'];

            if ($model->save()) {
                $response = ['status' => true, 'fileName' => CHtml::encode($model->file_name)];
                rename($tempDir . DIRECTORY_SEPARATOR . $_POST['Books']['file_name'], $uploadDir . DIRECTORY_SEPARATOR . $model->file_name);
            } else {
                $response = ['status' => false, 'message' => $model->getError('package_name')];
                @unlink($tempDir . '/' . $_POST['Books']['file_name']);
            }

            echo CJSON::encode($response);
            Yii::app()->end();
        }
    }
}