<?php

class ShopPaymentController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array actions type list
	 */
	public static function actionsType()
	{
		return array(
			'backend' => array('admin', 'view', 'delete', 'update', 'changeStatus', 'order')
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess',
			'postOnly + delete',
			'ajaxOnly + changeStatus',
		);
	}

	public function actions()
	{
		return array(
			'order' => array(
				'class' => 'ext.yiiSortableModel.actions.AjaxSortingAction',
			)
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ShopPaymentMethod;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShopPaymentMethod']))
		{
			$model->attributes=$_POST['ShopPaymentMethod'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShopPaymentMethod']))
		{
			$model->attributes=$_POST['ShopPaymentMethod'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        $this->layout='//layouts/column1';
		$model=new ShopPaymentMethod('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ShopPaymentMethod']))
			$model->attributes=$_GET['ShopPaymentMethod'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ShopPaymentMethod the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ShopPaymentMethod::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ShopPaymentMethod $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shop-payment-method-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionChangeStatus(){
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id = (int)$_GET['id'];
            $model = $this->loadModel($id);
            if($model->changeStatus()->save())
                echo CJSON::encode(['status' => true]);
            else
                echo CJSON::encode(['status' => false, 'msg' => 'در تغییر وضعیت این آیتم مشکلی بوجود آمده است! لطفا مجددا بررسی کنید.']);
        }
	}
}
