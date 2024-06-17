<?php


namespace app\controllers;

use Yii;
use app\models\Ventas;
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

        return $this->render('create', [
            'model' => $model,
        ]);
        
    }

    public function actionUpdate(){

        $model= new Ventas();
        return $this->render('update');
    }

}
