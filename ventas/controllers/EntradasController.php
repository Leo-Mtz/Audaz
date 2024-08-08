<?php

namespace app\controllers;

use Yii;
use app\models\Entradas;
use app\models\EntradasSearch;
use app\models\CatEventos;
use app\models\CatSabores;
use app\models\CatEmpleados;
use yii\web\Controller;
use app\models\ProductosPorEntradas;
use app\models\CatProductos;
use app\models\CatPresentaciones;
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
         
         // Set the current date
         $clientDate = Yii::$app->request->post('client_date', date('Y-m-d'));
         $model->fecha = $clientDate;
     
         var_dump(Yii::$app->request->post());
         
 
         if ($model->load(Yii::$app->request->post()) && $model->save()) {

            var_dump("Hola mundo");
            
             if (isset(Yii::$app->request->post('Entradas')['entradas'])) {
                 // Debug output to see the raw data

                 var_dump("Hola mundo 2");
            
                 $entradas = Yii::$app->request->post('Entradas')['entradas'];
                 
                 var_dump($entradas);

                 
                 foreach ($entradas as $entradaData) {

                     $idProducto = $this->getIdProducto($entradaData['id_sabor'], $entradaData['id_presentacion']);
                     
                     $entradas = new ProductosPorEntradas();
                     $entradas->id_entradas = $model->id_entradas;
                     $entradas->id_sabor = $entradaData['id_sabor'];
                     $entradas->id_presentacion = $entradaData['id_presentacion'];
                     $entradas->id_producto = $idProducto; // Set id_producto
                     $entradas->cantidad_entradas_producto = $entradaData['cantidad_entradas_producto'];
                     

                     var_dump($entradas->attributes);
                     if (!$entradas->save()) {
                         Yii::debug($entradas->errors, 'productoPorEntradas_errors');
                         var_dump($entradas->errors);
                         exit; // Stop execution for debugging
                     }
                 }
                 
                 return $this->redirect(['view', 'id' => $model->id_entradas]);
             }
         } else {
             Yii::debug($model->errors, 'entradas_save_errors');
             var_dump($model->errors);
         }
     
         // Prepare data for dropdowns
         $empleados = ArrayHelper::map(CatEmpleados::find()->all(), 'id_empleado', function($model) {
             return $model['nombre'].' '.$model['paterno'].' '.$model['materno'];
         });
         $eventos = ArrayHelper::map(CatEventos::find()->all(), 'id_evento', 'evento');
         $saboresIds = CatProductos::find()->select('id_sabor')->distinct()->column();
         $sabores1 = CatSabores::find()->where(['id_sabor' => $saboresIds])->all();
         $sabores = ArrayHelper::map($sabores1, 'id_sabor', 'sabor');
         $presentacionesList = [];
         
         return $this->render('create', [
             'model' => $model,
             'empleados' => $empleados,
             'eventos' => $eventos,
             'sabores' => $sabores,
             'presentacionesList' => $presentacionesList
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


    
    public function actionGetPresentaciones($idSabor)
{
    

    $idSabor = (int) $idSabor;

    if ($idSabor <= 0) {
        return json_encode(['error' => 'Invalid sabor ID']);
    }

    try {
        // Fetch all presentaciones for the given sabor
        $presentaciones = CatPresentaciones::find()
            ->joinWith('catProductos') // Ensure this relation exists
            ->where(['cat_productos.id_sabor' => $idSabor])
            ->all();

        if (empty($presentaciones)) {
            return json_encode([]);
        }

        // Only include the 'presentacion' value in the response
        $presentacionesList = [];
        foreach ($presentaciones as $presentacion) {
            $presentacionesList[$presentacion->id_presentacion] = $presentacion->presentacion; }

        return json_encode($presentacionesList);
    } catch (\Exception $e) {
        Yii::error($e->getMessage(), __METHOD__);
        return json_encode(['error' => 'An error occurred while fetching presentaciones: ' . $e->getMessage()]);
    }
}

public function getIdProducto($idSabor, $idPresentacion)
{
    $producto = CatProductos::find()
        ->where(['id_sabor' => $idSabor, 'id_presentacion' => $idPresentacion])
        ->one();

    if ($producto) {
        return $producto->id_producto;
    }

    return null; // or handle the case where no matching product is found
}



}

