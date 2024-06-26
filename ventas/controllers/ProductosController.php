<?php

namespace app\controllers;

use Yii;
use app\models\CatProductos;
use app\models\CatSabores;
use app\models\CatPresentaciones;
use app\models\CatProductosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ProductosController implements the CRUD actions for CatProductos model.
 */
class ProductosController extends Controller
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
     * Lists all CatProductos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatProductosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CatProductos model.
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
     * Creates a new CatProductos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CatProductos();

        if ($model->load(Yii::$app->request->post())) { // Load POST data
            if ($model->save()) { // Save model
                return $this->redirect(['view', 'id' => $model->id_producto]); // Redirect to view if saved successfully
            } else {
                var_dump($model->errors); // Debug errors if save fails
            }
        }
		$sabores = ArrayHelper::map(CatSabores::find()->all(),'id_sabor','sabor');
		$presentaciones = ArrayHelper::map(CatPresentaciones::find()->all(),'id_presentacion','presentacion');


        return $this->render('create', [
            'model' => $model,
            'sabores' => $sabores,
            'presentaciones' => $presentaciones,
        ]);
    }

    /**
     * Updates an existing CatProductos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_producto]);
        }
		
		 // Obtener los sabores y presentaciones
        $sabores = ArrayHelper::map(CatSabores::find()->all(),'id_sabor','sabor');
        $presentaciones = ArrayHelper::map(CatPresentaciones::find()->all(),'id_presentacion','presentacion');


        return $this->render('create', [
            'model' => $model,
            'sabores' => $sabores,
            'presentaciones' => $presentaciones,
        ]);
    }

    /**
     * Deletes an existing CatProductos model.
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
     * Finds the CatProductos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CatProductos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CatProductos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
