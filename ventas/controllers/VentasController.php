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


<<<<<<< HEAD
    public function actionCreate()
    {
        $model = new Ventas();
    
        // Set the fecha attribute to the current date
        $model->fecha = Yii::$app->formatter->asDate('now', 'php:Y-m-d');
        date_default_timezone_set('America/Mexico_City'); // Set the timezone to Mexico City
=======
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
    

>>>>>>> main
    
        $productos = CatProductos::find()->all();
        $productosDropdown = [];
        foreach ($productos as $producto) {
            $productosDropdown[$producto->id_producto] = $producto->sabores->sabor . ' - ' . $producto->presentaciones->presentacion;
        }
<<<<<<< HEAD
    
        if ($model->load(Yii::$app->request->post())) {
            $precio = $model->getPrecioUnitario($model->id_producto); // Call the method on the model instance
            $model->precio_unitario = $precio;
    
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id_venta]);
            }
        }
    
        return $this->render('create', [
            'model' => $model,
            'productosDropdown' => $productosDropdown,
            'id_producto' => $model->id_producto,
        ]);
    }
    


=======


        return $this->render('create', [

            'model'=>$model,
            //'vendedor'=>$vendedor,
            'productosDropdown'=>$productosDropdown,
           // 'eventos'=>$eventos
            




        ]);

    }

>>>>>>> main
    public function actionDelete($id){

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionUpdate($id){
<<<<<<< HEAD
        

        $model = $this->findModel($id);

         // Set the fecha attribute to the current date
        $model->fecha = Yii::$app->formatter->asDate('now', 'php:Y-m-d');
        date_default_timezone_set('America/Mexico_City'); // Set the timezone to Mexico City

        
        if ($model->load(Yii::$app->request->post())) { // Load POST data

   

            if ($model->save()) { // Save model
                return $this->redirect(['view', 'id' => $model->id_venta]); // Redirect to view if saved successfully
            } else {
                var_dump($model->errors); // Debug errors if save fails
            }
        }
        
        $productos = CatProductos::find()->all();
        $productosDropdown = [];
        foreach ($productos as $producto) {
            $productosDropdown[$producto->id_producto] = $producto->sabores->sabor . ' - ' . $producto->presentaciones->presentacion;
        }


        return $this->render('update', [

            'model'=>$model,
            //'vendedor'=>$vendedor,
            'productosDropdown'=>$productosDropdown,
           // 'eventos'=>$eventos
        ]);

    }
    

=======

        $model= $this->findModel($id);

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


       return $this->render('update', [

           'model'=>$model,
           //'vendedor'=>$vendedor,
           'productosDropdown'=>$productosDropdown,
          // 'eventos'=>$eventos
           
       ]);




    }

    
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
>>>>>>> main

    protected function findModel($id){

        if (($model = Ventas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

<<<<<<< HEAD
    
    /**
     * Retrieves the price of a product based on its ID.
     *
     * @param int $id The ID of the product.
     * @return array The price of the product, or 0 if not found.
     */
    public function actionGetProductPrice($id)
    {
        // Set the response format to JSON.
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        // Find the product with the given ID.
        $producto = CatProductos::findOne($id);
        
        // Return the price of the product if found, otherwise return 0.
        return $producto ? ['precio' => $producto->precio] : ['precio' => 0];
    }


    
}


=======
    public function actionGetPrecioUnitario($id)
    {
        $producto = CatProductos::findOne($id);
        if ($producto !== null) {
            return json_encode(['precio' => $producto->precio]);
        }
        return json_encode(['precio' => 0]);
    }
    

}
>>>>>>> main
