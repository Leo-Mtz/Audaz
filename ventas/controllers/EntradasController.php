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
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        $entradasData = Yii::$app->request->post('Entradas')['entradas'] ?? [];

        // Start a database transaction
        $transaction = Yii::$app->db->beginTransaction();
        try {
            // Remove entries that are no longer present
            $existingEntradaIds = array_column($model->getProductosPorEntradas()->asArray()->all(), 'id');
            $newEntradaIds = array_column($entradasData, 'id');
            foreach ($existingEntradaIds as $existingEntradaId) {
                if (!in_array($existingEntradaId, $newEntradaIds)) {
                    $existingEntrada = ProductosPorEntradas::findOne($existingEntradaId);
                    if ($existingEntrada) {
                        $existingEntrada->delete();
                    }
                }
            }

            // Update or create new entries
            foreach ($entradasData as $entradaData) {
                if (isset($entradaData['id']) && $entradaData['id']) {
                    $entrada = ProductosPorEntradas::findOne($entradaData['id']);
                    if ($entrada) {
                        $entrada->attributes = $entradaData;
                        $entrada->id_producto = $this->getIdProducto($entradaData['id_sabor'], $entradaData['id_presentacion']); // Calculate id_producto
                        if (!$entrada->save()) {
                            Yii::debug($entrada->errors, 'productoPorEntradas_update_errors');
                            throw new \Exception('Failed to update ProductosPorEntradas');
                        }

                        // Update inventory
                        $producto = CatProductos::findOne($entrada->id_producto);
                        if ($producto) {
                            $producto->cantidad_inventario += $entradaData['cantidad_entradas_producto'];
                            if (!$producto->save()) {
                                Yii::debug($producto->errors, 'catproductos_update_errors');
                                throw new \Exception('Failed to update CatProductos inventory');
                            }
                        } else {
                            throw new \Exception('Producto not found');
                        }
                    }
                } else {
                    $newEntrada = new ProductosPorEntradas();
                    $newEntrada->attributes = $entradaData;
                    $newEntrada->id_entradas = $model->id_entradas;
                    $newEntrada->id_producto = $this->getIdProducto($entradaData['id_sabor'], $entradaData['id_presentacion']); // Calculate id_producto

                    if (!$newEntrada->save()) {
                        Yii::debug($newEntrada->errors, 'productoPorEntradas_create_errors');
                        throw new \Exception('Failed to create ProductosPorEntradas');
                    }

                    // Update inventory
                    $producto = CatProductos::findOne($newEntrada->id_producto);
                    if ($producto) {
                        $producto->cantidad_inventario += $entradaData['cantidad_entradas_producto'];
                        if (!$producto->save()) {
                            Yii::debug($producto->errors, 'catproductos_create_errors');
                            throw new \Exception('Failed to update CatProductos inventory');
                        }
                    } else {
                        throw new \Exception('Producto not found');
                    }
                }
            }

            $transaction->commit();
            Yii::$app->session->setFlash('success', 'Entrada actualizada exitosamente');
            return $this->redirect(['view', 'id' => $model->id_entradas]);
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
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
        $model= $this->findModel($id);
        $productosPorEntrada = ProductosPorEntradas::findAll(['id_entradas' => $id]);
        foreach ($productosPorEntrada as $productoPorEntrada) {
            $productoPorEntrada->delete();
        
        }

        $model->delete();
        return  $this->redirect(['index']);
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

