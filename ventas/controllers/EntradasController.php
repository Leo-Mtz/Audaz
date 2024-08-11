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

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        // Save productos_por_entradas and update inventory
        if (isset(Yii::$app->request->post('Entradas')['entradas'])) {
            $entradas = Yii::$app->request->post('Entradas')['entradas'];

            // Start a database transaction
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($entradas as $entradaData) {
                    $idProducto = $this->getIdProducto($entradaData['id_sabor'], $entradaData['id_presentacion']);

                    $productoEntrada = new ProductosPorEntradas();
                    $productoEntrada->id_entradas = $model->id_entradas;
                    $productoEntrada->id_sabor = $entradaData['id_sabor'];
                    $productoEntrada->id_presentacion = $entradaData['id_presentacion'];
                    $productoEntrada->id_producto = $idProducto;
                    $productoEntrada->cantidad_entradas_producto = $entradaData['cantidad_entradas_producto'];

                    if (!$productoEntrada->save()) {
                        Yii::debug($productoEntrada->errors, 'productoPorEntradas_errors');
                        throw new \Exception('Failed to save ProductosPorEntradas');
                    }

                    // Update cantidad_inventario in catproductos
                    $producto = CatProductos::findOne($idProducto);
                    if ($producto) {
                        $producto->cantidad_inventario += $entradaData['cantidad_entradas_producto'];
                        if (!$producto->save()) {
                            Yii::debug($producto->errors, 'catproductos_errors');
                            throw new \Exception('Failed to update CatProductos inventory');
                        }
                    } else {
                        throw new \Exception('Producto not found');
                    }
                }

                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id_entradas]);
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
    } else {
        Yii::debug($model->errors, 'entradas_save_errors');
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
    // Encuentra el modelo de entrada
    $model = $this->findModel($id);

    // Cargar los datos del formulario en el modelo
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        // Obtener los datos de entradas del formulario
        $entradasData = Yii::$app->request->post('Entradas')['entradas'] ?? [];
        $existingEntradaIds = array_column($model->getProductosPorEntradas()->asArray()->all(), 'id');
        $newEntradaIds = array_column($entradasData, 'id');

        // Manejar eliminaciones
        foreach ($existingEntradaIds as $existingEntradaId) {
            if (!in_array($existingEntradaId, $newEntradaIds)) {
                $entradaToDelete = ProductosPorEntradas::findOne($existingEntradaId);
                if ($entradaToDelete) {
                    // Actualizar inventario antes de eliminar
                    $producto = CatProductos::findOne($entradaToDelete->id_producto);
                    if ($producto) {
                        $producto->cantidad_inventario -= $entradaToDelete->cantidad_entradas_producto;
                        if ($producto->cantidad_inventario < 0) {
                            $producto->cantidad_inventario = 0; // O maneja el caso según tus necesidades
                        }
                        if (!$producto->save()) {
                            Yii::debug($producto->errors, 'catproductos_errors');
                            throw new \Exception('Failed to update CatProductos inventory');
                        }
                    } else {
                        throw new \Exception('Producto not found');
                    }

                    // Eliminar la entrada
                    $entradaToDelete->delete();
                }
            }
        }

        // Manejar actualizaciones y creaciones
        foreach ($entradasData as $entradaData) {
            if (isset($entradaData['id']) && $entradaData['id']) {
                $entrada = ProductosPorEntradas::findOne($entradaData['id']);
                if ($entrada) {
                    // Obtener cantidad antigua
                    $cantidadAntigua = $entrada->cantidad_entradas_producto;

                    // Actualizar datos de la entrada
                    $entrada->attributes = $entradaData;
                    $entrada->id_producto = $this->getIdProducto($entradaData['id_sabor'], $entradaData['id_presentacion']);
                    $entrada->id_entradas = $model->id_entradas;
                    if ($entrada->save()) {
                       
                        $entrada->updateInventory($cantidadAntigua); // Pasar la cantidad antigua

                    } else {
                        Yii::debug($entrada->errors, 'productos_por_entradas_update_errors');
                        throw new \Exception('Failed to save ProductosPorEntradas');

                    }

                    // Actualizar inventario
                 }
            } else {
                $newEntrada = new ProductosPorEntradas();
                $newEntrada->attributes = $entradaData;
                $newEntrada->id_producto = $this->getIdProducto($entradaData['id_sabor'], $entradaData['id_presentacion']);
                $newEntrada->id_entradas = $model->id_entradas;
                if (!$newEntrada->save()) {
                    Yii::debug($newEntrada->errors, 'productos_por_entradas_create_errors');
                    throw new \Exception('Failed to save ProductosPorEntradas');
                }

                // Actualizar inventario para la nueva entrada
                $newEntrada->updateInventory(); // Llamar a updateInventory() después de guardar
            }
        }

        Yii::$app->session->setFlash('success', 'Entrada updated and stock adjusted.');
        return $this->redirect(['view', 'id' => $model->id_entradas]);
    }

    // Preparar datos para dropdowns
    $empleados = ArrayHelper::map(CatEmpleados::find()->all(), 'id_empleado', function($model) {
        return $model['nombre'].' '.$model['paterno'].' '.$model['materno'];
    });
    $eventos = ArrayHelper::map(CatEventos::find()->all(), 'id_evento', 'evento');
    $saboresIds = CatProductos::find()->select('id_sabor')->distinct()->column();
    $sabores1 = CatSabores::find()->where(['id_sabor' => $saboresIds])->all();
    $sabores = ArrayHelper::map($sabores1, 'id_sabor', 'sabor');
    $presentacionesList = [];
    $existingEntrada = $model->getProductosPorEntradas()->asArray()->all();

    return $this->render('update', [
        'model' => $model,
        'empleados' => $empleados,
        'eventos' => $eventos,
        'sabores' => $sabores,
        'presentacionesList' => $presentacionesList,
        'existingEntrada' => $existingEntrada
    ]);
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



    /**
     * Deletes an existing Entradas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

     public function actionDelete($id)
     {
         $model = $this->findModel($id);
     
         // Encuentra todos los registros de ProductosPorEntradas asociados
         $productosPorEntrada = ProductosPorEntradas::findAll(['id_entradas' => $id]);
     
         // Comienza una transacción para asegurar la integridad de los datos
         $transaction = Yii::$app->db->beginTransaction();
         
         try {
             foreach ($productosPorEntrada as $productoPorEntrada) {
                 // Encuentra el producto asociado
                 $producto = CatProductos::findOne($productoPorEntrada->id_producto);
     
                 if ($producto) {
                     // Resta la cantidad de entrada al inventario
                     $producto->cantidad_inventario -= $productoPorEntrada->cantidad_entradas_producto;
     
                     // Asegúrate de que el inventario no sea negativo
                     if ($producto->cantidad_inventario < 0) {
                         $producto->cantidad_inventario = 0; // O maneja el caso según tus necesidades
                     }
     
                     if (!$producto->save()) {
                         Yii::debug($producto->errors, 'catproductos_errors');
                         throw new \Exception('Failed to update CatProductos inventory');
                     }
                 } else {
                     throw new \Exception('Producto not found');
                 }
     
                 // Elimina el registro de ProductosPorEntradas
                 $productoPorEntrada->delete();
             }
     
             // Elimina la entrada principal
             $model->delete();
     
             // Confirma la transacción
             $transaction->commit();
     
             return $this->redirect(['index']);
         } catch (\Exception $e) {
             // Revierte la transacción en caso de error
             $transaction->rollBack();
             Yii::$app->session->setFlash('error', $e->getMessage());
             return $this->redirect(['index']);
         }
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

