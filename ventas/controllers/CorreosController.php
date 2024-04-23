<?php

namespace app\controllers;

use Yii;
use app\models\CorreosAlerta;
use app\models\CorreosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * CorreosController implements the CRUD actions for CorreosAlerta model.
 */
class CorreosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'activate'],
                'rules' => [
					[
						'allow' => true,
						'actions' => ['index', 'view', 'create', 'update', 'delete', 'activate'],
						'roles' => ['admin'],
					],
				],
				'denyCallback' => function ($rule, $action) {
					throw new \yii\web\ForbiddenHttpException;
				}
            ],
        ];
    }

    /**
     * Lists all CorreosAlerta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CorreosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CorreosAlerta model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CorreosAlerta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CorreosAlerta();

        if( $model->load(Yii::$app->request->post()) ) {
			if( $model->validate() ){
				$model->save();
				Yii::$app->utilFunctions->log(Yii::$app->user->identity->id,"CREAR CORREO","CORREO ".$model->id." CREADO");
				return $this->redirect(['view', 'id' => $model->id]);
			}
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CorreosAlerta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->utilFunctions->log(Yii::$app->user->identity->id,"ACTUALIZAR CORREO","CORREO ".$model->id." ACTUALIZADO");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CorreosAlerta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		$model = $this->findModel($id);
		$model->updateAttributes(['borrado' => "1"]);
		
		Yii::$app->utilFunctions->log(Yii::$app->user->identity->id,"ELIMINAR CORREO","CORREO ".$model->id." ELIMINADO");

        return $this->redirect(['index']);
    }
	
	public function actionActivate($id)
    {
		$model = $this->findModel($id);
		$model->updateAttributes(['borrado' => "0"]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the CorreosAlerta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CorreosAlerta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CorreosAlerta::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
