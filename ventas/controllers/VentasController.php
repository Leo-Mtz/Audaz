<?php


namespace app\controllers;

use Yii;
use app\models\Ventas;
use app\Models\CatProductos;
use app\models\ProductosPorVenta;
use app\models\CatEventos;
use app\models\VentasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

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

    public function actionAgregarTicket($id)
    {
        $model = $this->findModel($id);
        $productosPorVenta = ProductosPorVenta::findAll(['id_venta' => $id]);

        // Render the ticket view
        return $this->render('ticket', [
            'model' => $model,
            'productosPorVenta' => $productosPorVenta,
        ]);
    }

<<<<<<< HEAD
<<<<<<< HEAD
    public function actionCreate()
    {
        $model = new Ventas();
    
        // Set the fecha attribute to the current date
        $model->fecha = Yii::$app->formatter->asDate('now', 'php:Y-m-d');
        date_default_timezone_set('America/Mexico_City'); // Set the timezone to Mexico City
=======
    public function actionCreate(){

=======
    
    public function actionCreate()
    {
>>>>>>> main
        $model = new Ventas();
    
      
        $model->fecha = Yii::$app->formatter->asDate('now', 'php:Y-m-d');
        date_default_timezone_set('America/Mexico_City'); // Set the timezone to Mexico City
    
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Print the entire POST request data
            echo '<pre>';
            var_dump(Yii::$app->request->post());
            echo '</pre>';
    
            if (isset(Yii::$app->request->post('Ventas')['productos'])) {
                $productos = Yii::$app->request->post('Ventas')['productos'];
    
                // Print the products array
                echo '<pre>';
                var_dump($productos);
                echo '</pre>';
    
                foreach ($productos as $productoData) {
    
                    $productoPorVenta = new ProductosPorVenta();
                    $productoPorVenta->id_venta = $model->id_venta;
                    $productoPorVenta->id_producto = $productoData['id_producto'];
                    $productoPorVenta->cantidad_vendida = $productoData['cantidad_vendida'];
                    $productoPorVenta->precio_unitario = $productoData['precio_unitario'];
                    $productoPorVenta->subtotal_producto = $productoData['subtotal_producto'];
    
                    if (!$productoPorVenta->save()) {
                        Yii::debug($productoPorVenta->errors, 'productoPorVenta_errors');
                    }
                }
            } else {
                echo 'No productos data found in post request';
            }
    
<<<<<<< HEAD

>>>>>>> main
=======
            return $this->redirect(['view', 'id' => $model->id_venta]);
        } else {
            Yii::debug($model->errors, 'ventas_errors');
        }
<<<<<<< HEAD
>>>>>>> main
=======

        $id_evento= Yii::$app->session->get('id_evento');
>>>>>>> main
    
        $productos = CatProductos::find()->all();
        $productosDropdown = [];
    
        foreach ($productos as $producto) {
            $productosDropdown[$producto->id_producto] = $producto->sabores->sabor . ' - ' . $producto->presentaciones->presentacion;
        }
<<<<<<< HEAD
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


=======
    
<<<<<<< HEAD
        $eventos = ArrayHelper::map(CatEventos::find()->all(), 'id_evento', 'evento');
    
>>>>>>> main
=======
     
>>>>>>> main
        return $this->render('create', [
            'model' => $model,
            'productosDropdown' => $productosDropdown,
            'id_evento' => $id_evento,
        ]);
    }
    


<<<<<<< HEAD
>>>>>>> main
    public function actionDelete($id){

        $this->findModel($id)->delete();

=======
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
    
        // Delete related productos_por_venta records first
        $productosPorVenta = ProductosPorVenta::findAll(['id_venta' => $id]);
        foreach ($productosPorVenta as $productoPorVenta) {
            $productoPorVenta->delete();
        }
    
        // Now delete the venta record
        $model->delete();
    
>>>>>>> main
        return $this->redirect(['index']);
    }
    public function actionUpdate($id)
{
    $model = $this->findModel($id);

<<<<<<< HEAD

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

        $model->fecha = Yii::$app->formatter->asDate('now', 'php:Y-m-d');
=======
    $model->fecha = Yii::$app->formatter->asDate('now', 'php:Y-m-d');
>>>>>>> main
    date_default_timezone_set('America/Mexico_City'); // Set the timezone to Mexico City

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if (isset(Yii::$app->request->post('Ventas')['productos'])) {
            $productos = Yii::$app->request->post('Ventas')['productos'];

            // Delete old productos for the current venta
            ProductosPorVenta::deleteAll(['id_venta' => $model->id_venta]);

            foreach ($productos as $productoData) {
                $productoPorVenta = new ProductosPorVenta();
                $productoPorVenta->id_venta = $model->id_venta;
                $productoPorVenta->id_producto = $productoData['id_producto'];
                $productoPorVenta->cantidad_vendida = $productoData['cantidad_vendida'];
                $productoPorVenta->precio_unitario = $productoData['precio_unitario'];
                $productoPorVenta->subtotal_producto = $productoData['subtotal_producto'];

                if (!$productoPorVenta->save()) {
                    Yii::debug($productoPorVenta->errors, 'productoPorVenta_errors');
                }
            }
        }

        return $this->redirect(['view', 'id' => $model->id_venta]);
    } else {
        Yii::debug($model->errors, 'ventas_errors');
    }

    $id_evento = Yii::$app->session->get('id_evento');

    $productos = CatProductos::find()->all();
    $productosDropdown = [];

    foreach ($productos as $producto) {
        $productosDropdown[$producto->id_producto] = $producto->sabores->sabor . ' - ' . $producto->presentaciones->presentacion;
    }

    // Fetch the related products for the current sale
    $dataProvider = new \yii\data\ActiveDataProvider([
        'query' => ProductosPorVenta::find()->where(['id_venta' => $model->id_venta]),
        'pagination' => false,
    ]);

    return $this->render('update', [
        'model' => $model,
        'productosDropdown' => $productosDropdown,
        'id_evento' => $id_evento,
        'dataProvider' => $dataProvider,
    ]);
}

    
        
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
>>>>>>> main

    public function actionTicket($id)
    {

        return $this->render('ticket', [
            'model' => $this->findModel($id),
            'productosPorVenta' => ProductosPorVenta::find()->where(['id_venta' => $id])->all(),    
        ]);
    }

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
            $precioUnitario = $producto->precio;
            $productoData = [
                'precio' => $precioUnitario,
                'precio_unitario' => $precioUnitario,
            ];
            return json_encode($productoData);
        }
        return json_encode(['precio' => 0, 'precio_unitario' => 0]);
    }


}
>>>>>>> main
