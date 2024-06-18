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
    public function actionIndex()
    
    {
        return $this->render('index');
    }


    public function actionCreate(){

        $model = new Ventas();

        if ($model->load(Yii::$app->request->post())) {
			$model->save();
            return $this->redirect(['view', 'id' => $model->id_venta]);
        }
        else{
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


    public function actionUpdate($id){

        $model= new Ventas();
        return $this->render('update');
    }

}
