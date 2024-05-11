<?php

namespace app\controllers;


use Yii;
use app\models\Salidas;
use app\models\SalidasSearch;
use app\models\CatEventos;
use app\models\CatProductos;
use app\models\CatEmpleados;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * SalidasController implements the CRUD actions for Salidas model.
 */
class SalidasController extends Controller
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
     * Lists all Salidas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SalidasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Salidas model.
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
     * Creates a new Salidas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Salidas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_salidas]);
        }

       
        $empleados= ArrayHelper::map(CatEmpleados::find()->all(),'id_empleado', function($model, $defaultValue) {
            return $model['nombre'].' '.$model['paterno'].' '.$model['materno'];
        });

        $eventos= ArrayHelper::map(CatEventos::find()->all(),'id_evento','evento');

        
           
    $productos = CatProductos::find()->all();
    $productosDropdown = [];
        foreach ($productos as $producto) {
            $productosDropdown[$producto->id_producto] = $producto->sabores->sabor . ' - ' . $producto->presentaciones->presentacion;
        }

        return $this->render('create', [
           'model' => $model, 
          'empleados' => $empleados,
          'eventos' => $eventos,
         'productos'=> $productosDropdown,
        ]);
    }

    /**
     * Updates an existing Salidas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) { // Load POST data
            if ($model->save()) { // Save model
                return $this->redirect(['view', 'id' => $model->id_salidas]); // Redirect to view if saved successfully
            } else {
                var_dump($model->errors); // Debug errors if save fails
            }
        }

           
        $empleados= ArrayHelper::map(CatEmpleados::find()->all(),'id_empleado', function($model, $defaultValue) {
            return $model['nombre'].' '.$model['paterno'].' '.$model['materno'];
        });

        $eventos= ArrayHelper::map(CatEventos::find()->all(),'id_evento','evento');

        
        $productos = ArrayHelper::map(CatProductos::find()->all(), 'id_producto', function($model, $defaultValue) {
            return $model['id_sabor'] . ' - ' . $model['id_presentacion'];
        });
    
        return $this->render('update', [
            'model' => $model,
            'empleados' => $empleados,
            'eventos' => $eventos,
           'productos'=> $productos,
        ]);
    }

    /**
     * Deletes an existing Salidas model.
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
     * Finds the Salidas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Salidas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Salidas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
