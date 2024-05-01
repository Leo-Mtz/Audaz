<?php

namespace app\controllers;

use Yii;
use app\models\Entradas;
use app\models\EntradasSearch;
use app\models\CatEventos;
use app\models\CatProductos;
use app\models\CatEmpleados;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * EntradasController implements the CRUD actions for Entradas model.
 */
class EntradasController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Entradas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntradasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Entradas model.
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
     * Creates a new Entradas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Entradas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_entradas]);
        }

        $empleados= ArrayHelper::map(CatEmpleados::find()->all(),'id_empleado','nombre');//'paterno','materno');
        $eventos= ArrayHelper::map(CatEventos::find()->all(),'id_evento','evento');
        $productos=ArrayHelper::map(CatProductos::find()->all(),'id_producto','id_sabor','id_presentacion');

        
        return $this->render('create', [
            
        'model' => $model,
        'empleados' => $empleados,
        'eventos' => $eventos,
        'productos'=> $productos,
        ]);
    }

    /**
     * Updates an existing Entradas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_entradas]);
        }

        $empleados= ArrayHelper::map(CatEmpleados::find()->all(),'id_empleado');
        $eventos= ArrayHelper::map(CatEventos::find()->all(),'id_evento','evento');
        $productos=ArrayHelper::map(CatProductos::find()->all(),'id_producto');


        return $this->render('update', [
          'model' => $model,     
          'empleados' => $empleados,
          'eventos' => $eventos,
         'productos'=> $productos,
        ]);
    }

    /**
     * Deletes an existing Entradas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Entradas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Entradas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Entradas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
