<?php

namespace app\controllers;

use Yii;
use app\models\Entradas;
use app\models\EntradasSearch;
use app\models\CatEventos;
use app\models\CatSabores;
use app\models\CatEmpleados;
use app\models\CatProductos;
use app\models\CatPresentaciones;
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
  
    // Set the fecha attribute to the current date
    $model->fecha = Yii::$app->formatter->asDate('now', 'php:Y-m-d');
    date_default_timezone_set('America/Mexico_City'); // Set the timezone to Mexico City

    

    if ($model->load(Yii::$app->request->post())) { // Load POST data
        if ($model->save()) { // Save model
            return $this->redirect(['view', 'id' => $model->id_entradas]); // Redirect to view if saved successfully
        } else {
            var_dump($model->errors); // Debug errors if save fails
        }

        
        // Procesar los campos de presentaciones
        $presentaciones = Yii::$app->request->post('Presentaciones', []);
        foreach ($presentaciones as $id_presentacion => $value) {
            // Aquí puedes guardar o procesar los valores como necesites
            // Ejemplo: guardar en una tabla relacionada
        }


   
    }

    $empleados = ArrayHelper::map(CatEmpleados::find()->all(), 'id_empleado', function($model, $defaultValue) {
        return $model['nombre'].' '.$model['paterno'].' '.$model['materno'];
    });
    $eventos = ArrayHelper::map(CatEventos::find()->all(), 'id_evento', 'evento');


    $saboresIds = CatProductos::find()
    ->select('id_sabor')
    ->distinct()
    ->column();

    $sabores1 = CatSabores::find()
        ->where(['id_sabor' => $saboresIds])
        ->all();

    $sabores = ArrayHelper::map($sabores1, 'id_sabor', 'sabor');
   

    $presentaciones = ArrayHelper::map(CatPresentaciones::find()->all(), 'presentacion', 'presentacion');
 
    $prueba = CatPresentaciones::find()
    ->select('id_presentacion')  
    ->where(['presentacion' => 'PRUEBA'])
    ->scalar();


    $ml375 = CatPresentaciones::find()
    ->select('id_presentacion')  
    ->where(['presentacion' => '375 ml'])
    ->scalar();


    $ml750 = CatPresentaciones::find()
    ->select('id_presentacion')  
    ->where(['presentacion' => '750 ml '])
    ->scalar();


    $onz16 = CatPresentaciones::find()
    ->select('id_presentacion')  
    ->where(['presentacion' => '16 onz'])
    ->scalar();

    $DosLitros = CatPresentaciones::find()
    ->select('id_presentacion')  
    ->where(['presentacion' => '2 ltrs'])
    ->scalar();

   
        return $this->render('create', [
            'model' => $model,
            'empleados' => $empleados,
             'eventos' => $eventos,
             'sabores'=> $sabores,
             'presentaciones'=> $presentaciones,
             'prueba' => $prueba,
             'ml375'=> $ml375,
             'ml750'=> $ml750,
             'onz16'=> $onz16,
             'DosLitros'=> $DosLitros,

            
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

 

    if ($model->load(Yii::$app->request->post())) { // Load POST data

   

        if ($model->save()) { // Save model
            return $this->redirect(['view', 'id' => $model->id_entradas]); // Redirect to view if saved successfully
        } else {
            var_dump($model->errors); // Debug errors if save fails
        }
    }

    $empleados = ArrayHelper::map(CatEmpleados::find()->all(), 'id_empleado', function($model, $defaultValue) {
        return $model['nombre'].' '.$model['paterno'].' '.$model['materno'];
    });
    $eventos = ArrayHelper::map(CatEventos::find()->all(), 'id_evento', 'evento');
    
    $sabores= ArrayHelper::map(CatSabores::find()->all(), 'id_sabor', 'sabor');
    
    $presentaciones = ArrayHelper::map(CatPresentaciones::find()->all(), 'presentacion', 'presentacion');
    $prueba = CatPresentaciones::find()
    ->select('id_presentacion')  
    ->where(['presentacion' => 'PRUEBA'])
    ->scalar();

    

   
    $ml375 = CatPresentaciones::find()
    ->select('id_presentacion')  
    ->where(['presentacion' => '375 ml'])
    ->scalar();


    $ml750 = CatPresentaciones::find()
    ->select('id_presentacion')  
    ->where(['presentacion' => '750 ml '])
    ->scalar();


    $onz16 = CatPresentaciones::find()
    ->select('id_presentacion')  
    ->where(['presentacion' => '16 onz'])
    ->scalar();

    $DosLitros = CatPresentaciones::find()
    ->select('id_presentacion')  
    ->where(['presentacion' => '2 ltrs'])
    ->scalar();

    return $this->render('update', [
        
        'model' => $model,
       'empleados' => $empleados,
        'eventos' => $eventos,
        'sabores'=> $sabores,
        'presentaciones'=> $presentaciones,
        'prueba' => $prueba,
        'ml375'=> $ml375,
        'ml750'=> $ml750,
        'onz16'=> $onz16,
        'DosLitros'=> $DosLitros,
      
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

    public function actionGetSabores()
    {
        $sabores = CatSabores::getSaboresDisponibles();
        return $this->asJson($sabores);
    }
}