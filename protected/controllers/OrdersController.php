<?php

class OrdersController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				//'actions'=>array('calend','admin','update'),
				'users'=>array('admin'),
			),
			array('deny', // allow admin user to perform 'admin' and 'delete' actions
                'users'=>array('admin'),
			),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','index','view'),
                'users'=>array('@'),
            ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
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
		$model=new Orders;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Orders']))
		{
			$model->attributes=$_POST['Orders'];
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

		if(isset($_POST['Orders']))
		{
			$model->attributes=$_POST['Orders'];
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
	/*public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}*/

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $criteria=new CDbCriteria;

        $criteria->compare('user_id',Yii::app()->user->id);

        $dataProvider = new CActiveDataProvider('Orders', array(
            'criteria'=>$criteria,
        ));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Orders('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Orders']))
			$model->attributes=$_GET['Orders'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    public function actionCalend()
    {
        $this->layout = '//layouts/column1';
        $month = date('m');
        if(Yii::app()->request->isAjaxRequest) {
            $data['success'] = false;
            $month = date('m',intval($_GET['month']));
            if (isset($_GET['order']) AND isset($_GET['status'])) {
                $_order = Orders::model()->findByPk(intval($_GET['order']));
                $_order->confirmed = $_GET['status'];
                $data['thx'] = ($_order->save(true,array('confirmed'))) ? 'Изменения внесены!' : 'Ошибка при сохранении данных';
            }
        }

        $model['month'] = $month;
        $model['monthStart'] = mktime(0,0,0,$month,1,date('Y'));
        $model['monthNext'] = mktime(0,0,0,$month+1,1,date('Y'));
        $model['monthPrev'] = mktime(0,0,0,$month-1,1,date('Y'));
        //запрос на заявки у которых старт меньше или равен текущему месяцу, а окончание больше или равно текущему месяцу
        $monthEnd=date('Y-m-d',mktime(0,0,0,$month+1,1,date('Y')));
        $monthStart=date('Y-m-d',mktime(0,0,0,$month,1,date('Y')));
        $orders=Orders::model()->findAll('start<:monthEnd && end>=:monthStart',array(':monthEnd'=>$monthEnd,':monthStart'=>$monthStart));
        $profile = Profile::model()->findAll();
        foreach ($profile as $k=>$user) {
            $model['users'][$k] = array('id'=>$user->user_id,'first_name'=>$user->first_name,'last_name'=>$user->last_name);
            foreach ($orders as $order) {
                if ($user->user_id==$order->user_id) {
                    $start = strtotime($order->start);
                    $diff = ($start - mktime(0,0,0,$month,1,date('Y')))/24/3600;
                    $duration = $order->duration;
                    if ($diff<0) {
                        $duration = $duration+$diff;
                        $diff = 0;
                    }
                    $diff++;
                    if (($diff+$duration)>date('t',$model['monthStart'])) {
                        $duration = date('t',$model['monthStart']) - $diff;
                    }

                    $model['users'][$k]['orders'][] = array('start'=>$diff,'duration'=>$duration,'confirmed'=>$order->confirmed,'id'=>$order->id);
                }
            }
        }
        if(Yii::app()->request->isAjaxRequest) {
            $data['html'] = $this->renderPartial('_month',array(
                'model'=>$model
            ),true);
            $data['success'] = true;
            echo json_encode($data);
        } else
            $this->render('calend',array(
                'model'=>$model
            ));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Orders the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Orders::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'Запрашиваемая страница не существует.');
        if($model->user_id !== Yii::app()->user->id AND !Yii::app()->getModule('user')->isAdmin())
            throw new CHttpException(403,'Для Вас доступ к этой странице запрещён');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Orders $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='orders-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
