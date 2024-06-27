<?php


namespace app\controllers;

use Yii;
use app\models\Ventas;
use app\Models\CatProductos;
use app\models\VentasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class VentasController extends \yii\web\Controller
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

        $searchModel = new VentasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreate(){

        $model = new Ventas();

         // Set the fecha attribute to the current date
        $model->fecha = Yii::$app->formatter->asDate('now', 'php:Y-m-d');
        date_default_timezone_set('America/Mexico_City'); // Set the timezone to Mexico City

        
        if ($model->load(Yii::$app->request->post())) {
                $model->save();
        
                // Get the automatically generated id_venta
                $idVenta = $model->id_venta;
        
                if (isset(Yii::$app->request->post('Ventas')['productos'])) {
                    $productos = Yii::$app->request->post('Ventas')['productos'];
                    foreach ($productos as $producto) {
                        // Directly insert the product into the Ventas table
                        $ventaProducto = new Ventas();
                        $ventaProducto->id_venta = $model->id_venta;
                        $ventaProducto->id_producto = $producto['id_producto'];
                        $ventaProducto->cantidad_vendida = $producto['cantidad_vendida'];
                        $ventaProducto->precio_total_producto = $producto['precio_total_producto'];
                        $ventaProducto->save();
                    }
                }
        
                return $this->redirect(['view', 'id' => $model->id_venta]);
            } else {
                var_dump($model->errors);
            }
    

    
        $productos = CatProductos::find()->all();
        $productosDropdown = [];
        foreach ($productos as $producto) {
            $productosDropdown[$producto->id_producto] = $producto->sabores->sabor . ' - ' . $producto->presentaciones->presentacion;
        }


        return $this->render('create', [

            'model'=>$model,
            //'vendedor'=>$vendedor,
            'productosDropdown'=>$productosDropdown,
           // 'eventos'=>$eventos
            




        ]);

    }

    public function actionDelete($id){

        echo 
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionUpdate($id){

        $model= new Ventas();
        return $this->render('update');
    }

    
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id){

        if (($model = Ventas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}