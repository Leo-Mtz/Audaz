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
 

     //funcion para renderizar el index de ventas
    public function actionIndex()
    
    {

        $searchModel = new VentasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    //funcion para agregar ticket

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

    
    public function actionCreate()
    {
        $model = new Ventas();
    
      // Assuming you get the client's date here (e.g., from a request or session)
    $clientDate = Yii::$app->request->get('client_date', date('Y-m-d')); // Default to today's date

    // Set the date in the model
    $model->fecha = $clientDate;

    
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Print the entire POST request data
            echo '<pre>';
            var_dump(Yii::$app->request->post());
            echo '</pre>';
    
            if (isset(Yii::$app->request->post('Ventas')['productos'])) {
                $productos = Yii::$app->request->post('Ventas')['productos'];
    
              
    
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
    
            return $this->redirect(['view', 'id' => $model->id_venta]);
        } else {
            Yii::debug($model->errors, 'ventas_errors');
        }

        $id_evento= Yii::$app->session->get('id_evento');
    
        $productos = CatProductos::find()->all();
        $productosDropdown = [];
    
        foreach ($productos as $producto) {
            $productosDropdown[$producto->id_producto] = $producto->sabores->sabor . ' - ' . $producto->presentaciones->presentacion;
        }
    
     
        return $this->render('create', [
            'model' => $model,
            'productosDropdown' => $productosDropdown,
            'id_evento' => $id_evento,
        ]);
    }
    
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

        return $this->redirect(['index']);
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
    
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $productosData = Yii::$app->request->post('ProductosPorVenta', []);
            
            // Debugging output
            echo "Productos Data: ";
            var_dump($productosData);
            echo PHP_EOL;
    
            // Fetch existing product data
            $existingProductIds = array_column($model->getProductosPorVenta()->asArray()->all(), 'id');
    
            // Prepare new product IDs from the form data
            $newProductIds = array_column($productosData, 'id');
            
            // Delete products that are no longer in the form submission
            foreach ($existingProductIds as $existingProductId) {
                if (!in_array($existingProductId, $newProductIds)) {
                    $productoToDelete = ProductosPorVenta::findOne($existingProductId);
                    if ($productoToDelete) {
                        $productoToDelete->delete();
                    }
                }
            }
    
            // Update or create new products
            foreach ($productosData as $productoData) {
                if (isset($productoData['id']) && $productoData['id']) {
                    $producto = ProductosPorVenta::findOne($productoData['id']);
                    if ($producto) {
                        $producto->attributes = $productoData;
                        $producto->save();
                    }
                } else {
                    $newProducto = new ProductosPorVenta();
                    $newProducto->attributes = $productoData;
                    $newProducto->id_venta = $model->id_venta; // Ensure it links to the current sale
                    $newProducto->save();
                }
            }
    
            return $this->redirect(['view', 'id' => $model->id_venta]);
        }
    
        $productos = CatProductos::find()->all();
        $productosDropdown = [];
    
        foreach ($productos as $producto) {
            $productosDropdown[$producto->id_producto] = $producto->sabores->sabor . ' - ' . $producto->presentaciones->presentacion;
        }
    
        $id_evento = Yii::$app->session->get('id_evento');
    
        // Fetch existing product data
        $existingProductData = $model->getProductosPorVenta()->asArray()->all();
    
        return $this->render('update', [
            'model' => $model,
            'id_evento' => $id_evento,
            'productosDropdown' => $productosDropdown,
            'existingProductData' => $existingProductData,
        ]);
    }
    

        
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

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