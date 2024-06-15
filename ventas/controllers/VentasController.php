<?php

namespace app\controllers;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ventas;
class VentasController extends \yii\web\Controller
{
    public function actionIndex()
    
    {
        return $this->render('index');
    }


    public function actionCreate(){

        $model= new Ventas();

        return $this->render('create');
        
    }

    public function actionUpdate(){

        $model= new Ventas();
        return $this->render('update');
    }

}
