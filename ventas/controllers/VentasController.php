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


    
    public function actionCreate()
    {
        $model = new Ventas();
    
        echo 'Entered actionCreate method';
        var_dump('Entered actionCreate method');
    
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

    public function actionUpdate($id){

        $model= $this->findModel($id);

        $model->fecha = Yii::$app->formatter->asDate('now', 'php:Y-m-d');
    date_default_timezone_set('America/Mexico_City'); // Set the timezone to Mexico City

    if (Yii::$app->request->isPost) {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (isset(Yii::$app->request->post('Ventas')['productos'])) {
                $productos = Yii::$app->request->post('Ventas')['productos'];

                foreach ($productos as $productoData) {
                    $productoPorVenta = new ProductosPorVenta();
                    $productoPorVenta->id_venta = $model->id_venta;
                    $productoPorVenta->id_producto = $productoData['id_producto'];
                    $productoPorVenta->cantidad_vendida = $productoData['cantidad_vendida'];
                //    $productoPorVenta->precio_unitario = $productoData['precio_unitario'];
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
    }

    $productos = CatProductos::find()->all();
    $productosDropdown = [];
    foreach ($productos as $producto) {
        $productosDropdown[$producto->id_producto] = $producto->sabores->sabor . ' - ' . $producto->presentaciones->presentacion;
    }

    $eventos = ArrayHelper::map(CatEventos::find()->all(), 'id_evento', 'evento');

    return $this->render('create', [
        'model' => $model,
        'productosDropdown' => $productosDropdown,
        'eventos' => $eventos,
    ]);
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