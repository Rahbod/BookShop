<?php

class RolesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

	public $pageTitle = 'مدیریت نقش مدیران';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
			array('allow',  // allow all users to perform 'index' and 'views' actions
				'actions' => array('index', 'create', 'update', 'admin', 'delete'),
				'roles' => array('superAdmin'),
			),
			array('deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'views' page.
	 */
	public function actionCreate()
	{
		$this->pageTitle = 'افزودن نقش جدید';
		$model = new AdminRoles('create');

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if (isset($_POST['AdminRoles'])) {
			var_dump($_POST['AdminRoles']);
			exit;
			$model->attributes = $_POST['AdminRoles'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
				$this->refresh();
			} else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است.');
		}

		$this->render('create', array(
			'model' => $model,
			'actions' => $this->getAllActions('backend'),
		));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'views' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$this->pageTitle = 'ویرایش نقش';
		$model = $this->loadModel($id);
		$model->setScenario('update');
		// Uncomment the following line if AJAX validation is needed

		$this->performAjaxValidation($model);

		if (isset($_POST['AdminRoles'])) {
			$model->attributes = $_POST['AdminRoles'];
			if ($model->validate()) {
				if ($model->save())
					echo json_encode(['result' => 'success', 'msg' => 'اطلاعات با موفقیت ثبت شد.']);
				else
					echo json_encode(['result' => 'failed', 'msg' => 'در ثبت اطلاعات خطایی رخ داده است.']);
			} else
				echo json_encode(['result' => 'failed', 'msg' => $this->implodeErrors($model)]);
			Yii::app()->end();
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if ($id != Yii::app()->user->id)
			$this->loadModel($id)->delete();
		// if AJAX request (triggered by deletion via admin grid views), we should not redirect the browser
		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->actionAdmin();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new AdminRoles('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['AdminsRoles']))
			$model->attributes = $_GET['AdminsRoles'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Admins the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		if ($id == 1)
			throw new CHttpException(403, 'شما اجازه دسترسی به این صفحه را ندارید.');

		$model = AdminRoles::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Admins $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-roles-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}